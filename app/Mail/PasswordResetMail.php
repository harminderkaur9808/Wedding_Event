<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $resetUrl;
    public int $expireMinutes;

    public function __construct(User $user, string $resetUrl, int $expireMinutes = 60)
    {
        $this->user = $user;
        $this->resetUrl = $resetUrl;
        $this->expireMinutes = $expireMinutes;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address($this->user->email, $this->user->first_name . ' ' . $this->user->last_name)],
            subject: 'Reset Password - ' . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'Emails.password-reset',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
