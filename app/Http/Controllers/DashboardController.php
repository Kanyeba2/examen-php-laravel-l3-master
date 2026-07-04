<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\AdoptionRequest;
use App\Models\Animal;
use App\Models\CmsContent;
use App\Models\FollowUp;
use App\Models\MobilePayment;
use App\Models\User;
use App\Notifications\StatutCompteUtilisateurNotification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    // Construit les dashboards client, manager et administrateur.
    public function admin(\Illuminate\Http\Request $request): View
    {
        $periode = $request->string('periode')->value();
        $nombreJours = match ($periode) {
            '7j' => 7,
            '90j' => 90,
            default => 30,
        };

        $dateDebut = now()->subDays($nombreJours - 1)->startOfDay();
        $dateFin = now()->endOfDay();

        $debutMois = now()->startOfMonth();
        $finMois = now()->endOfMonth();

        $stats = [
            'users' => User::count(),
            'active_users' => User::where('actif', true)->count(),
            'inactive_users' => User::where('actif', false)->count(),
            'animals' => Animal::count(),
            'requests' => AdoptionRequest::count(),
            'pending' => AdoptionRequest::where('statut', 'en_attente')->count(),
            'adopters' => User::where('role', 'client')->count(),
            'adoptions_this_month' => AdoptionRequest::where('statut', 'approuve')
                ->whereBetween('updated_at', [$debutMois, $finMois])
                ->count(),
            'requests_this_month' => AdoptionRequest::whereBetween('created_at', [$debutMois, $finMois])->count(),
            'users_this_month' => User::whereBetween('created_at', [$debutMois, $finMois])->count(),
        ];

        $users = User::latest()->paginate(10, ['*'], 'users_page');
        $recentUsers = User::latest()->take(5)->get();
        $recentRequests = AdoptionRequest::with('utilisateur', 'animal')->latest()->take(5)->get();
        $logsQuery = ActivityLog::with('user')->latest();

        if ($request->filled('log_action')) {
            $logsQuery->where('action', 'like', '%'.$request->string('log_action')->value().'%');
        }

        if ($request->filled('log_entity')) {
            $logsQuery->where('type_entite', 'like', '%'.$request->string('log_entity')->value().'%');
        }

        if ($request->filled('log_user')) {
            $nomUtilisateur = $request->string('log_user')->trim()->value();
            $logsQuery->whereHas('user', function ($sub) use ($nomUtilisateur) {
                $sub->where('nom', 'like', '%'.$nomUtilisateur.'%');
            });
        }

        if ($request->filled('log_level')) {
            $requestedLevel = $request->string('log_level')->value();
            if ($requestedLevel === 'warning') {
                $logsQuery->where(function ($sub) {
                    $sub->where('action', 'like', '%echec%')
                        ->orWhere('action', 'like', '%refus%')
                        ->orWhere('description', 'like', '%echec%')
                        ->orWhere('description', 'like', '%inactif%')
                        ->orWhere('description', 'like', '%invalide%');
                });
            }
        }

        if ($request->filled('log_from')) {
            $logsQuery->whereDate('created_at', '>=', $request->date('log_from'));
        }

        if ($request->filled('log_to')) {
            $logsQuery->whereDate('created_at', '<=', $request->date('log_to'));
        }

        if ($request->filled('log_search')) {
            $term = $request->string('log_search')->trim()->value();
            $logsQuery->where(function ($sub) use ($term) {
                $sub->where('action', 'like', '%'.$term.'%')
                    ->orWhere('description', 'like', '%'.$term.'%')
                    ->orWhere('type_entite', 'like', '%'.$term.'%')
                    ->orWhereHas('user', function ($queryUser) use ($term) {
                        $queryUser->where('nom', 'like', '%'.$term.'%');
                    });
            });
        }

        $logsParPage = $request->routeIs('admin.logs.index') ? 5 : 15;
        $logs = $logsQuery->paginate($logsParPage, ['*'], 'logs_page')->withQueryString();

        $requestStatuses = AdoptionRequest::selectRaw('statut, COUNT(*) as total')
            ->groupBy('statut')
            ->pluck('total', 'statut');

        $roleDistribution = User::selectRaw('role, COUNT(*) as total')
            ->groupBy('role')
            ->pluck('total', 'role');

        $repartitionEspeces = Animal::selectRaw('espece, COUNT(*) as total')
            ->groupBy('espece')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $serieDemandesParJour = AdoptionRequest::selectRaw('DATE(created_at) as jour, COUNT(*) as total')
            ->whereBetween('created_at', [$dateDebut, $dateFin])
            ->groupBy('jour')
            ->pluck('total', 'jour');

        $serieAdoptionsParJour = AdoptionRequest::selectRaw('DATE(updated_at) as jour, COUNT(*) as total')
            ->where('statut', 'approuve')
            ->whereBetween('updated_at', [$dateDebut, $dateFin])
            ->groupBy('jour')
            ->pluck('total', 'jour');

        $libellesJours = [];
        $valeursDemandes = [];
        $valeursAdoptions = [];

        for ($date = $dateDebut->copy(); $date->lte($dateFin); $date->addDay()) {
            $cleJour = $date->toDateString();
            $libellesJours[] = $date->isoFormat('D MMM');
            $valeursDemandes[] = (int) ($serieDemandesParJour[$cleJour] ?? 0);
            $valeursAdoptions[] = (int) ($serieAdoptionsParJour[$cleJour] ?? 0);
        }

        $libellesMois = [];
        $valeursAdoptionsMois = [];
        for ($i = 5; $i >= 0; $i--) {
            $mois = Carbon::now()->subMonths($i);
            $libellesMois[] = $mois->isoFormat('MMM');
            $valeursAdoptionsMois[] = AdoptionRequest::where('statut', 'approuve')
                ->whereYear('updated_at', $mois->year)
                ->whereMonth('updated_at', $mois->month)
                ->count();
        }

        $chartData = [
            'roles' => [
                'labels' => ['Admin', 'Manager', 'Client'],
                'values' => [
                    (int) ($roleDistribution['admin'] ?? 0),
                    (int) ($roleDistribution['manager'] ?? 0),
                    (int) ($roleDistribution['client'] ?? 0),
                ],
            ],
            'requests' => [
                'labels' => ['En attente', 'Approuvee', 'Rejetee'],
                'values' => [
                    (int) ($requestStatuses['en_attente'] ?? 0),
                    (int) ($requestStatuses['approuve'] ?? 0),
                    (int) ($requestStatuses['rejete'] ?? 0),
                ],
            ],
            'courbeDemandes' => [
                'labels' => $libellesJours,
                'demandes' => $valeursDemandes,
                'adoptions' => $valeursAdoptions,
            ],
            'adoptionsMensuelles' => [
                'labels' => $libellesMois,
                'values' => $valeursAdoptionsMois,
            ],
            'repartitionEspeces' => [
                'labels' => $repartitionEspeces->pluck('espece')->toArray(),
                'values' => $repartitionEspeces->pluck('total')->map(fn ($v) => (int) $v)->toArray(),
            ],
        ];

        $pendingAlerts = AdoptionRequest::with(['utilisateur', 'animal'])
            ->where('statut', 'en_attente')
            ->latest()
            ->take(5)
            ->get();

        $managedAnimals = Animal::latest()->take(6)->get();

        if ($request->routeIs('admin.logs.index')) {
            return view('admin.logs', compact('logs'));
        }

        return view('dashboard.admin', compact(
            'stats',
            'users',
            'recentUsers',
            'recentRequests',
            'logs',
            'chartData',
            'pendingAlerts',
            'managedAnimals',
            'periode'
        ));
    }

    public function searchLogs(\Illuminate\Http\Request $request): JsonResponse
    {
        $term = $request->string('q')->trim()->value();

        $items = ActivityLog::with('user')
            ->when($term !== '', function ($query) use ($term) {
                $query->where(function ($sub) use ($term) {
                    $sub->where('action', 'like', '%'.$term.'%')
                        ->orWhere('description', 'like', '%'.$term.'%')
                        ->orWhere('type_entite', 'like', '%'.$term.'%');
                });
            })
            ->latest()
            ->limit(12)
            ->get()
            ->map(function (ActivityLog $log) {
                return [
                    'id' => $log->id,
                    'created_at' => $log->created_at?->format('d/m/Y H:i'),
                    'action' => $log->action,
                    'entity' => $log->type_entite,
                    'description' => $log->description,
                    'user' => $log->user->nom ?? 'Systeme',
                ];
            });

        return response()->json([
            'code' => 200,
            'message' => 'Logs recuperes.',
            'data' => $items,
        ]);
    }

    public function toggleUserActive(User $user): RedirectResponse
    {
        if (Auth::id() === $user->id) {
            return back()->withErrors(['user' => 'Vous ne pouvez pas desactiver votre propre compte.']);
        }

        if ($user->role === 'admin' && $user->actif && User::where('role', 'admin')->where('actif', true)->count() <= 1) {
            return back()->withErrors(['user' => 'Impossible de desactiver le dernier administrateur actif.']);
        }

        $newState = ! $user->actif;
        $user->update(['actif' => $newState]);
        $user->notify(new StatutCompteUtilisateurNotification($newState));

        ActivityLog::trace(
            Auth::id(),
            'maj_statut_utilisateur',
            'user',
            $user->id,
            sprintf('Statut du compte %s mis a %s.', $user->email, $newState ? 'actif' : 'inactif'),
        );

        return back()->with('success', 'Statut utilisateur mis a jour avec succes.');
    }

    public function destroyUser(User $user): RedirectResponse
    {
        if (Auth::id() === $user->id) {
            return back()->withErrors(['user' => 'Vous ne pouvez pas supprimer votre propre compte.']);
        }

        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->withErrors(['user' => 'Impossible de supprimer le dernier administrateur.']);
        }

        $deletedUserId = $user->id;
        $deletedUserEmail = $user->email;
        $user->delete();

        ActivityLog::trace(
            Auth::id(),
            'suppression_utilisateur',
            'user',
            $deletedUserId,
            sprintf('Suppression du compte utilisateur %s.', $deletedUserEmail),
            'warning',
        );

        return back()->with('success', 'Utilisateur supprime avec succes.');
    }

    public function manager(): View
    {
        $stats = [
            'animals_total' => Animal::count(),
            'animals_disponibles' => Animal::where('statut', 'disponible')->count(),
            'requests_total' => AdoptionRequest::count(),
            'requests_pending' => AdoptionRequest::where('statut', 'en_attente')->count(),
            'requests_approved' => AdoptionRequest::where('statut', 'approuve')->count(),
            'followups_total' => FollowUp::count(),
            'followups_open' => FollowUp::whereIn('statut', ['en_cours', 'a_planifier'])->count(),
            'adoptions_sans_paiement' => AdoptionRequest::where('statut', 'approuve')
                ->whereDoesntHave('paiementsMobiles', function ($query) {
                    $query->where('statut', 'reussi');
                })
                ->count(),
        ];

        $demandesPrioritaires = AdoptionRequest::with(['utilisateur', 'animal', 'suivis.utilisateur'])
            ->latest()
            ->take(5)
            ->get();

        $demandesEnAttente = AdoptionRequest::with(['utilisateur', 'animal'])
            ->where('statut', 'en_attente')
            ->latest()
            ->take(5)
            ->get();

        $suivisRecents = FollowUp::with(['utilisateur', 'demandeAdoption.animal', 'demandeAdoption.utilisateur'])
            ->latest()
            ->take(5)
            ->get();

        $animauxRecents = Animal::latest()->take(4)->get();

        return view('dashboard.manager', compact(
            'stats',
            'demandesPrioritaires',
            'demandesEnAttente',
            'suivisRecents',
            'animauxRecents'
        ));
    }

    public function client(\Illuminate\Http\Request $request): View
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $afficherFavoris = $request->string('vue_animaux')->value() === 'favoris';
        $idsAnimauxFavoris = $user->favorisAnimaux()->pluck('animaux.id');

        $requests = AdoptionRequest::where('utilisateur_id', Auth::id())
            ->with('animal')
            ->latest()
            ->paginate(10);

        $recentRequests = AdoptionRequest::where('utilisateur_id', Auth::id())
            ->with('animal')
            ->latest()
            ->take(3)
            ->get();

        $featuredAnimalsQuery = Animal::query()
            ->where('statut', 'disponible')
            ->latest();

        if ($afficherFavoris) {
            $featuredAnimalsQuery->whereIn('id', $idsAnimauxFavoris);
        }

        $featuredAnimals = $featuredAnimalsQuery
            ->take(8)
            ->get();

        $stats = [
            'demandes_total' => AdoptionRequest::where('utilisateur_id', Auth::id())->count(),
            'demandes_en_attente' => AdoptionRequest::where('utilisateur_id', Auth::id())->where('statut', 'en_attente')->count(),
            'animaux_disponibles' => Animal::where('statut', 'disponible')->count(),
            'favoris_total' => $idsAnimauxFavoris->count(),
        ];

        return view('dashboard.client', compact(
            'requests',
            'recentRequests',
            'featuredAnimals',
            'stats',
            'afficherFavoris',
            'idsAnimauxFavoris'
        ));
    }

    public function adoptants(): View
    {
        $adoptantsQuery = User::where('role', 'client')
            ->whereHas('demandesAdoption', function ($query) {
                $query->where('statut', 'approuve')
                    ->whereHas('paiementsMobiles', function ($paiementsQuery) {
                        $paiementsQuery->where('statut', 'reussi');
                    });
            })
            ->withCount([
                'demandesAdoption as animaux_adoptes' => function ($query) {
                    $query->where('statut', 'approuve')
                        ->whereHas('paiementsMobiles', function ($paiementsQuery) {
                            $paiementsQuery->where('statut', 'reussi');
                        });
                },
            ])
            ->with(['demandesAdoption' => function ($query) {
                $query->where('statut', 'approuve')
                    ->whereHas('paiementsMobiles', function ($paiementsQuery) {
                        $paiementsQuery->where('statut', 'reussi');
                    })
                    ->with(['animal', 'paiementsMobiles' => function ($paiementsQuery) {
                        $paiementsQuery->where('statut', 'reussi')->latest();
                    }])
                    ->latest();
            }]);

        $resumeAdoptants = (clone $adoptantsQuery)->get();

        $montantTotalEncaisse = $resumeAdoptants->sum(function (User $adoptant) {
            return $adoptant->demandesAdoption->sum(function (AdoptionRequest $demande) {
                return $demande->paiementsMobiles->where('statut', 'reussi')->sum('montant');
            });
        });

        $adoptants = $adoptantsQuery
            ->latest()
            ->paginate(6, ['*'], 'adoptants_page');

        $adoptants->getCollection()->transform(function (User $adoptant) {
            $adoptant->montant_total_paye = $adoptant->demandesAdoption->sum(function (AdoptionRequest $demande) {
                return $demande->paiementsMobiles->where('statut', 'reussi')->sum('montant');
            });

            return $adoptant;
        });

        return view('admin.adoptants', compact('adoptants', 'montantTotalEncaisse'));
    }

    public function paiements(): View
    {
        $paymentsQuery = MobilePayment::with([
            'utilisateur',
            'demandeAdoption.animal',
            'demandeAdoption.utilisateur',
        ])->latest();

        if (request()->filled('statut')) {
            $paymentsQuery->where('statut', request()->string('statut')->value());
        }

        if (request()->filled('fournisseur')) {
            $paymentsQuery->where('fournisseur', request()->string('fournisseur')->value());
        }

        if (request()->filled('client')) {
            $clientTerm = request()->string('client')->trim()->value();
            $paymentsQuery->whereHas('utilisateur', function ($query) use ($clientTerm) {
                $query->where('nom', 'like', '%'.$clientTerm.'%')
                    ->orWhere('email', 'like', '%'.$clientTerm.'%');
            });
        }

        if (request()->filled('animal')) {
            $animalTerm = request()->string('animal')->trim()->value();
            $paymentsQuery->whereHas('demandeAdoption.animal', function ($query) use ($animalTerm) {
                $query->where('nom', 'like', '%'.$animalTerm.'%')
                    ->orWhere('espece', 'like', '%'.$animalTerm.'%');
            });
        }

        if (request()->filled('date_from')) {
            $paymentsQuery->whereDate('created_at', '>=', request()->date('date_from'));
        }

        if (request()->filled('date_to')) {
            $paymentsQuery->whereDate('created_at', '<=', request()->date('date_to'));
        }

        if (request()->filled('search')) {
            $term = request()->string('search')->trim()->value();
            $paymentsQuery->where(function ($query) use ($term) {
                $query->where('reference_interne', 'like', '%'.$term.'%')
                    ->orWhere('reference_fournisseur', 'like', '%'.$term.'%')
                    ->orWhere('numero_telephone', 'like', '%'.$term.'%')
                    ->orWhereHas('utilisateur', function ($userQuery) use ($term) {
                        $userQuery->where('nom', 'like', '%'.$term.'%')
                            ->orWhere('email', 'like', '%'.$term.'%');
                    })
                    ->orWhereHas('demandeAdoption.animal', function ($animalQuery) use ($term) {
                        $animalQuery->where('nom', 'like', '%'.$term.'%')
                            ->orWhere('espece', 'like', '%'.$term.'%');
                    });
            });
        }

        $payments = $paymentsQuery->paginate(10)->withQueryString();

        $paymentStats = [
            'total' => MobilePayment::count(),
            'reussi' => MobilePayment::where('statut', 'reussi')->count(),
            'en_attente' => MobilePayment::where('statut', 'en_attente')->count(),
            'echoue' => MobilePayment::where('statut', 'echoue')->count(),
            'montant_total' => (float) MobilePayment::where('statut', 'reussi')->sum('montant'),
        ];

        $recentPayments = MobilePayment::with(['utilisateur', 'demandeAdoption.animal'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.paiements', compact('payments', 'paymentStats', 'recentPayments'));
    }

    public function suiviPostAdoption(): View
    {
        $suivis = FollowUp::with([
            'utilisateur',
            'demandeAdoption.animal',
            'demandeAdoption.utilisateur',
            'demandeAdoption.paiementsMobiles' => function ($query) {
                $query->latest();
            },
        ])
            ->whereHas('demandeAdoption', function ($query) {
                $query->where('statut', 'approuve')
                    ->whereHas('paiementsMobiles', function ($paiementsQuery) {
                        $paiementsQuery->where('statut', 'reussi');
                    });
            })
            ->latest()
            ->paginate(8, ['*'], 'suivis_page');

        return view('admin.suivi-post-adoption', compact('suivis'));
    }

    public function articlesConseils(): View
    {
        $contenus = CmsContent::query()
            ->whereIn('type', ['article', 'conseil'])
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get();

        $articles = $contenus->where('type', 'article')->values();
        $conseils = $contenus->where('type', 'conseil')->values();

        $stats = [
            'articles_publies' => $articles->where('status', 'published')->count(),
            'brouillons' => $contenus->where('status', 'draft')->count(),
            'publications_mois' => CmsContent::whereIn('type', ['article', 'conseil'])
                ->where('status', 'published')
                ->whereBetween('published_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->count(),
            'conseils_actifs' => $conseils->where('status', 'published')->count(),
        ];

        return view('admin.articles-conseils', compact('stats', 'articles', 'conseils'));
    }

    public function pagesCms(): View
    {
        $pages = CmsContent::query()
            ->where('type', 'page')
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get();

        $stats = [
            'pages_publiées' => $pages->where('status', 'published')->count(),
            'pages_brouillon' => $pages->where('status', 'draft')->count(),
            'pages_archives' => $pages->where('status', 'archived')->count(),
            'taux_maj' => $pages->count() > 0
                ? round(($pages->where('status', 'published')->count() / $pages->count()) * 100).'%'
                : '0%',
        ];

        $blocs = collect([
            [
                'nom' => 'Bannière principale',
                'etat' => 'Actif',
                'priorite' => 'Haute',
            ],
            [
                'nom' => 'Bloc témoignages',
                'etat' => 'Actif',
                'priorite' => 'Moyenne',
            ],
            [
                'nom' => 'Bloc conseils rapides',
                'etat' => 'Actif',
                'priorite' => 'Haute',
            ],
        ]);

        return view('admin.pages', compact('stats', 'pages', 'blocs'));
    }
}
