<?php

namespace App\Mail;

use App\Models\FamilyUpdate;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FamilyUpdateNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $recipient;
    public FamilyUpdate $familyUpdate;
    public string $viewUpdateUrl;
    public string $postedByName;
    public string $saveTheDate;

    public function __construct(User $recipient, FamilyUpdate $familyUpdate)
    {
        $this->recipient = $recipient;
        $this->familyUpdate = $familyUpdate;
        $this->viewUpdateUrl = url('/updates-by-family');
        $familyUpdate->load('user');
        $this->postedByName = $familyUpdate->user
            ? trim($familyUpdate->user->first_name . ' ' . $familyUpdate->user->last_name)
            : 'Family';
        try {
            $weddingDate = \App\Models\PageSection::weddingDate();
            $this->saveTheDate = $weddingDate ? $weddingDate->format('m-d-Y') : '01-01-2027';
        } catch (\Throwable $e) {
            $this->saveTheDate = '01-01-2027';
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [$this->recipient->email],
            subject: 'Family Update - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'Emails.family-update-notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
