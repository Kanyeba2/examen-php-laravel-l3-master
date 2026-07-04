<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContenuCms extends Model
{
    // Variante francaise du modele CMS (meme table que CmsContent).
    protected $table = 'contenus_cms';

    // Champs modifiables pour articles et pages CMS.
    protected $fillable = [
        'author_user_id',
        'type',
        'title',
        'slug',
        'category',
        'summary',
        'body',
        'status',
        'is_featured',
        'sort_order',
        'published_at',
    ];

    // Conversions automatiques des attributs techniques.
    protected $casts = [
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'published_at' => 'datetime',
    ];

    // Auteur du contenu (relation user).
    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_user_id');
    }
}
