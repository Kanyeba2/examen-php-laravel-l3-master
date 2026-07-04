<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdoptionRequest;
use App\Models\AdoptionRequest;
use App\Models\Animal;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DemandeAdoptionApiController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $demandes = AdoptionRequest::with(['utilisateur', 'animal'])->paginate(10);

        return $this->success('Liste des demandes d\'adoption récupérée.', $demandes);
    }

    public function store(StoreAdoptionRequest $request): JsonResponse
    {
        $animal = Animal::findOrFail($request->animal_id);

        $demande = AdoptionRequest::create([
            'utilisateur_id' => Auth::id(),
            'animal_id' => $animal->id,
            'message' => $request->message,
            'statut' => 'en_attente',
        ]);

        return $this->success('Demande d\'adoption créée avec succès.', $demande, 201);
    }

    public function show(AdoptionRequest $demandes_adoption): JsonResponse
    {
        return $this->success('Détail de la demande d\'adoption récupéré.', $demandes_adoption->load(['utilisateur', 'animal']));
    }

    public function destroy(AdoptionRequest $demandes_adoption): JsonResponse
    {
        $demandes_adoption->delete();

        return $this->success('Demande d\'adoption supprimée avec succès.', null);
    }
}
