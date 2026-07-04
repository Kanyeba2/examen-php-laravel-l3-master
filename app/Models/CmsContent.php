<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsContent extends Model
{
	// Variante anglaise du modele CMS (meme table que ContenuCms).
	protected $table = 'contenus_cms';

	// Champs administrables depuis le back-office CMS.
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

	// Conversions automatiques pour simplifier les traitements UI/API.
	protected $casts = [
		'is_featured' => 'boolean',
		'sort_order' => 'integer',
		'published_at' => 'datetime',
	];

	// Auteur du contenu CMS.
	public function author(): BelongsTo
	{
		return $this->belongsTo(User::class, 'author_user_id');
	}
}
