<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailConfirmationAdresse extends Mailable implements ShouldQueue
{
    // Email de confirmation d'adresse associe au cycle d'inscription.
    use Queueable, SerializesModels;

    public $utilisateur;

    public string $code;

    public function __construct($utilisateur, string $code)
    {
        $this->utilisateur = $utilisateur;
        $this->code = $code;
    }

    public function build(): self
    {
        return $this->subject('Confirmez votre adresse email')
            ->view('emails.confirmation-adresse');
    }
}
