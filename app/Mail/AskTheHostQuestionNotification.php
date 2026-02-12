<?php

namespace App\Mail;

use App\Models\AskTheHostQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AskTheHostQuestionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public string $submittedByName;
    public string $submittedByEmail;
    public string $submittedAt;
    public string $questionText;
    public string $viewReplyUrl;
    public string $saveTheDate;

    public function __construct(AskTheHostQuery $query)
    {
        $query->load('user');
        $user = $query->user;
        $this->submittedByName = $user
            ? trim($user->first_name . ' ' . $user->last_name)
            : 'Guest';
        $this->submittedByEmail = $user ? $user->email : '—';
        $this->submittedAt = $query->created_at->format('n/j/y');
        $this->questionText = $query->question_text;
        $this->viewReplyUrl = url('/ask-the-host');

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
            subject: 'Question Received - Ask the Host - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'Emails.ask-the-host-question',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
