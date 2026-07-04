<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdoptionRequest extends Model
{
    // Table existante en francais.
    protected $table = 'demandes_adoption';

    // Champs autorises en ecriture de masse.
    protected $fillable = [
        'utilisateur_id',
        'animal_id',
        'message',
        'statut',
        'notes',
    ];

    // Demandeur (client) ayant cree la demande.
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    // Animal concerne par la demande d'adoption.
    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    // Historique de suivi metier de la demande.
    public function suivis(): HasMany
    {
        return $this->hasMany(FollowUp::class, 'demande_adoption_id');
    }

    // Paiements associes a cette demande.
    public function paiementsMobiles(): HasMany
    {
        return $this->hasMany(MobilePayment::class, 'demande_adoption_id');
    }
}
