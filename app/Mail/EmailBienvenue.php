<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class EmailBienvenue extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $utilisateur;

    public function __construct($utilisateur)
    {
        $this->utilisateur = $utilisateur;
    }

    public function build(): self
    {
        return $this->subject('Bienvenue sur Adopte un ami')
            ->view('emails.bienvenue');
    }
}
