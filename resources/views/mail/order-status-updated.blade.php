@php use App\Services\OrderStatusConfig; @endphp
@php
    $c              = OrderStatusConfig::get($order->status);
    $oldStatusLabel = $t['status_' . $oldStatus] ?? ucfirst($oldStatus);
    $newStatusLabel = $t['status_' . $order->status] ?? ucfirst($order->status);
@endphp
@php
    $dec   = ($lang ?? 'en') === 'fi' ? ',' : '.';
    $thou  = ($lang ?? 'en') === 'fi' ? "\u{00A0}" : ',';
    $price = fn($v) => number_format((float) $v, 2, $dec, $thou);
@endphp
<!DOCTYPE html>
<html lang="{{ $lang ?? 'en' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $t['heading_' . $order->status] ?? 'Order Status Updated' }}</title>
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
            style="background:{{ $c['header_bg'] }}; padding:48px 40px 40px; text-align:center; position:relative;">
            <div
                style="display:inline-block; background:{{ $c['badge_bg'] }}; border:1px solid {{ $c['badge_border'] }}; border-radius:50px; padding:6px 18px; margin-bottom:20px;">
                <span
                    style="color:{{ $c['accent'] }}; font-size:11px; font-weight:600; letter-spacing:2px; text-transform:uppercase;">{{ $t['badge_' . $order->status] ?? 'Order Updated' }}</span>
            </div>
            <div style="font-size:48px; margin-bottom:12px;">{{ $c['icon'] }}</div>
            <h1 style="color:#ffffff; font-size:28px; font-weight:700; margin:0 0 10px;">
                {{ $t['heading_' . $order->status] ?? 'Status Updated' }}</h1>
            <p style="color:#b8aff5; font-size:15px; margin:0 0 24px; line-height:1.6;">
                {{ $t['hi'] }} <strong style="color:#ede9fe;">{{ $order->customer_first_name }}</strong>,
            </p>
            @if ($order->order_number)
                <div
                    style="display:inline-block; background:rgba(255,255,255,0.08); border:1px solid rgba(196,181,253,0.25); border-radius:10px; padding:12px 28px;">
                    <span
                        style="color:#a5b4fc; font-size:12px; font-weight:600; letter-spacing:1px; text-transform:uppercase; display:block; margin-bottom:2px;">{{ $t['order_number'] }}</span>
                    <span
                        style="color:#ffffff; font-size:18px; font-weight:700; font-family:monospace;">#{{ $order->order_number }}</span>
                </div>
            @endif
        </div>

        <div style="padding:36px 40px;">

            {{-- Status transition --}}
            <div style="margin-bottom:28px;">
                <p
                    style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 12px;">
                    {{ $t['status_updated'] }}</p>
                <div
                    style="background:#1a1735; border:1px solid #2d2956; border-radius:14px; padding:18px 20px; display:flex; align-items:center; gap:12px;">
                    <div style="flex:1; text-align:center;">
                        <span
                            style="font-size:10px; font-weight:600; color:#4e4a80; letter-spacing:1px; text-transform:uppercase; display:block; margin-bottom:6px;">{{ $t['previous_status'] }}</span>
                        <span
                            style="display:inline-block; background:rgba(74,69,128,0.3); border:1px solid #3d3866; border-radius:6px; padding:5px 14px; color:#9490cc; font-weight:600; font-size:13px;">{{ $oldStatusLabel }}</span>
                    </div>
                    <div style="color:#4e4a80; font-size:20px; flex-shrink:0;">→</div>
                    <div style="flex:1; text-align:center;">
                        <span
                            style="font-size:10px; font-weight:600; color:#4e4a80; letter-spacing:1px; text-transform:uppercase; display:block; margin-bottom:6px;">{{ $t['new_status'] }}</span>
                        <span
                            style="display:inline-block; background:{{ $c['badge_bg'] }}; border:1px solid {{ $c['badge_border'] }}; border-radius:6px; padding:5px 14px; color:{{ $c['accent'] }}; font-weight:700; font-size:13px;">{{ $newStatusLabel }}</span>
                    </div>
                </div>
            </div>

            {{-- Status message --}}
            <div
                style="background:{{ $c['bg'] }}; border:1px solid {{ $c['border'] }}; border-radius:12px; padding:18px 20px; margin-bottom:28px;">
                <p style="color:{{ $c['accent'] }}; font-size:15px; margin:0; line-height:1.7;">
                    {{ $t['message_' . $order->status] ?? '' }}
                </p>
            </div>

            {{-- Order Summary --}}
            @if ($order->items && $order->items->count())
                <div style="margin-bottom:28px;">
                    <p
                        style="font-size:10px; font-weight:700; color:#4e4a80; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 12px;">
                        {{ $t['order_summary'] }}</p>
                    <div style="border:1px solid #2d2956; border-radius:14px; overflow:hidden;">
                        <table style="width:100%; border-collapse:collapse; font-size:14px;">
                            <thead>
                                <tr style="background:#1e1b4b;">
                                    <th
                                        style="padding:12px 16px; text-align:left; color:#c4b5fd; font-weight:600; font-size:12px; letter-spacing:0.5px;">
                                        {{ $t['col_product'] }}</th>
                                    <th
                                        style="padding:12px 16px; text-align:center; color:#c4b5fd; font-weight:600; font-size:12px;">
                                        {{ $t['col_qty'] }}</th>
                                    <th
                                        style="padding:12px 16px; text-align:right; color:#c4b5fd; font-weight:600; font-size:12px;">
                                        {{ $t['col_total'] }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr style="border-bottom:1px solid #2d2956;">
                                        <td style="padding:12px 16px; color:#ede9fe; font-weight:500;">
                                            {{ $item->product_title }}</td>
                                        <td style="padding:12px 16px; text-align:center; color:#9490cc;">
                                            {{ $item->quantity }}</td>
                                        <td style="padding:12px 16px; text-align:right; color:#ede9fe; font-weight:600;">
                                            €{{ $price($item->subtotal) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background:linear-gradient(135deg, #1e1b4b, #2d1f5a);">
                                    <td colspan="2"
                                        style="padding:14px 16px; text-align:right; color:#c4b5fd; font-weight:600; font-size:13px;">
                                        {{ $t['order_total'] }}</td>
                                    <td
                                        style="padding:14px 16px; text-align:right; color:#ffffff; font-weight:700; font-size:16px;">
                                        €{{ $price($order->total_amount) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Closing message --}}
            <div
                style="background:#130d2e; border:1px solid rgba(196,181,253,0.18); border-radius:14px; padding:22px 24px; text-align:center;">
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
