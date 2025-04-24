<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DemoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Crée une nouvelle instance du message.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Retourne l’enveloppe du message.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailData['title'] ?? 'Demo Mail',
        );
    }

    /**
     * Définit le contenu du message.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.demoMail',
            with: ['mailData' => $this->mailData],
        );
    }

    /**
     * Définit les pièces jointes du message.
     */
    public function attachments(): array
    {
        return [];
    }
}
