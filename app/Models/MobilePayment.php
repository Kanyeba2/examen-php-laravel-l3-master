<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MobilePayment extends Model
{
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

    protected $casts = [
        'montant' => 'decimal:2',
        'payload_initiation' => 'array',
        'payload_confirmation' => 'array',
        'recu_envoye_at' => 'datetime',
    ];

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function demandeAdoption(): BelongsTo
    {
        return $this->belongsTo(AdoptionRequest::class, 'demande_adoption_id');
    }
}
