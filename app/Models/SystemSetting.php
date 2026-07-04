<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
	// Alias anglais des parametres systeme (meme table que ParametreSysteme).
	protected $table = 'parametres_systeme';

	// Champs admin pour configurer le comportement global de l'application.
	protected $fillable = [
		'setting_key',
		'setting_label',
		'setting_value',
		'setting_type',
		'setting_group',
	];

	// Accesseur utilitaire pour lire un parametre avec valeur par defaut.
	public static function getValue(string $key, mixed $default = null): mixed
	{
		return static::where('setting_key', $key)->value('setting_value') ?? $default;
	}
}
