<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdoptionStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'statut' => ['required', 'string', 'in:en_attente,approuve,rejete'],
        ];
    }

    public function messages(): array
    {
        return [
            'statut.required' => 'Veuillez choisir un statut.',
            'statut.in' => 'Le statut selectionne est invalide.',
        ];
    }
}
