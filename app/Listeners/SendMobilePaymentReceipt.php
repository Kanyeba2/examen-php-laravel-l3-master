<?php

namespace App\Listeners;

use App\Events\MobilePaymentStatusUpdated;
use App\Mail\RecuPaiementMobile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendMobilePaymentReceipt implements ShouldQueue
{
    // Listener qui envoie automatiquement le recu apres paiement reussi.
    public function handle(MobilePaymentStatusUpdated $event): void
    {
        if ($event->newStatus !== 'reussi') {
            return;
        }

        $payment = $event->mobilePayment->loadMissing(['utilisateur', 'demandeAdoption.animal']);

        if ($payment->recu_envoye_at || empty($payment->utilisateur?->email)) {
            return;
        }

        Mail::to($payment->utilisateur->email)->queue(new RecuPaiementMobile($payment));

        $payment->update([
            'recu_envoye_at' => now(),
        ]);
    }
}
