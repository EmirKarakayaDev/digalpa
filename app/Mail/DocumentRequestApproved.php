<?php

namespace App\Mail;

use App\Models\DocumentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentRequestApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly DocumentRequest $request
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Teknik Doküman Talebiniz — ' . ($this->request->product?->name ?? ''),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.document-request-approved',
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        $product = $this->request->product;

        if ($product && in_array($this->request->document_type, ['tds', 'both']) && $product->tds_file) {
            $attachments[] = Attachment::fromStorageDisk('public', $product->tds_file)
                ->as('TDS_' . str($product->name)->slug() . '.pdf')
                ->withMime('application/pdf');
        }

        if ($product && in_array($this->request->document_type, ['sds', 'both']) && $product->sds_file) {
            $attachments[] = Attachment::fromStorageDisk('public', $product->sds_file)
                ->as('SDS_' . str($product->name)->slug() . '.pdf')
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
