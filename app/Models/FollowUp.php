<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowUp extends Model
{
    // Table de suivi post-demande (workflow metier).
    protected $table = 'suivis';

    // Colonnes editables par manager/admin.
    protected $fillable = [
        'demande_adoption_id',
        'utilisateur_id',
        'notes',
        'statut',
        'date_prochaine_etape',
    ];

    // Date de prochaine etape exploitable directement en Carbon.
    protected $casts = [
        'date_prochaine_etape' => 'date',
    ];

    // Demande d'adoption concernee par cette entree de suivi.
    public function demandeAdoption(): BelongsTo
    {
        return $this->belongsTo(AdoptionRequest::class, 'demande_adoption_id');
    }

    // Utilisateur ayant saisi le suivi.
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }
}
