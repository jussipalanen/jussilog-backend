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

class OrderStatusUpdated extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Order $order,
        public string $oldStatus,
        public string $lang = 'en',
    ) {}

    public function envelope(): Envelope
    {
        $t          = MailTranslations::get('order_status_updated', $this->lang);
        $subjectKey = 'subject_'.$this->order->status;
        $subject    = $t[$subjectKey] ?? 'Your order status has been updated';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.order-status-updated',
            with: [
                'order'     => $this->order,
                'oldStatus' => $this->oldStatus,
                'lang'      => $this->lang,
                't'         => MailTranslations::get('order_status_updated', $this->lang),
            ],
        );
    }
}
