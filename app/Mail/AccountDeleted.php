<?php

declare(strict_types=1);

namespace App\Mail;

use App\Translations\MailTranslations;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AccountDeleted extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $name,
        public string $email,
        public string $lang = 'en',
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->lang === 'fi'
            ? 'Tilisi '.config('app.name').':ssa on poistettu'
            : 'Your '.config('app.name').' account has been deleted';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.account-deleted',
            with: [
                'name'  => $this->name,
                'email' => $this->email,
                'lang'  => $this->lang,
                't'     => MailTranslations::get('account_deleted', $this->lang),
            ],
        );
    }
}
