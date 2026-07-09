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

        if (! $product) {
            return $attachments;
        }

        $requested = explode(',', $this->request->document_type);
        $files = ['tds' => $product->tds_file, 'sds' => $product->sds_file, 'ce' => $product->ce_file];

        foreach ($files as $type => $file) {
            if ($file && in_array($type, $requested)) {
                $attachments[] = Attachment::fromStorageDisk('public', $file)
                    ->as(strtoupper($type) . '_' . str($product->name)->slug() . '.pdf')
                    ->withMime('application/pdf');
            }
        }

        return $attachments;
    }
}
