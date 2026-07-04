<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmMobilePaymentRequest extends FormRequest
{
    // Valide la confirmation manuelle d'un paiement mobile.
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }
}
