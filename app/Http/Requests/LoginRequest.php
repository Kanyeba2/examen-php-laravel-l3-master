<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    // Regroupe les regles de validation du formulaire de connexion.
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'mot_de_passe' => ['required', 'string', 'min:6'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Veuillez renseigner votre adresse email.',
            'email.email' => 'L\'adresse email fournie est invalide.',
            'mot_de_passe.required' => 'Veuillez renseigner votre mot de passe.',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins :min caracteres.',
        ];
    }
}
