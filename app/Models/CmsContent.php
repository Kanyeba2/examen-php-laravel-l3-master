<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsContent extends Model
{
	protected $table = 'contenus_cms';

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

	protected $casts = [
		'is_featured' => 'boolean',
		'sort_order' => 'integer',
		'published_at' => 'datetime',
	];

	public function author(): BelongsTo
	{
		return $this->belongsTo(User::class, 'author_user_id');
	}
}
