<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Order;
use App\Translations\MailTranslations;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable;
    use SerializesModels;

    public Order $order;
    public string $lang;

    public function __construct(Order $order, string $lang = 'en')
    {
        $this->order = $order;
        $this->lang  = $lang;
    }

    public function envelope(): Envelope
    {
        $subject = $this->lang === 'fi'
            ? 'Kiitos tilauksestasi!'
            : 'Thank you for your order!';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.order-confirmation',
            with: [
                'order' => $this->order,
                'lang'  => $this->lang,
                't'     => MailTranslations::get('order_confirmation', $this->lang),
            ],
        );
    }
}
