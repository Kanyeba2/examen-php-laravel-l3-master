<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Models\Animal;
use App\Support\ImageThumbnail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnimalApiController extends Controller
{
    // API REST CRUD des animaux avec reponses JSON standardisees.
    use ApiResponse;

    public function index(): JsonResponse
    {
        $animaux = Animal::paginate(10);

        return $this->success('Liste des animaux récupérée.', $animaux);
    }

    public function store(StoreAnimalRequest $request): JsonResponse
    {
        $payload = $request->validated();
        $payload['cree_par_utilisateur_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('animals/images', 'public');
            $payload['chemin_image'] = $imagePath;

            $extension = strtolower((string) $request->file('image')->getClientOriginalExtension());
            $thumbnailPath = 'animals/thumbnails/'.Str::uuid().'.'.$extension;
            $payload['chemin_image_miniature'] = ImageThumbnail::generate($imagePath, $thumbnailPath);
        }

        if ($request->hasFile('document')) {
            $payload['chemin_document'] = $request->file('document')->store('animals/documents', 'public');
        }

        unset($payload['image'], $payload['document']);

        $animal = Animal::create($payload);

        return $this->success('Animal créé avec succès.', $animal, 201);
    }

    public function show(Animal $animal): JsonResponse
    {
        return $this->success('Détail de l\'animal récupéré.', $animal);
    }

    public function update(UpdateAnimalRequest $request, Animal $animal): JsonResponse
    {
        $payload = $request->validated();

        if ($request->hasFile('image')) {
            if ($animal->chemin_image) {
                Storage::disk('public')->delete($animal->chemin_image);
            }

            if ($animal->chemin_image_miniature) {
                Storage::disk('public')->delete($animal->chemin_image_miniature);
            }

            $imagePath = $request->file('image')->store('animals/images', 'public');
            $payload['chemin_image'] = $imagePath;

            $extension = strtolower((string) $request->file('image')->getClientOriginalExtension());
            $thumbnailPath = 'animals/thumbnails/'.Str::uuid().'.'.$extension;
            $payload['chemin_image_miniature'] = ImageThumbnail::generate($imagePath, $thumbnailPath);
        }

        if ($request->hasFile('document')) {
            if ($animal->chemin_document) {
                Storage::disk('public')->delete($animal->chemin_document);
            }

            $payload['chemin_document'] = $request->file('document')->store('animals/documents', 'public');
        }

        unset($payload['image'], $payload['document']);

        $animal->update($payload);

        return $this->success('Animal mis à jour avec succès.', $animal);
    }

    public function destroy(Animal $animal): JsonResponse
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

        $animal->delete();

        return $this->success('Animal supprimé avec succès.', null);
    }
}
