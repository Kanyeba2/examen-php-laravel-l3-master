<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParametreSysteme extends Model
{
    // Table des parametres globaux de l'application.
    protected $table = 'parametres_systeme';

    // Champs administrables depuis l'ecran de parametres.
    protected $fillable = [
        'setting_key',
        'setting_label',
        'setting_value',
        'setting_type',
        'setting_group',
    ];

    // Accesseur metier pratique: valeur par cle avec fallback.
    public static function obtenirValeur(string $cle, mixed $defaut = null): mixed
    {
        return static::where('setting_key', $cle)->value('setting_value') ?? $defaut;
    }
}
