<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnimalRequest extends FormRequest
{
    // Valide la creation d'une fiche animal (texte + medias).
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'espece' => ['required', 'string', 'max:255'],
            'race' => ['nullable', 'string', 'max:255'],
            'age' => ['nullable', 'integer', 'min:0'],
            'genre' => ['required', 'in:male,female'],
            'taille' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'localisation' => ['nullable', 'string', 'max:255'],
            'statut' => ['required', 'in:disponible,en_attente,adopte'],
            'prix_adoption' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'document' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de l\'animal est obligatoire.',
            'espece.required' => 'L\'espece est obligatoire.',
            'age.integer' => 'L\'age doit etre un nombre entier.',
            'age.min' => 'L\'age ne peut pas etre negatif.',
            'genre.in' => 'Le genre selectionne est invalide.',
            'statut.required' => 'Le statut est obligatoire.',
            'statut.in' => 'Le statut selectionne est invalide.',
            'image.image' => 'Le fichier image doit etre une image valide.',
            'image.mimes' => 'Formats image acceptes: jpg, jpeg, png, webp.',
            'image.max' => 'L\'image ne doit pas depasser 4 Mo.',
            'document.mimes' => 'Le document doit etre un fichier PDF.',
            'document.max' => 'Le document ne doit pas depasser 5 Mo.',
        ];
    }
}
