<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationWelcome extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $email;
    public string $plainPassword;
    public string $subjectLine;

    public function __construct(string $email, string $plainPassword, string $subjectLine)
    {
        $this->email = $email;
        $this->plainPassword = $plainPassword;
        $this->subjectLine = $subjectLine;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.registration-welcome',
            with: [
                'email' => $this->email,
                'plainPassword' => $this->plainPassword,
            ],
        );
    }
}
