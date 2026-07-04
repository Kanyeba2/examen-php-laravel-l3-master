<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowUp extends Model
{
    protected $table = 'suivis';

    protected $fillable = [
        'demande_adoption_id',
        'utilisateur_id',
        'notes',
        'statut',
        'date_prochaine_etape',
    ];

    protected $casts = [
        'date_prochaine_etape' => 'date',
    ];

    public function demandeAdoption(): BelongsTo
    {
        return $this->belongsTo(AdoptionRequest::class, 'demande_adoption_id');
    }

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }
}
