<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ShippingLabelMail extends Mailable
{
    use Queueable, SerializesModels;

    public $labelUrl;
    public $product;

    /**
     * Create a new message instance.
     */
    public function __construct(string $labelUrl, Product $product)
    {
        $this->labelUrl = $labelUrl;
        $this->product  = $product;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject("Guía de envío para tu producto: {$this->product->name}")
            ->view('emails.shipping-label')
            ->with([
                'labelUrl' => $this->labelUrl,
                'product'  => $this->product,
            ]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
}
