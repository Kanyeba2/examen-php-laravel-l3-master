<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\RolePermission;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Colonnes modifiables lors creation/edition de compte.
    protected $fillable = [
        'nom',
        'email',
        'mot_de_passe',
        'role',
        'telephone',
        'adresse',
        'profile_photo_path',
        'actif',
        'two_factor_enabled',
    ];

    // Donnees sensibles exclues des serialisations JSON.
    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    // Types natifs pour simplifier les checks metier.
    protected $casts = [
        'email_verified_at' => 'datetime',
        'actif' => 'boolean',
        'two_factor_enabled' => 'boolean',
    ];

    // Mappe le champ personnalise mot_de_passe avec l'auth Laravel.
    public function getAuthPassword(): string
    {
        return $this->mot_de_passe;
    }

    // Animaux crees par le manager/admin.
    public function animaux(): HasMany
    {
        return $this->hasMany(Animal::class, 'cree_par_utilisateur_id');
    }

    // Demandes d'adoption soumises par ce client.
    public function demandesAdoption(): HasMany
    {
        return $this->hasMany(AdoptionRequest::class, 'utilisateur_id');
    }

    // Entrees de suivi saisies par cet utilisateur.
    public function suivis(): HasMany
    {
        return $this->hasMany(FollowUp::class, 'utilisateur_id');
    }

    // Journal des actions auditees pour l'utilisateur.
    public function journalActivites(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'utilisateur_id');
    }

    // Paiements mobiles lies au compte.
    public function paiementsMobiles(): HasMany
    {
        return $this->hasMany(MobilePayment::class, 'utilisateur_id');
    }

    // Favoris many-to-many (animal_favorites).
    public function favorisAnimaux(): BelongsToMany
    {
        return $this->belongsToMany(Animal::class, 'animal_favorites', 'user_id', 'animal_id')->withTimestamps();
    }

    // Verifie qu'une permission est active pour le role courant.
    public function hasPermission(string $permission): bool
    {
        return RolePermission::where('role', $this->role)
            ->where('permission', $permission)
            ->where('enabled', true)
            ->exists();
    }
}
