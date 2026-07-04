<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    // Pivot metier role -> permission avec activation/desactivation.
    protected $table = 'permissions_roles';

    // Colonnes ecrites depuis la gestion des roles.
    protected $fillable = [
        'role',
        'permission',
        'enabled',
    ];

    // Force un booleen pour simplifier les controles d'acces.
    protected $casts = [
        'enabled' => 'boolean',
    ];
}
