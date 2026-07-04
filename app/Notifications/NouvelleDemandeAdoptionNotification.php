<?php

namespace App\Notifications;

use App\Models\AdoptionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouvelleDemandeAdoptionNotification extends Notification
{
    // Notification staff lors de l'arrivee d'une nouvelle demande.
    use Queueable;

    public function __construct(private readonly AdoptionRequest $adoptionRequest)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $animalNom = $this->adoptionRequest->animal->nom ?? 'un animal';
        $demandeur = $this->adoptionRequest->utilisateur->nom ?? 'un utilisateur';

        return (new MailMessage)
            ->subject('Nouvelle demande d\'adoption')
            ->line("Une nouvelle demande d'adoption a ete soumise pour {$animalNom}.")
            ->line("Demandeur: {$demandeur}")
            ->action('Voir les demandes', route('adoptions.index'))
            ->line('Merci de traiter cette demande rapidement.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Nouvelle demande d\'adoption',
            'message' => 'Une nouvelle demande d\'adoption a ete creee et attend un traitement.',
            'demande_id' => $this->adoptionRequest->id,
            'animal_id' => $this->adoptionRequest->animal_id,
            'animal_nom' => $this->adoptionRequest->animal->nom ?? null,
            'demandeur_nom' => $this->adoptionRequest->utilisateur->nom ?? null,
            'url' => route('adoptions.index'),
        ];
    }
}
