<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GoogleWelcome extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Jussimatic',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.google-welcome',
            with: [
                'name' => $this->user->first_name ?: $this->user->name,
                'email' => $this->user->email,
            ],
        );
    }
}
