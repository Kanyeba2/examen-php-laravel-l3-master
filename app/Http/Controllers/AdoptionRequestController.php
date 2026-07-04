<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdoptionRequest;
use App\Http\Requests\UpdateAdoptionStatusRequest;
use App\Mail\ConfirmationActionImportante;
use App\Mail\NotificationStatutDemande;
use App\Models\AdoptionRequest;
use App\Models\Animal;
use App\Models\ParametreSysteme;
use App\Models\User;
use App\Notifications\NouvelleDemandeAdoptionNotification;
use App\Notifications\StatutDemandeAdoptionNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class AdoptionRequestController extends Controller
{
    public function index(): View
    {
        $requests = AdoptionRequest::with([
            'utilisateur',
            'animal',
            'paiementsMobiles' => function ($query) {
                $query->latest();
            },
        ])
            ->latest()
            ->paginate(8);

        return view('adoptions.index', compact('requests'));
    }

    public function create(Animal $animal): View
    {
        $etatDemande = null;
        $prixAdoption = $animal->prix_adoption ?? ParametreSysteme::obtenirValeur('default_adoption_fee', '100');

        if (Auth::check()) {
            $etatDemande = $this->resumeDemandePourUtilisateur($animal, (int) Auth::id());
        }

        return view('adoptions.create', compact('animal', 'etatDemande', 'prixAdoption'));
    }

    public function store(StoreAdoptionRequest $request, Animal $animal): RedirectResponse
    {
        $etatDemande = $this->resumeDemandePourUtilisateur($animal, (int) Auth::id());

        if ($etatDemande['deja_adopte']) {
            return redirect()
                ->route('animals.show', $animal)
                ->with('info', 'Vous avez deja adopte cet animal: demande approuvee et paiement confirme.');
        }

        if ($etatDemande['demande_deja_existante']) {
            return redirect()
                ->route('animals.show', $animal)
                ->with('info', 'Vous avez deja une demande en cours pour cet animal.');
        }

        if ($animal->statut === 'adopte') {
            return redirect()
                ->route('animals.show', $animal)
                ->with('info', 'Cet animal est deja adopte.');
        }

        $demande = AdoptionRequest::create([
            'utilisateur_id' => Auth::id(),
            'animal_id' => $animal->id,
            'message' => $request->message,
            'statut' => 'en_attente',
        ]);

        $demande->load(['utilisateur', 'animal']);

        Mail::to($demande->utilisateur->email)->queue(new ConfirmationActionImportante($demande));

        $adminRecipients = User::whereIn('role', ['admin', 'manager'])
            ->where('actif', true)
            ->get();

        Notification::send($adminRecipients, new NouvelleDemandeAdoptionNotification($demande));

        return redirect()->route('animals.show', $animal)->with('success', 'Demande d’adoption envoyée.');
    }

    public function updateStatus(UpdateAdoptionStatusRequest $request, AdoptionRequest $adoptionRequest): RedirectResponse
    {
        $adoptionRequest->update(['statut' => $request->validated('statut')]);

        $adoptionRequest->load(['utilisateur', 'animal']);

        if ($adoptionRequest->statut === 'approuve') {
            $paiementReussi = $adoptionRequest->paiementsMobiles()
                ->where('statut', 'reussi')
                ->exists();

            if ($paiementReussi && $adoptionRequest->animal && $adoptionRequest->animal->statut !== 'adopte') {
                $adoptionRequest->animal->update(['statut' => 'adopte']);
            }
        }

        Mail::to($adoptionRequest->utilisateur->email)->queue(new NotificationStatutDemande($adoptionRequest));
        $adoptionRequest->utilisateur->notify(new StatutDemandeAdoptionNotification($adoptionRequest));

        return back()->with('success', 'Statut de demande mis à jour.');
    }

    private function resumeDemandePourUtilisateur(Animal $animal, int $utilisateurId): array
    {
        $demande = AdoptionRequest::with(['paiementsMobiles' => function ($query) {
            $query->latest();
        }])
            ->where('utilisateur_id', $utilisateurId)
            ->where('animal_id', $animal->id)
            ->latest()
            ->first();

        $paiementReussi = $demande
            ? $demande->paiementsMobiles->contains(fn ($paiement) => $paiement->statut === 'reussi')
            : false;

        $dejaAdopte = (bool) $demande
            && $demande->statut === 'approuve'
            && $paiementReussi;

        $demandeDejaExistante = (bool) $demande
            && in_array($demande->statut, ['en_attente', 'approuve'], true)
            && ! $dejaAdopte;

        return [
            'demande' => $demande,
            'paiement_reussi' => $paiementReussi,
            'deja_adopte' => $dejaAdopte,
            'demande_deja_existante' => $demandeDejaExistante,
        ];
    }
}
