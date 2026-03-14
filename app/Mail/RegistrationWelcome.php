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
    public string $lang;

    public function __construct(string $email, string $lang = 'en')
    {
        $this->email = $email;
        $this->lang  = $lang;
    }

    public function envelope(): Envelope
    {
        $subject = $this->lang === 'fi'
            ? 'Tervetuloa ' . config('app.name') . '!'
            : 'Welcome to ' . config('app.name') . '!';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.registration-welcome',
            with: [
                'email' => $this->email,
                'lang'  => $this->lang,
            ],
        );
    }
}
