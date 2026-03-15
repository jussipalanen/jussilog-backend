@php use App\Services\CountryService; @endphp
@php use App\Services\BarcodeService; @endphp
@php
    $dec = ($lang ?? 'en') === 'fi' ? ',' : '.';
    $thou = ($lang ?? 'en') === 'fi' ? "\u{00A0}" : ',';

    $price = fn($v) => number_format((float) $v, 2, $dec, $thou);
@endphp
<!DOCTYPE html>
<html lang="{{ $lang ?? 'en' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
        }
    </style>
</head>

<body
    style="margin:0; padding:30px 16px; background:linear-gradient(135deg, #080714 0%, #130d2e 100%); min-height:100vh;">
    <div
        style="max-width:620px; margin:0 auto; background:#100e25; border-radius:20px; overflow:hidden; border:1px solid #2a2754; box-shadow:0 24px 64px rgba(0,0,0,0.6);">

        {{-- Header --}}
        <div
            style="background:linear-gradient(135deg, #0f0c2e 0%, #1e1047 50%, #3b1264 100%); padding:48px 40px 40px; text-align:center;">
            <div
                style="display:inline-block; background:rgba(196,181,253,0.12); border:1px solid rgba(196,181,253,0.25); border-radius:50px; padding:6px 18px; margin-bottom:20px;">
                <span
                    style="color:#c4b5fd; font-size:11px; font-weight:600; letter-spacing:2px; text-transform:uppercase;">{{ $t['invoice'] }}</span>
            </div>
            <div style="font-size:48px; margin-bottom:12px; line-height:1;">🧾</div>
            <h1 style="color:#ffffff; font-size:26px; font-weight:700; margin:0 0 10px; line-height:1.3;">
                {{ $t['email_title'] }}</h1>
            <p style="color:#b8aff5; font-size:15px; margin:0 0 24px; line-height:1.6;">
                {{ $t['hi'] }} <strong style="color:#ede9fe;">{{ $invoice->customer_first_name }}</strong>,
                {{ $t['email_greeting'] }}
            </p>
            @if ($invoice->invoice_number)
                <div
                    style="display:inline-block; background:rgba(255,255,255,0.08); border:1px solid rgba(196,181,253,0.25); border-radius:10px; padding:12px 28px;">
                    <span
                        style="color:#c4b5fd; font-size:11px; font-weight:600; letter-spacing:1px; text-transform:uppercase; display:block; margin-bottom:4px;">{{ $t['invoice_number'] }}</span>
                    <span
                        style="color:#ffffff; font-size:20px; font-weight:700; font-family:monospace;">{{ $invoice->invoice_number }}</span>
                </div>
            @endif
        </div>

        <div style="padding:36px 40px;">

            {{-- Customer info --}}
            <div style="margin-bottom:28px;">
                <p
                    style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 12px;">
                    {{ $t['bill_to'] }}</p>
                <div style="background:#1a1735; border:1px solid #2d2956; border-radius:14px; padding:18px 20px;">
                    <p style="color:#ede9fe; font-weight:600; font-size:16px; margin:0 0 5px;">
                        {{ $invoice->customer_first_name }} {{ $invoice->customer_last_name }}</p>
                    @if ($invoice->customer_email)
                        <p style="color:#9490cc; font-size:14px; margin:0 0 3px;">✉️
                            &nbsp;{{ $invoice->customer_email }}</p>
                    @endif
                    @if ($invoice->customer_phone)
                        <p style="color:#9490cc; font-size:14px; margin:0;">📞 &nbsp;{{ $invoice->customer_phone }}</p>
                    @endif
                </div>
            </div>

            {{-- Billing address --}}
            @if ($invoice->billing_address)
                @php $addr = $invoice->billing_address; @endphp
                <div style="margin-bottom:28px;">
                    <p
                        style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 12px;">
                        {{ $t['address'] }}</p>
                    <div
                        style="background:#1a1735; border:1px solid #2d2956; border-radius:14px; padding:18px 20px; color:#9490cc; font-size:14px; line-height:1.8;">
                        @if (!empty($addr['street']))
                            <div>{{ $addr['street'] }}</div>
                        @endif
                        @if (!empty($addr['postal_code']) || !empty($addr['city']))
                            <div>{{ $addr['postal_code'] ?? '' }} {{ $addr['city'] ?? '' }}</div>
                        @endif
                        @if (!empty($addr['country']))
                            <div>{{ CountryService::getLabel($addr['country'], $lang ?? 'en') }}</div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Line items --}}
            @if ($items && $items->count())
                <div style="margin-bottom:28px;">
                    <p
                        style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 12px;">
                        {{ $t['items'] }}</p>
                    <div style="border:1px solid #2d2956; border-radius:14px; overflow:hidden;">
                        <table style="width:100%; border-collapse:collapse; font-size:13px;">
                            <thead>
                                <tr style="background:#1e1b4b;">
                                    <th
                                        style="padding:11px 14px; text-align:left; color:#c4b5fd; font-weight:600; font-size:11px; letter-spacing:0.5px;">
                                        {{ $t['description'] }}</th>
                                    <th
                                        style="padding:11px 14px; text-align:center; color:#c4b5fd; font-weight:600; font-size:11px;">
                                        {{ $t['qty'] }}</th>
                                    <th
                                        style="padding:11px 14px; text-align:right; color:#c4b5fd; font-weight:600; font-size:11px;">
                                        {{ $t['unit_price'] }}</th>
                                    <th
                                        style="padding:11px 14px; text-align:right; color:#c4b5fd; font-weight:600; font-size:11px;">
                                        {{ $t['tax'] }}</th>
                                    <th
                                        style="padding:11px 14px; text-align:right; color:#c4b5fd; font-weight:600; font-size:11px;">
                                        {{ $t['total'] }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr style="border-bottom:1px solid #2d2956;">
                                        <td style="padding:11px 14px; color:#ede9fe;">{{ $item->description }}</td>
                                        <td style="padding:11px 14px; text-align:center; color:#9490cc;">
                                            {{ $item->quantity }}</td>
                                        <td style="padding:11px 14px; text-align:right; color:#9490cc;">
                                            &euro;{{ $price($item->unit_price) }}</td>
                                        <td style="padding:11px 14px; text-align:right; color:#9490cc;">
                                            {{ str_replace('.', ',', rtrim(rtrim(number_format($item->tax_rate * 100, 2), '0'), '.')) }}%
                                        </td>
                                        <td
                                            style="padding:11px 14px; text-align:right; color:#ede9fe; font-weight:600;">
                                            &euro;{{ $price($item->total) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Summary --}}
            <div style="margin-bottom:28px;">
                <p
                    style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 12px;">
                    {{ $t['summary'] }}</p>
                <div style="background:#1a1735; border:1px solid #2d2956; border-radius:14px; padding:18px 20px;">
                    <table style="width:100%; border-collapse:collapse;">
                        <tr>
                            <td style="padding:6px 0; color:#9490cc; font-size:14px;">{{ $t['status'] }}</td>
                            <td
                                style="padding:6px 0; color:#ede9fe; font-weight:600; font-size:14px; text-align:right;">
                                {{ $t['status_' . ($invoice->status?->value ?? $invoice->status)] ?? ucfirst($invoice->status?->value ?? $invoice->status) }}
                            </td>
                        </tr>
                        @if ($invoice->issued_at)
                            <tr>
                                <td style="padding:6px 0; color:#9490cc; font-size:14px;">{{ $t['issued'] }}</td>
                                <td style="padding:6px 0; color:#ede9fe; font-size:14px; text-align:right;">
                                    {{ $invoice->issued_at->format(($lang ?? 'en') === 'fi' ? 'd.m.Y' : 'j M Y') }}
                                </td>
                            </tr>
                        @endif
                        @if ($invoice->due_date)
                            <tr>
                                <td style="padding:6px 0; color:#9490cc; font-size:14px;">{{ $t['due_date'] }}</td>
                                <td
                                    style="padding:6px 0; color:#f87171; font-weight:600; font-size:14px; text-align:right;">
                                    {{ $invoice->due_date->format(($lang ?? 'en') === 'fi' ? 'd.m.Y' : 'j M Y') }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td style="padding:6px 0; color:#9490cc; font-size:14px;">{{ $t['subtotal'] }}</td>
                            <td style="padding:6px 0; color:#ede9fe; font-size:14px; text-align:right;">
                                &euro;{{ $price($invoice->subtotal) }}</td>
                        </tr>
                        <tr style="border-top:1px solid #2d2956;">
                            <td style="padding:12px 0 4px; color:#c4b5fd; font-weight:700; font-size:16px;">
                                {{ $t['total'] }}</td>
                            <td
                                style="padding:12px 0 4px; color:#ffffff; font-weight:700; font-size:16px; text-align:right;">
                                &euro;{{ $price($invoice->total) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if ($invoice->notes)
                <div style="margin-bottom:28px;">
                    <p
                        style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 12px;">
                        {{ $t['notes'] }}</p>
                    <div style="background:#1a1735; border:1px solid #2d2956; border-radius:14px; padding:18px 20px;">
                        <p style="color:#9490cc; font-size:14px; margin:0; line-height:1.6;">{{ $invoice->notes }}</p>
                    </div>
                </div>
            @endif

        </div>

        {{-- Footer --}}
        <div style="background:#080614; border-top:1px solid #1e1b3a; padding:24px 40px; text-align:center;">
            @if ($invoice->invoice_number)
                <div style="margin-bottom:20px;">
                    <div style="display:inline-block; background:rgba(255,255,255,0.04); border:1px solid rgba(165,180,252,0.15); border-radius:10px; padding:14px 20px;">
                        {!! BarcodeService::svgLight($invoice->invoice_number, 44, 1) !!}
                        <p style="color:#4e4a80; font-size:10px; letter-spacing:2px; margin:6px 0 0; font-family:monospace;">{{ $invoice->invoice_number }}</p>
                    </div>
                </div>
            @endif
            <p style="color:#9490cc; font-size:13px; margin:0 0 8px;">{{ $t['email_footer'] }}</p>
            <p style="color:#c4b5fd; font-size:13px; margin:0 0 4px; font-weight:600;">{{ config('app.name') }}</p>
            <p style="color:#3d3a66; font-size:12px; margin:0;">&copy; {{ date('Y') }} All rights reserved.</p>
        </div>
    </div>
</body>

</html>
