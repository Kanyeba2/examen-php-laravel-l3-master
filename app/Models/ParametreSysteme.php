<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParametreSysteme extends Model
{
    protected $table = 'parametres_systeme';

    protected $fillable = [
        'setting_key',
        'setting_label',
        'setting_value',
        'setting_type',
        'setting_group',
    ];

    public static function obtenirValeur(string $cle, mixed $defaut = null): mixed
    {
        return static::where('setting_key', $cle)->value('setting_value') ?? $defaut;
    }
}
