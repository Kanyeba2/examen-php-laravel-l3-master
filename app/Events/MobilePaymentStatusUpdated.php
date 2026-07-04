<?php

namespace App\Events;

use App\Models\MobilePayment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MobilePaymentStatusUpdated
{
    // Event emis apres mise a jour du statut d'un paiement mobile.
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly MobilePayment $mobilePayment,
        public readonly string $oldStatus,
        public readonly string $newStatus,
    ) {}
}
