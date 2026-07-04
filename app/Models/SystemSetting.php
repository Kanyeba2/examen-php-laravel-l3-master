<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
	protected $table = 'parametres_systeme';

	protected $fillable = [
		'setting_key',
		'setting_label',
		'setting_value',
		'setting_type',
		'setting_group',
	];

	public static function getValue(string $key, mixed $default = null): mixed
	{
		return static::where('setting_key', $key)->value('setting_value') ?? $default;
	}
}
