<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountDeleted extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public string $name, public string $email) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Jussimatic account has been deleted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.account-deleted',
            with: [
                'name' => $this->name,
                'email' => $this->email,
            ],
        );
    }
}
