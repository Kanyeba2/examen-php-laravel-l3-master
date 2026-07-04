<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
	// Alias anglais du pivot permissions_roles (compatibilite historique).
	protected $table = 'permissions_roles';

	// Colonnes modifiables par le module d'administration des droits.
	protected $fillable = [
		'role',
		'permission',
		'enabled',
	];

	// Cast booleen de l'etat d'activation d'une permission.
	protected $casts = [
		'enabled' => 'boolean',
	];
}
