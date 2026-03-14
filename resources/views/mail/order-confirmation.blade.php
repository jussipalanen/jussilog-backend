@php use App\Services\CountryService; @endphp
<!DOCTYPE html>
<html lang="{{ $lang ?? 'en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $t['heading'] }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        * { box-sizing: border-box; }
        body { font-family: 'Inter', Arial, sans-serif; }
    </style>
</head>
<body style="margin:0; padding:30px 16px; background:linear-gradient(135deg, #080714 0%, #130d2e 100%); min-height:100vh;">
    <div style="max-width:620px; margin:0 auto; background:#100e25; border-radius:20px; overflow:hidden; border:1px solid #2a2754; box-shadow:0 24px 64px rgba(0,0,0,0.6);">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg, #0f0c2e 0%, #1e1047 50%, #3b1264 100%); padding:48px 40px 40px; text-align:center; position:relative;">
            <div style="display:inline-block; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); border-radius:50px; padding:6px 18px; margin-bottom:20px;">
                <span style="color:#c4b5fd; font-size:11px; font-weight:600; letter-spacing:2px; text-transform:uppercase;">{{ $t['badge'] }}</span>
            </div>
            <div style="font-size:48px; margin-bottom:12px;">🎉</div>
            <h1 style="color:#ffffff; font-size:28px; font-weight:700; margin:0 0 10px;">{{ $t['heading'] }}</h1>
            <p style="color:#b8aff5; font-size:15px; margin:0 0 24px; line-height:1.6;">
                {{ $t['hi'] }} <strong style="color:#ede9fe;">{{ $order->customer_first_name }}</strong>{{ $t['greeting'] }}
            </p>
            @if ($order->order_number)
                <div style="display:inline-block; background:rgba(255,255,255,0.08); border:1px solid rgba(196,181,253,0.25); border-radius:10px; padding:12px 28px;">
                    <span style="color:#a5b4fc; font-size:12px; font-weight:600; letter-spacing:1px; text-transform:uppercase; display:block; margin-bottom:2px;">{{ $t['order_number'] }}</span>
                    <span style="color:#ffffff; font-size:18px; font-weight:700; font-family:monospace;">#{{ $order->order_number }}</span>
                </div>
            @endif
        </div>

        <div style="padding:36px 40px;">

            {{-- Customer info --}}
            <div style="margin-bottom:28px;">
                <p style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 12px;">{{ $t['customer'] }}</p>
                <div style="background:#1a1735; border:1px solid #2d2956; border-radius:14px; padding:18px 20px;">
                    <p style="color:#ede9fe; font-weight:600; font-size:16px; margin:0 0 5px;">{{ $order->customer_first_name }} {{ $order->customer_last_name }}</p>
                    <p style="color:#9490cc; font-size:14px; margin:0 0 3px;">✉️ &nbsp;{{ $order->customer_email }}</p>
                    @if ($order->customer_phone)
                        <p style="color:#9490cc; font-size:14px; margin:0;">📞 &nbsp;{{ $order->customer_phone }}</p>
                    @endif
                </div>
            </div>

            {{-- Address grid: Billing first, then Shipping --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:28px;">
                <div style="background:#1a1735; border:1px solid #2d2956; border-radius:14px; padding:18px 20px;">
                    <p style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 10px;">📄 &nbsp;{{ $t['billing_address'] }}</p>
                    <address style="font-style:normal; color:#9490cc; font-size:14px; line-height:1.7;">
                        @foreach ($order->billing_address ?? [] as $key => $value)
                            @if ($value){{ $key === 'country' ? CountryService::getLabel($value) : $value }}<br>@endif
                        @endforeach
                    </address>
                </div>
                <div style="background:#1a1735; border:1px solid #2d2956; border-radius:14px; padding:18px 20px;">
                    <p style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 10px;">🚚 &nbsp;{{ $t['shipping_address'] }}</p>
                    <address style="font-style:normal; color:#9490cc; font-size:14px; line-height:1.7;">
                        @foreach ($order->shipping_address ?? [] as $key => $value)
                            @if ($value){{ $key === 'country' ? CountryService::getLabel($value) : $value }}<br>@endif
                        @endforeach
                    </address>
                </div>
            </div>

            {{-- Order items --}}
            <div style="margin-bottom:28px;">
                <p style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 12px;">{{ $t['order_summary'] }}</p>
                <div style="border:1px solid #2d2956; border-radius:14px; overflow:hidden;">
                    <table style="width:100%; border-collapse:collapse; font-size:14px;">
                        <thead>
                            <tr style="background:#1e1b4b;">
                                <th style="padding:12px 16px; text-align:left; color:#c4b5fd; font-weight:600; font-size:12px; letter-spacing:0.5px;">{{ $t['col_product'] }}</th>
                                <th style="padding:12px 16px; text-align:center; color:#c4b5fd; font-weight:600; font-size:12px;">{{ $t['col_qty'] }}</th>
                                <th style="padding:12px 16px; text-align:right; color:#c4b5fd; font-weight:600; font-size:12px;">{{ $t['col_price'] }}</th>
                                <th style="padding:12px 16px; text-align:right; color:#c4b5fd; font-weight:600; font-size:12px;">{{ $t['col_total'] }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr style="border-bottom:1px solid #2d2956;">
                                    <td style="padding:13px 16px; color:#ede9fe; font-weight:500;">{{ $item->product_title }}</td>
                                    <td style="padding:13px 16px; text-align:center; color:#9490cc;">{{ $item->quantity }}</td>
                                    <td style="padding:13px 16px; text-align:right; color:#9490cc;">
                                        @if ($item->sale_price)
                                            <span style="text-decoration:line-through; color:#4e4a80; margin-right:4px;">€{{ number_format((float) $item->unit_price, 2) }}</span>
                                            <span style="color:#34d399; font-weight:600;">€{{ number_format((float) $item->sale_price, 2) }}</span>
                                        @else
                                            €{{ number_format((float) $item->unit_price, 2) }}
                                        @endif
                                    </td>
                                    <td style="padding:13px 16px; text-align:right; color:#ede9fe; font-weight:600;">€{{ number_format((float) $item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background:linear-gradient(135deg, #1e1b4b, #3b1264);">
                                <td colspan="3" style="padding:16px; text-align:right; color:#c4b5fd; font-weight:600; font-size:13px; letter-spacing:0.5px;">{{ $t['order_total'] }}</td>
                                <td style="padding:16px; text-align:right; color:#ffffff; font-weight:700; font-size:18px;">€{{ number_format((float) $order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Notes --}}
            @if ($order->notes)
                <div style="background:#1c1304; border:1px solid #78350f; border-radius:12px; padding:16px 20px; margin-bottom:28px;">
                    <p style="font-size:10px; font-weight:700; color:#d97706; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 8px;">📝 &nbsp;{{ $t['order_notes'] }}</p>
                    <p style="color:#fcd34d; font-size:14px; margin:0; line-height:1.6;">{{ $order->notes }}</p>
                </div>
            @endif

            {{-- Closing message --}}
            <div style="background:#130d2e; border:1px solid rgba(196,181,253,0.18); border-radius:14px; padding:22px 24px; text-align:center;">
                <p style="color:#c4b5fd; font-size:14px; font-weight:500; margin:0 0 5px;">{{ $t['questions'] }}</p>
                <p style="color:#7c6fad; font-size:13px; margin:0;">{{ $t['questions_body'] }}</p>
            </div>
        </div>

        {{-- Footer --}}
        <div style="background:#080614; border-top:1px solid #1e1b3a; padding:24px 40px; text-align:center;">
            <p style="color:#c4b5fd; font-size:13px; margin:0 0 4px; font-weight:600;">{{ config('app.name') }}</p>
            <p style="color:#3d3a66; font-size:12px; margin:0;">&copy; {{ date('Y') }} {{ $t['all_rights'] }}</p>
        </div>
    </div>
</body>
</html>
