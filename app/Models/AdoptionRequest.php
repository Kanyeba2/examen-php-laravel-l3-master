<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdoptionRequest extends Model
{
    protected $table = 'demandes_adoption';

    protected $fillable = [
        'utilisateur_id',
        'animal_id',
        'message',
        'statut',
        'notes',
    ];

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function suivis(): HasMany
    {
        return $this->hasMany(FollowUp::class, 'demande_adoption_id');
    }

    public function paiementsMobiles(): HasMany
    {
        return $this->hasMany(MobilePayment::class, 'demande_adoption_id');
    }
}
