<?php

namespace App\Observers;

use App\Mail\DocumentRequestApproved;
use App\Models\DocumentRequest;
use Illuminate\Support\Facades\Mail;

class DocumentRequestObserver
{
    public function updated(DocumentRequest $documentRequest): void
    {
        if (
            $documentRequest->wasChanged('status') &&
            $documentRequest->status === 'sent' &&
            $documentRequest->sent_at === null
        ) {
            $documentRequest->updateQuietly(['sent_at' => now()]);

            Mail::to($documentRequest->email)
                ->send(new DocumentRequestApproved($documentRequest));
        }
    }
}
