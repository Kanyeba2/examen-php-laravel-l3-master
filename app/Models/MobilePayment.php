<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MobilePayment extends Model
{
    // Champs transactionnels du workflow de paiement mobile.
    protected $fillable = [
        'utilisateur_id',
        'demande_adoption_id',
        'fournisseur',
        'montant',
        'devise',
        'numero_telephone',
        'reference_interne',
        'reference_fournisseur',
        'statut',
        'payload_initiation',
        'payload_confirmation',
        'recu_envoye_at',
    ];

    // Types utiles pour montants, payloads API et horodatage d'envoi recu.
    protected $casts = [
        'montant' => 'decimal:2',
        'payload_initiation' => 'array',
        'payload_confirmation' => 'array',
        'recu_envoye_at' => 'datetime',
    ];

    // Client ayant initie le paiement.
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    // Demande d'adoption financee par ce paiement.
    public function demandeAdoption(): BelongsTo
    {
        return $this->belongsTo(AdoptionRequest::class, 'demande_adoption_id');
    }
}
