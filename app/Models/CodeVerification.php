<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CodeVerification extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
        'utilise',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'utilise' => 'boolean',
    ];

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
