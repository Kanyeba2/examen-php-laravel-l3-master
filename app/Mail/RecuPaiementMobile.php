<?php

namespace App\Mail;

use App\Models\MobilePayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecuPaiementMobile extends Mailable implements ShouldQueue
{
    // Envoie le recu PDF apres confirmation d'un paiement mobile.
    use Queueable, SerializesModels;

    public function __construct(public MobilePayment $payment)
    {
        $this->payment->loadMissing(['utilisateur', 'demandeAdoption.animal']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recu de paiement mobile '.$this->payment->reference_interne,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.recu-paiement-mobile',
        );
    }

    public function attachments(): array
    {
        $pdf = Pdf::loadView('pdf.receipt-mobile-payment', [
            'payment' => $this->payment,
        ])->output();

        return [
            Attachment::fromData(fn () => $pdf, 'recu-paiement-'.$this->payment->reference_interne.'.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
