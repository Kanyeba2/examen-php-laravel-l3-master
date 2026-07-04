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

    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'actif' => 'boolean',
        'two_factor_enabled' => 'boolean',
    ];

    public function getAuthPassword(): string
    {
        return $this->mot_de_passe;
    }

    public function animaux(): HasMany
    {
        return $this->hasMany(Animal::class, 'cree_par_utilisateur_id');
    }

    public function demandesAdoption(): HasMany
    {
        return $this->hasMany(AdoptionRequest::class, 'utilisateur_id');
    }

    public function suivis(): HasMany
    {
        return $this->hasMany(FollowUp::class, 'utilisateur_id');
    }

    public function journalActivites(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'utilisateur_id');
    }

    public function paiementsMobiles(): HasMany
    {
        return $this->hasMany(MobilePayment::class, 'utilisateur_id');
    }

    public function favorisAnimaux(): BelongsToMany
    {
        return $this->belongsToMany(Animal::class, 'animal_favorites', 'user_id', 'animal_id')->withTimestamps();
    }

    public function hasPermission(string $permission): bool
    {
        return RolePermission::where('role', $this->role)
            ->where('permission', $permission)
            ->where('enabled', true)
            ->exists();
    }
}
