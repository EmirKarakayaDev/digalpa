<?php

namespace App\Observers;

use App\Mail\DocumentRequestApproved;
use App\Mail\NewDocumentRequestNotification;
use App\Models\DocumentRequest;
use App\Models\Member;
use Illuminate\Support\Facades\Mail;

class DocumentRequestObserver
{
    public function created(DocumentRequest $documentRequest): void
    {
        // Dahili bildirim — talep düşer düşmez, bildirim alıcısı işaretli
        // aktif üyeler haberdar olsun (Brief §06: "operasyonel şart").
        $recipients = Member::where('is_active', true)
            ->where('receives_notifications', true)
            ->pluck('email');

        if ($recipients->isNotEmpty()) {
            Mail::to($recipients->all())
                ->send(new NewDocumentRequestNotification($documentRequest));
        }
    }

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
