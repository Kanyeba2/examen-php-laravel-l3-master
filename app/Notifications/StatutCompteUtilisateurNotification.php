<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatutCompteUtilisateurNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly bool $actif)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statut = $this->actif ? 'active' : 'desactive';

        return (new MailMessage)
            ->subject('Mise a jour du statut de votre compte')
            ->line("Votre compte a ete {$statut} par un administrateur.")
            ->action('Acceder a la plateforme', route('login'));
    }

    public function toArray(object $notifiable): array
    {
        $statut = $this->actif ? 'actif' : 'inactif';

        return [
            'title' => 'Statut de compte mis a jour',
            'message' => "Votre compte est maintenant {$statut}.",
            'actif' => $this->actif,
            'url' => route('profile.show'),
        ];
    }
}
