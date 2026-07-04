<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodeOtpConnexion extends Mailable
{
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
        return $this->subject('Code OTP de connexion')
            ->view('emails.code-otp-connexion');
    }
}
