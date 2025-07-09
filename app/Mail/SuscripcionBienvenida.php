<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuscripcionBienvenida extends Mailable
{
    use Queueable, SerializesModels;

    public $cupon;

    /**
     * Create a new message instance.
     */
    public function __construct($cupon)
    {
        $this->cupon = $cupon;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Bienvenido! Aquí tienes tu cupón de descuento',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.suscripcion_bienvenida',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('¡Bienvenido! Aquí tienes tu cupón de descuento')
            ->view('emails.suscripcion_bienvenida');
    }
}
