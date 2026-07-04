<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Animal extends Model
{
    // Table metier des animaux proposes a l'adoption.
    protected $table = 'animaux';

    // Champs modifiables depuis les formulaires web/API.
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

    // Type fort pour le prix (utile pour PDF, API et paiements).
    protected $casts = [
        'prix_adoption' => 'decimal:2',
    ];

    // Utilisateur (manager/admin) ayant cree la fiche animal.
    public function createur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cree_par_utilisateur_id');
    }

    // Demandes d'adoption liees a cet animal.
    public function demandesAdoption(): HasMany
    {
        return $this->hasMany(AdoptionRequest::class, 'animal_id');
    }

    // Favoris many-to-many entre clients et animaux.
    public function favoriParUtilisateurs(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'animal_favorites', 'animal_id', 'user_id')->withTimestamps();
    }
}
