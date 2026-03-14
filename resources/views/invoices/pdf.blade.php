<!DOCTYPE html>
<html lang="{{ $lang ?? 'en' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #1a1a1a; background: #fff; }

        .page { padding: 40px; }

        /* Header */
        .header { display: table; width: 100%; margin-bottom: 40px; }
        .header-left { display: table-cell; vertical-align: top; width: 60%; }
        .header-right { display: table-cell; vertical-align: top; text-align: right; }
        .company-name { font-size: 22px; font-weight: bold; color: #111; }
        .invoice-label { font-size: 28px; font-weight: bold; color: #111; text-transform: uppercase; letter-spacing: 2px; }
        .invoice-number { font-size: 14px; color: #555; margin-top: 4px; }

        /* Status badge */
        .status-badge { display: inline-block; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; margin-top: 8px; }
        .status-draft      { background: #e5e7eb; color: #374151; }
        .status-issued     { background: #dbeafe; color: #1d4ed8; }
        .status-unpaid     { background: #ffedd5; color: #c2410c; }
        .status-overdue    { background: #fee2e2; color: #b91c1c; }
        .status-paid       { background: #dcfce7; color: #15803d; }
        .status-cancelled  { background: #e5e7eb; color: #374151; }

        /* Addresses */
        .addresses { display: table; width: 100%; margin-bottom: 36px; }
        .address-block { display: table-cell; width: 50%; vertical-align: top; }
        .address-block h3 { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 8px; }
        .address-block p { line-height: 1.7; color: #333; }

        /* Dates */
        .meta-row { display: table; width: 100%; margin-bottom: 36px; }
        .meta-cell { display: table-cell; width: 33%; vertical-align: top; }
        .meta-cell h3 { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 4px; }
        .meta-cell p { color: #333; }

        /* Items table */
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        table.items thead tr { background: #f3f4f6; }
        table.items th { padding: 10px 12px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #555; border-bottom: 2px solid #e5e7eb; }
        table.items th.num { text-align: right; }
        table.items td { padding: 10px 12px; border-bottom: 1px solid #f0f0f0; vertical-align: top; color: #333; }
        table.items td.num { text-align: right; }
        table.items tbody tr:last-child td { border-bottom: none; }

        /* Totals */
        .totals { float: right; width: 260px; margin-bottom: 40px; }
        .totals table { width: 100%; border-collapse: collapse; }
        .totals td { padding: 6px 0; color: #333; }
        .totals td.label { color: #666; }
        .totals td.amount { text-align: right; }
        .totals tr.grand-total td { font-size: 15px; font-weight: bold; padding-top: 10px; border-top: 2px solid #111; color: #111; }

        /* Notes */
        .notes { clear: both; margin-top: 40px; padding-top: 20px; border-top: 1px solid #e5e7eb; }
        .notes h3 { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 6px; }
        .notes p { color: #555; line-height: 1.6; }

        /* Footer */
        .footer { margin-top: 48px; padding-top: 16px; border-top: 1px solid #e5e7eb; text-align: center; font-size: 11px; color: #aaa; }
    </style>
</head>
<body>
@php
    $dec   = ($lang ?? 'en') === 'fi' ? ',' : '.';
    $thou  = ($lang ?? 'en') === 'fi' ? "\u{00A0}" : ',';
    $price = fn($v) => number_format((float) $v, 2, $dec, $thou);
@endphp
<div class="page">

    {{-- Header --}}
    <div class="header">
        <div class="header-left">
            <div class="company-name">{{ config('app.name') }}</div>
        </div>
        <div class="header-right">
            <div class="invoice-label">{{ $t['invoice'] }}</div>
            <div class="invoice-number">{{ $invoice->invoice_number }}</div>
            @php $statusClass = 'status-' . $invoice->status->value; @endphp
            <span class="status-badge {{ $statusClass }}">{{ $t['status_' . $invoice->status->value] ?? $invoice->status->label() }}</span>
        </div>
    </div>

    {{-- Meta --}}
    <div class="meta-row">
        <div class="meta-cell">
            <h3>{{ $t['invoice_date'] }}</h3>
            <p>{{ $invoice->created_at->format(($lang ?? 'en') === 'fi' ? 'd.m.Y' : 'j M Y') }}</p>
        </div>
        @if($invoice->issued_at)
        <div class="meta-cell">
            <h3>{{ $t['issued'] }}</h3>
            <p>{{ $invoice->issued_at->format(($lang ?? 'en') === 'fi' ? 'd.m.Y' : 'j M Y') }}</p>
        </div>
        @endif
        @if($invoice->due_date)
        <div class="meta-cell">
            <h3>{{ $t['due_date'] }}</h3>
            <p>{{ $invoice->due_date->format(($lang ?? 'en') === 'fi' ? 'd.m.Y' : 'j M Y') }}</p>
        </div>
        @endif
        @if($invoice->paid_at)
        <div class="meta-cell">
            <h3>{{ $t['paid'] }}</h3>
            <p>{{ $invoice->paid_at->format(($lang ?? 'en') === 'fi' ? 'd.m.Y' : 'j M Y') }}</p>
        </div>
        @endif
    </div>

    {{-- Addresses --}}
    <div class="addresses">
        <div class="address-block">
            <h3>{{ $t['bill_to'] }}</h3>
            <p>
                {{ $invoice->customer_first_name }} {{ $invoice->customer_last_name }}<br>
                @if($invoice->customer_email){{ $invoice->customer_email }}<br>@endif
                @if($invoice->customer_phone){{ $invoice->customer_phone }}<br>@endif
                @if($invoice->billing_address)
                    @if($addr = $invoice->billing_address)
                        @if(!empty($addr['street'])){{ $addr['street'] }}<br>@endif
                        @if(!empty($addr['postal_code']) || !empty($addr['city']))
                            {{ $addr['postal_code'] ?? '' }} {{ $addr['city'] ?? '' }}<br>
                        @endif
                        @if(!empty($addr['country']))
                            {{ \App\Services\CountryService::getLabel($addr['country'], $lang ?? 'en') }}
                        @endif
                    @endif
                @endif
            </p>
        </div>
        <div class="address-block">
            @if($invoice->order)
            <h3>{{ $t['order_reference'] }}</h3>
            <p>
                {{ $t['order'] }} #{{ $invoice->order->order_number }}<br>
                {{ $invoice->order->created_at->format(($lang ?? 'en') === 'fi' ? 'd.m.Y' : 'j M Y') }}
            </p>
            @endif
        </div>
    </div>

    {{-- Items --}}
    <table class="items">
        <thead>
            <tr>
                <th style="width:40%">{{ $t['description'] }}</th>
                <th>{{ $t['type'] }}</th>
                <th class="num">{{ $t['qty'] }}</th>
                <th class="num">{{ $t['unit_price'] }}</th>
                <th class="num">{{ $t['tax'] }}</th>
                <th class="num">{{ $t['total'] }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td>{{ $t['type_' . $item->type->value] ?? ucfirst($item->type->value) }}</td>
                <td class="num">{{ $item->quantity }}</td>
                <td class="num">&euro;{{ $price($item->unit_price) }}</td>
                <td class="num">{{ str_replace('.', ',', rtrim(rtrim(number_format($item->tax_rate * 100, 2), '0'), '.')) }}%</td>
                <td class="num">&euro;{{ $price($item->total) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Totals --}}
    <div class="totals">
        <table>
            <tr>
                <td class="label">{{ $t['subtotal'] }}</td>
                <td class="amount">&euro;{{ $price($invoice->subtotal) }}</td>
            </tr>
            <tr class="grand-total">
                <td class="label">{{ $t['total'] }}</td>
                <td class="amount">&euro;{{ $price($invoice->total) }}</td>
            </tr>
        </table>
    </div>

    {{-- Notes --}}
    @if($invoice->notes)
    <div class="notes">
        <h3>{{ $t['notes'] }}</h3>
        <p>{{ $invoice->notes }}</p>
    </div>
    @endif

    <div class="footer">
        {{ $t['generated_on'] }} {{ now()->format('d M Y, H:i') }} &mdash; {{ config('app.name') }}
    </div>

</div>
</body>
</html>
