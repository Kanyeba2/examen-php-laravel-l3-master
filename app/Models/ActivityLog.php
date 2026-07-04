<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class ActivityLog extends Model
{
    // Table legacy en francais gardee pour compatibilite avec la base existante.
    protected $table = 'journal_activites';

    // Colonnes modifiables via create()/update().
    protected $fillable = [
        'utilisateur_id',
        'action',
        'type_entite',
        'entite_id',
        'description',
    ];

    // Action liee a l'utilisateur ayant declenche l'evenement.
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
        // Persiste d'abord le log applicatif en base.
        $entry = self::create([
            'utilisateur_id' => $userId,
            'action' => $action,
            'type_entite' => $entityType,
            'entite_id' => $entityId,
            'description' => $description,
        ]);

        // Construit le contexte standard pour les logs fichiers (Monolog).
        $payload = array_merge([
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'activity_log_id' => $entry->id,
        ], $context);

        // Ecrit au bon niveau selon la severite demandee.
        if ($level === 'warning') {
            Log::warning($description ?? $action, $payload);
        } else {
            Log::info($description ?? $action, $payload);
        }

        return $entry;
    }
}
