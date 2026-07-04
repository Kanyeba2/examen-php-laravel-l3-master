<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'mot_de_passe' => ['required', 'string', 'min:6', 'confirmed'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'adresse' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cette adresse email est deja utilisee.',
            'mot_de_passe.required' => 'Le mot de passe est obligatoire.',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins :min caracteres.',
            'mot_de_passe.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'telephone.max' => 'Le numero de telephone ne doit pas depasser :max caracteres.',
            'adresse.max' => 'L\'adresse ne doit pas depasser :max caracteres.',
        ];
    }
}
