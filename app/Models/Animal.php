<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Animal extends Model
{
    protected $table = 'animaux';

    protected $fillable = [
        'nom',
        'espece',
        'race',
        'age',
        'genre',
        'taille',
        'description',
        'localisation',
        'statut',
        'prix_adoption',
        'chemin_image',
        'chemin_document',
        'chemin_image_miniature',
        'cree_par_utilisateur_id',
    ];

    protected $casts = [
        'prix_adoption' => 'decimal:2',
    ];

    public function createur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cree_par_utilisateur_id');
    }

    public function demandesAdoption(): HasMany
    {
        return $this->hasMany(AdoptionRequest::class, 'animal_id');
    }

    public function favoriParUtilisateurs(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'animal_favorites', 'animal_id', 'user_id')->withTimestamps();
    }
}
