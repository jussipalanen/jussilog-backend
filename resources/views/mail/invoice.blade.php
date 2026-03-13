@php
use App\Services\CountryService;
$translations = [
    'en' => [
        'invoice'        => 'Invoice',
        'invoice_number' => 'Invoice Number',
        'email_title'    => 'Your invoice is ready',
        'hi'             => 'Hi',
        'email_greeting' => 'please find your invoice details below.',
        'bill_to'        => 'Bill To',
        'address'        => 'Billing Address',
        'items'          => 'Items',
        'description'    => 'Description',
        'qty'            => 'Qty',
        'unit_price'     => 'Unit Price',
        'tax'            => 'Tax',
        'summary'        => 'Summary',
        'status'         => 'Status',
        'issued'         => 'Issued',
        'subtotal'       => 'Subtotal',
        'total'          => 'Total',
        'notes'          => 'Notes',
        'email_footer'   => 'This email was sent automatically. Please do not reply directly.',
    ],
    'fi' => [
        'invoice'        => 'Lasku',
        'invoice_number' => 'Laskunumero',
        'email_title'    => 'Laskusi on valmis',
        'hi'             => 'Hei',
        'email_greeting' => 'löydät laskusi tiedot alta.',
        'bill_to'        => 'Laskutettava',
        'address'        => 'Laskutusosoite',
        'items'          => 'Rivit',
        'description'    => 'Kuvaus',
        'qty'            => 'Määrä',
        'unit_price'     => 'Yksikköhinta',
        'tax'            => 'ALV',
        'summary'        => 'Yhteenveto',
        'status'         => 'Tila',
        'issued'         => 'Lähetetty',
        'subtotal'       => 'Välisumma',
        'total'          => 'Yhteensä',
        'notes'          => 'Muistiinpanot',
        'email_footer'   => 'Tämä sähköposti on lähetetty automaattisesti. Älä vastaa suoraan tähän viestiin.',
    ],
];
$t = $translations[$lang ?? 'en'] ?? $translations['en'];
@endphp
<!DOCTYPE html>
<html lang="{{ $lang ?? 'en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body style="background: linear-gradient(135deg, #f0f4ff 0%, #faf5ff 100%); margin:0; padding:0;">
    <div style="max-width:620px; margin:40px auto; background:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 8px 40px rgba(0,0,0,0.10);">

        {{-- Header --}}
        <div style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 60%, #4c1d95 100%); padding:48px 40px 40px; text-align:center;">
            <div style="display:inline-block; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); border-radius:50px; padding:6px 18px; margin-bottom:20px;">
                <span style="color:#c4b5fd; font-size:11px; font-weight:600; letter-spacing:2px; text-transform:uppercase;">{{ $t['invoice'] }}</span>
            </div>
            <div style="font-size:48px; margin-bottom:12px;">🧾</div>
            <h1 style="color:#ffffff; font-size:26px; font-weight:700; margin:0 0 10px;">{{ $t['email_title'] }}</h1>
            <p style="color:#c4b5fd; font-size:15px; margin:0 0 24px;">
                {{ $t['hi'] }} <strong style="color:#ede9fe;">{{ $invoice->customer_first_name }}</strong>, {{ $t['email_greeting'] }}
            </p>
            @if ($invoice->invoice_number)
                <div style="display:inline-block; background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.25); border-radius:8px; padding:10px 24px;">
                    <span style="color:#a5b4fc; font-size:12px; font-weight:600; letter-spacing:1px; text-transform:uppercase; display:block; margin-bottom:2px;">{{ $t['invoice_number'] }}</span>
                    <span style="color:#ffffff; font-size:18px; font-weight:700; font-family:monospace;">{{ $invoice->invoice_number }}</span>
                </div>
            @endif
        </div>

        <div style="padding:36px 40px;">

            {{-- Customer info --}}
            <div style="margin-bottom:28px;">
                <h2 style="font-size:11px; font-weight:700; color:#9ca3af; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 14px;">{{ $t['bill_to'] }}</h2>
                <div style="background:#fafafa; border:1px solid #f3f4f6; border-radius:12px; padding:18px 20px;">
                    <p style="color:#111827; font-weight:600; font-size:16px; margin:0 0 4px;">{{ $invoice->customer_first_name }} {{ $invoice->customer_last_name }}</p>
                    @if ($invoice->customer_email)
                        <p style="color:#6b7280; font-size:14px; margin:0 0 2px;">✉️ &nbsp;{{ $invoice->customer_email }}</p>
                    @endif
                    @if ($invoice->customer_phone)
                        <p style="color:#6b7280; font-size:14px; margin:0;">📞 &nbsp;{{ $invoice->customer_phone }}</p>
                    @endif
                </div>
            </div>

            {{-- Billing address --}}
            @if ($invoice->billing_address)
            @php $addr = $invoice->billing_address; @endphp
            <div style="margin-bottom:28px;">
                <h2 style="font-size:11px; font-weight:700; color:#9ca3af; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 14px;">{{ $t['address'] }}</h2>
                <div style="background:#fafafa; border:1px solid #f3f4f6; border-radius:12px; padding:18px 20px; color:#4b5563; font-size:14px; line-height:1.8;">
                    @if(!empty($addr['street']))<div>{{ $addr['street'] }}</div>@endif
                    @if(!empty($addr['postal_code']) || !empty($addr['city']))<div>{{ $addr['postal_code'] ?? '' }} {{ $addr['city'] ?? '' }}</div>@endif
                    @if(!empty($addr['country']))<div>{{ CountryService::getLabel($addr['country'], $lang ?? 'en') }}</div>@endif
                </div>
            </div>
            @endif

            {{-- Line items --}}
            @if ($items && $items->count())
            <div style="margin-bottom:28px;">
                <h2 style="font-size:11px; font-weight:700; color:#9ca3af; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 14px;">{{ $t['items'] }}</h2>
                <div style="border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
                    <table style="width:100%; border-collapse:collapse; font-size:13px;">
                        <thead>
                            <tr style="background:#f9fafb; border-bottom:1px solid #e5e7eb;">
                                <th style="padding:10px 14px; text-align:left; color:#374151; font-weight:600;">{{ $t['description'] }}</th>
                                <th style="padding:10px 14px; text-align:center; color:#374151; font-weight:600;">{{ $t['qty'] }}</th>
                                <th style="padding:10px 14px; text-align:right; color:#374151; font-weight:600;">{{ $t['unit_price'] }}</th>
                                <th style="padding:10px 14px; text-align:right; color:#374151; font-weight:600;">{{ $t['tax'] }}</th>
                                <th style="padding:10px 14px; text-align:right; color:#374151; font-weight:600;">{{ $t['total'] }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr style="border-bottom:1px solid #f3f4f6;">
                                <td style="padding:10px 14px; color:#111827;">{{ $item->description }}</td>
                                <td style="padding:10px 14px; text-align:center; color:#6b7280;">{{ $item->quantity }}</td>
                                <td style="padding:10px 14px; text-align:right; color:#6b7280;">{{ number_format((float) $item->unit_price, 2) }}</td>
                                <td style="padding:10px 14px; text-align:right; color:#6b7280;">{{ number_format($item->tax_rate * 100, 0) }}%</td>
                                <td style="padding:10px 14px; text-align:right; color:#111827; font-weight:600;">{{ number_format((float) $item->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- Summary --}}
            <div style="margin-bottom:28px;">
                <h2 style="font-size:11px; font-weight:700; color:#9ca3af; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 14px;">{{ $t['summary'] }}</h2>
                <div style="background:#fafafa; border:1px solid #f3f4f6; border-radius:12px; padding:18px 20px;">
                    <table style="width:100%; border-collapse:collapse;">
                        <tr>
                            <td style="padding:6px 0; color:#6b7280; font-size:14px;">{{ $t['status'] }}</td>
                            <td style="padding:6px 0; color:#111827; font-weight:600; font-size:14px; text-align:right; text-transform:capitalize;">{{ $invoice->status?->value ?? $invoice->status }}</td>
                        </tr>
                        @if ($invoice->issued_at)
                        <tr>
                            <td style="padding:6px 0; color:#6b7280; font-size:14px;">{{ $t['issued'] }}</td>
                            <td style="padding:6px 0; color:#111827; font-size:14px; text-align:right;">{{ $invoice->issued_at->format('d M Y') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td style="padding:6px 0; color:#6b7280; font-size:14px;">{{ $t['subtotal'] }}</td>
                            <td style="padding:6px 0; color:#111827; font-size:14px; text-align:right;">{{ number_format((float) $invoice->subtotal, 2) }}</td>
                        </tr>
                        <tr style="border-top:1px solid #e5e7eb;">
                            <td style="padding:10px 0 4px; color:#111827; font-weight:700; font-size:15px;">{{ $t['total'] }}</td>
                            <td style="padding:10px 0 4px; color:#111827; font-weight:700; font-size:15px; text-align:right;">{{ number_format((float) $invoice->total, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if ($invoice->notes)
            <div style="margin-bottom:28px;">
                <h2 style="font-size:11px; font-weight:700; color:#9ca3af; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 14px;">{{ $t['notes'] }}</h2>
                <div style="background:#fafafa; border:1px solid #f3f4f6; border-radius:12px; padding:18px 20px;">
                    <p style="color:#4b5563; font-size:14px; margin:0;">{{ $invoice->notes }}</p>
                </div>
            </div>
            @endif

        </div>

        {{-- Footer --}}
        <div style="background:#f9fafb; border-top:1px solid #f3f4f6; padding:24px 40px; text-align:center;">
            <p style="color:#9ca3af; font-size:13px; margin:0;">{{ $t['email_footer'] }}</p>
        </div>
    </div>
</body>
</html>
