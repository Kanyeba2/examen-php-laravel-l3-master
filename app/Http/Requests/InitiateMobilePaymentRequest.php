<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InitiateMobilePaymentRequest extends FormRequest
{
    // Valide les donnees requises pour initier un paiement.
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'demande_adoption_id' => ['nullable', 'integer', 'exists:demandes_adoption,id'],
            'fournisseur' => ['required', 'in:mpesa,airtel,orange'],
            'montant' => ['required', 'numeric', 'min:1'],
            'devise' => ['nullable', 'string', 'in:USD,CDF'],
            'numero_telephone' => ['required', 'string', 'min:8', 'max:30'],
        ];
    }

    public function messages(): array
    {
        return [
            'fournisseur.required' => 'Veuillez selectionner un fournisseur mobile.',
            'fournisseur.in' => 'Le fournisseur choisi est invalide.',
            'montant.required' => 'Le montant est obligatoire.',
            'montant.min' => 'Le montant minimum est 1.',
            'numero_telephone.required' => 'Le numero de telephone est obligatoire.',
            'demande_adoption_id.exists' => 'La demande d\'adoption selectionnee est invalide.',
        ];
    }
}
