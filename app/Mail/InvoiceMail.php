<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\Invoice;
use App\Translations\InvoiceTranslations;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Invoice $invoice,
        public ?string $pdfContent = null,
        public string $lang = 'en',
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->lang === 'fi'
            ? 'Lasku ' . $this->invoice->invoice_number
            : 'Invoice ' . $this->invoice->invoice_number;

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.invoice',
            with: [
                'invoice' => $this->invoice,
                'items'   => $this->invoice->getRelation('items') ?? collect(),
                'lang'    => $this->lang,
                't'       => InvoiceTranslations::get($this->lang),
            ],
        );
    }

    public function attachments(): array
    {
        if (!$this->pdfContent) {
            return [];
        }

        return [
            Attachment::fromData(
                fn () => $this->pdfContent,
                $this->invoice->invoice_number . '.pdf',
            )->withMime('application/pdf'),
        ];
    }
}
