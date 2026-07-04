<?php

namespace App\Mail;

use App\Models\AdoptionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationActionImportante extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public AdoptionRequest $demande;

    public function __construct(AdoptionRequest $demande)
    {
        $this->demande = $demande;
    }

    public function build(): self
    {
        return $this->subject('Confirmation de votre demande d\'adoption')
            ->view('emails.confirmation-action-importante');
    }
}
