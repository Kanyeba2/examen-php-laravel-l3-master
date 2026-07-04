<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodeVerification extends Model
{
    // Donnees OTP/verification associees a un utilisateur.
    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
        'utilise',
    ];

    // Casts pour manipuler facilement expiration et etat d'utilisation.
    protected $casts = [
        'expires_at' => 'datetime',
        'utilise' => 'boolean',
    ];

    // Proprietaire du code OTP.
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
