<?php

namespace App\Mail;

use App\Models\AdoptionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationStatutDemande extends Mailable implements ShouldQueue
{
    // Notifie le client d'un changement de statut de sa demande.
    use Queueable, SerializesModels;

    public AdoptionRequest $demande;

    public function __construct(AdoptionRequest $demande)
    {
        $this->demande = $demande;
    }

    public function build(): self
    {
        return $this->subject('Mise a jour du statut de votre demande')
            ->view('emails.notification-statut-demande');
    }
}
