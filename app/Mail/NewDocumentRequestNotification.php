<?php

namespace App\Mail;

use App\Models\DocumentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewDocumentRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly DocumentRequest $request
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Yeni Doküman Talebi — ' . ($this->request->product?->name ?? 'Ürün belirtilmedi'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-document-request',
        );
    }
}
