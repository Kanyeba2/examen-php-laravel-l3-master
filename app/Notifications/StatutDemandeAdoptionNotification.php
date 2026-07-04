<?php

namespace App\Notifications;

use App\Models\AdoptionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StatutDemandeAdoptionNotification extends Notification
{
    // Notifie l'utilisateur lorsqu'une demande change de statut.
    use Queueable;

    public function __construct(private readonly AdoptionRequest $adoptionRequest)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Mise a jour de votre demande',
            'message' => sprintf(
                'Le statut de votre demande d\'adoption pour %s est maintenant: %s.',
                $this->adoptionRequest->animal->nom ?? 'cet animal',
                $this->adoptionRequest->statut,
            ),
            'demande_id' => $this->adoptionRequest->id,
            'animal_nom' => $this->adoptionRequest->animal->nom ?? null,
            'statut' => $this->adoptionRequest->statut,
            'url' => route('dashboard'),
        ];
    }
}
