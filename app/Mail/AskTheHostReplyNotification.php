<?php

namespace App\Mail;

use App\Models\AskTheHostQuery;
use App\Models\AskTheHostReply;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AskTheHostReplyNotification extends Mailable
{
    use Queueable, SerializesModels;

    public string $questionerName;
    public string $questionText;
    public string $repliedByName;
    public string $repliedAt;
    public string $replyText;
    public string $viewUrl;
    public string $saveTheDate;

    public function __construct(AskTheHostQuery $query, AskTheHostReply $reply)
    {
        $query->load('user');
        $reply->load('user');

        $questioner = $query->user;
        $this->questionerName = $questioner
            ? trim($questioner->first_name . ' ' . $questioner->last_name)
            : 'Guest';
        $this->questionText = $query->question_text;

        $replier = $reply->user;
        $this->repliedByName = $replier
            ? trim($replier->first_name . ' ' . $replier->last_name)
            : 'Someone';
        $this->repliedAt = $reply->created_at->format('j M Y, h:i a');
        $this->replyText = $reply->reply_text;
        $this->viewUrl = url('/ask-the-host');

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
            subject: 'Your Question Was Answered - Ask the Host - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'Emails.ask-the-host-reply',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
