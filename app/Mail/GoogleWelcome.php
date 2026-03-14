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

    public function __construct(
        public User $user,
        public string $lang = 'en',
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->lang === 'fi'
            ? 'Tervetuloa ' . config('app.name') . ':hen'
            : 'Welcome to ' . config('app.name');

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.google-welcome',
            with: [
                'name'  => $this->user->first_name ?: $this->user->name,
                'email' => $this->user->email,
                'lang'  => $this->lang,
            ],
        );
    }
}
