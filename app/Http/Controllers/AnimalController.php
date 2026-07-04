<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Models\AdoptionRequest;
use App\Models\ActivityLog;
use App\Models\Animal;
use App\Models\ParametreSysteme;
use App\Support\ImageThumbnail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AnimalController extends Controller
{
    // Porte le CRUD des animaux et les filtres de consultation.
    public function index(Request $request): View
    {
        // Keep query composition in one place so search + filter remain easy to maintain.
        $query = Animal::query();
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($request->filled('search')) {
            $search = $request->string('search')->trim()->value();

            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('nom', 'like', '%' . $search . '%')
                    ->orWhere('espece', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('espece')) {
            $query->where('espece', $request->string('espece')->value());
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->string('genre')->value());
        }

        if ($request->filled('taille')) {
            $query->where('taille', $request->string('taille')->value());
        }

        if ($request->filled('lieu')) {
            $query->where('localisation', 'like', '%' . $request->string('lieu')->trim()->value() . '%');
        }

        if ($request->filled('age_bucket')) {
            $query->where('age', '<=', (int) $request->integer('age_bucket'));
        }

        if ($request->filled('age_min')) {
            $query->where('age', '>=', (int) $request->integer('age_min'));
        }

        if ($request->filled('age_max')) {
            $query->where('age', '<=', (int) $request->integer('age_max'));
        }

        if ($request->boolean('favoris_only') && $user) {
            $query->whereHas('favoriParUtilisateurs', function ($subQuery) use ($user) {
                $subQuery->where('users.id', $user->id);
            });
        }

        $sort = (string) $request->string('sort')->value();

        match ($sort) {
            'age_asc' => $query->orderBy('age')->orderByDesc('id'),
            'age_desc' => $query->orderByDesc('age')->orderByDesc('id'),
            'nom_asc' => $query->orderBy('nom')->orderByDesc('id'),
            default => $query->latest(),
        };

        $animals = $query->paginate(6)->withQueryString();

        $especes = Animal::query()
            ->select('espece')
            ->whereNotNull('espece')
            ->distinct()
            ->orderBy('espece')
            ->pluck('espece');

        $favoriteAnimalIds = $user
            ? $user->favorisAnimaux()->pluck('animaux.id')
            : collect();

        return view('animals.index', compact('animals', 'especes', 'favoriteAnimalIds'));
    }

    public function toggleFavorite(Animal $animal): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $alreadyFavorite = $user->favorisAnimaux()
            ->where('animaux.id', $animal->id)
            ->exists();

        if ($alreadyFavorite) {
            $user->favorisAnimaux()->detach($animal->id);

            return back()->with('success', 'Animal retire des favoris.');
        }

        $user->favorisAnimaux()->attach($animal->id);

        return back()->with('success', 'Animal ajoute aux favoris.');
    }

    public function liveSearch(Request $request): JsonResponse
    {
        $term = $request->string('q')->trim()->value();

        $items = Animal::query()
            ->when($term !== '', function ($query) use ($term) {
                $query->where(function ($sub) use ($term) {
                    $sub->where('nom', 'like', '%'.$term.'%')
                        ->orWhere('espece', 'like', '%'.$term.'%')
                        ->orWhere('race', 'like', '%'.$term.'%')
                        ->orWhere('localisation', 'like', '%'.$term.'%');
                });
            })
            ->latest()
            ->limit(12)
            ->get()
            ->map(fn (Animal $animal) => [
                'id' => $animal->id,
                'nom' => $animal->nom,
                'espece' => $animal->espece,
                'statut' => $animal->statut,
                'url' => route('animals.show', $animal),
            ]);

        return response()->json([
            'code' => 200,
            'message' => 'Resultats recuperes.',
            'data' => $items,
        ]);
    }

    public function create(): View
    {
        return view('animals.create');
    }

    public function store(StoreAnimalRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['cree_par_utilisateur_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('animals/images', 'public');
            $data['chemin_image'] = $imagePath;

            $extension = strtolower((string) $request->file('image')->getClientOriginalExtension());
            $thumbnailPath = 'animals/thumbnails/'.Str::uuid().'.'.$extension;
            $data['chemin_image_miniature'] = ImageThumbnail::generate($imagePath, $thumbnailPath);
        }

        if ($request->hasFile('document')) {
            $data['chemin_document'] = $request->file('document')->store('animals/documents', 'public');
        }

        unset($data['image'], $data['document']);

        $animal = Animal::create($data);

        ActivityLog::trace(
            Auth::id(),
            'creation_animal',
            'animal',
            $animal->id,
            sprintf('Creation de l\'animal %s (%s).', $animal->nom, $animal->espece),
        );

        return redirect()->route('animals.index')->with('success', 'Animal ajouté avec succès.');
    }

    public function show(Animal $animal): View
    {
        $etatDemande = null;
        $prixAdoption = $animal->prix_adoption ?? ParametreSysteme::obtenirValeur('default_adoption_fee', '100');

        if (Auth::check()) {
            $etatDemande = $this->resumeDemandePourUtilisateur($animal, (int) Auth::id());
        }

        return view('animals.show', compact('animal', 'etatDemande', 'prixAdoption'));
    }

    public function edit(Animal $animal): View
    {
        return view('animals.edit', compact('animal'));
    }

    public function update(UpdateAnimalRequest $request, Animal $animal): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($animal->chemin_image) {
                Storage::disk('public')->delete($animal->chemin_image);
            }

            if ($animal->chemin_image_miniature) {
                Storage::disk('public')->delete($animal->chemin_image_miniature);
            }

            $imagePath = $request->file('image')->store('animals/images', 'public');
            $data['chemin_image'] = $imagePath;

            $extension = strtolower((string) $request->file('image')->getClientOriginalExtension());
            $thumbnailPath = 'animals/thumbnails/'.Str::uuid().'.'.$extension;
            $data['chemin_image_miniature'] = ImageThumbnail::generate($imagePath, $thumbnailPath);
        }

        if ($request->hasFile('document')) {
            if ($animal->chemin_document) {
                Storage::disk('public')->delete($animal->chemin_document);
            }

            $data['chemin_document'] = $request->file('document')->store('animals/documents', 'public');
        }

        unset($data['image'], $data['document']);

        $animal->update($data);

        ActivityLog::trace(
            Auth::id(),
            'modification_animal',
            'animal',
            $animal->id,
            sprintf('Modification de l\'animal %s.', $animal->nom),
        );

        return redirect()->route('animals.index')->with('success', 'Animal mis à jour.');
    }

    public function destroy(Animal $animal): RedirectResponse
    {
        if ($animal->chemin_image) {
            Storage::disk('public')->delete($animal->chemin_image);
        }

        if ($animal->chemin_image_miniature) {
            Storage::disk('public')->delete($animal->chemin_image_miniature);
        }

        if ($animal->chemin_document) {
            Storage::disk('public')->delete($animal->chemin_document);
        }

        $animalId = $animal->id;
        $animalName = $animal->nom;

        $animal->delete();

        ActivityLog::trace(
            Auth::id(),
            'suppression_animal',
            'animal',
            $animalId,
            sprintf('Suppression de l\'animal %s.', $animalName),
            'warning',
        );

        return redirect()->route('animals.index')->with('success', 'Animal supprimé.');
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

        return [
            'demande' => $demande,
            'paiement_reussi' => $paiementReussi,
            'deja_adopte' => $dejaAdopte,
            'demande_deja_existante' => (bool) $demande,
        ];
    }
}
