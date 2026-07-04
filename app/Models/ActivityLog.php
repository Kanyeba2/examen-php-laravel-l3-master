<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class ActivityLog extends Model
{
    protected $table = 'journal_activites';

    protected $fillable = [
        'utilisateur_id',
        'action',
        'type_entite',
        'entite_id',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public static function trace(
        ?int $userId,
        string $action,
        ?string $entityType = null,
        ?int $entityId = null,
        ?string $description = null,
        string $level = 'info',
        array $context = [],
    ): self {
        $entry = self::create([
            'utilisateur_id' => $userId,
            'action' => $action,
            'type_entite' => $entityType,
            'entite_id' => $entityId,
            'description' => $description,
        ]);

        $payload = array_merge([
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'activity_log_id' => $entry->id,
        ], $context);

        if ($level === 'warning') {
            Log::warning($description ?? $action, $payload);
        } else {
            Log::info($description ?? $action, $payload);
        }

        return $entry;
    }
}
