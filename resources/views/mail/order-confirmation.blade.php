<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body style="background: linear-gradient(135deg, #f0f4ff 0%, #faf5ff 100%); margin:0; padding:0;">
    <div style="max-width:620px; margin:40px auto; background:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 8px 40px rgba(0,0,0,0.10);">

        {{-- Header --}}
        <div style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 60%, #4c1d95 100%); padding:48px 40px 40px; text-align:center; position:relative;">
            <div style="display:inline-block; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.2); border-radius:50px; padding:6px 18px; margin-bottom:20px;">
                <span style="color:#c4b5fd; font-size:11px; font-weight:600; letter-spacing:2px; text-transform:uppercase;">Order Confirmation</span>
            </div>
            <div style="font-size:48px; margin-bottom:12px;">🎉</div>
            <h1 style="color:#ffffff; font-size:28px; font-weight:700; margin:0 0 10px;">Thank you for your order!</h1>
            <p style="color:#c4b5fd; font-size:15px; margin:0 0 24px;">
                Hi <strong style="color:#ede9fe;">{{ $order->customer_first_name }}</strong>, your order has been received and is being processed.
            </p>
            @if ($order->order_number)
                <div style="display:inline-block; background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.25); border-radius:8px; padding:10px 24px;">
                    <span style="color:#a5b4fc; font-size:12px; font-weight:600; letter-spacing:1px; text-transform:uppercase; display:block; margin-bottom:2px;">Order Number</span>
                    <span style="color:#ffffff; font-size:18px; font-weight:700; font-family:monospace;">#{{ $order->order_number }}</span>
                </div>
            @endif
        </div>

        <div style="padding:36px 40px;">

            {{-- Customer info --}}
            <div style="margin-bottom:28px;">
                <h2 style="font-size:11px; font-weight:700; color:#9ca3af; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 14px;">Customer</h2>
                <div style="background:#fafafa; border:1px solid #f3f4f6; border-radius:12px; padding:18px 20px;">
                    <p style="color:#111827; font-weight:600; font-size:16px; margin:0 0 4px;">{{ $order->customer_first_name }} {{ $order->customer_last_name }}</p>
                    <p style="color:#6b7280; font-size:14px; margin:0 0 2px;">✉️ &nbsp;{{ $order->customer_email }}</p>
                    @if ($order->customer_phone)
                        <p style="color:#6b7280; font-size:14px; margin:0;">📞 &nbsp;{{ $order->customer_phone }}</p>
                    @endif
                </div>
            </div>

            {{-- Address grid: Billing first, then Shipping --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:28px;">
                <div style="background:#fafafa; border:1px solid #f3f4f6; border-radius:12px; padding:18px 20px;">
                    <h2 style="font-size:11px; font-weight:700; color:#9ca3af; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 10px;">📄 &nbsp;Billing Address</h2>
                    <address style="font-style:normal; color:#4b5563; font-size:14px; line-height:1.7;">
                        @foreach ($order->billing_address ?? [] as $value)
                            @if ($value){{ $value }}<br>@endif
                        @endforeach
                    </address>
                </div>
                <div style="background:#fafafa; border:1px solid #f3f4f6; border-radius:12px; padding:18px 20px;">
                    <h2 style="font-size:11px; font-weight:700; color:#9ca3af; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 10px;">🚚 &nbsp;Shipping Address</h2>
                    <address style="font-style:normal; color:#4b5563; font-size:14px; line-height:1.7;">
                        @foreach ($order->shipping_address ?? [] as $value)
                            @if ($value){{ $value }}<br>@endif
                        @endforeach
                    </address>
                </div>
            </div>

            {{-- Order items --}}
            <div style="margin-bottom:28px;">
                <h2 style="font-size:11px; font-weight:700; color:#9ca3af; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 14px;">Order Summary</h2>
                <div style="border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">
                    <table style="width:100%; border-collapse:collapse; font-size:14px;">
                        <thead>
                            <tr style="background:#f9fafb; border-bottom:1px solid #e5e7eb;">
                                <th style="padding:12px 16px; text-align:left; color:#374151; font-weight:600; font-size:13px;">Product</th>
                                <th style="padding:12px 16px; text-align:center; color:#374151; font-weight:600; font-size:13px;">Qty</th>
                                <th style="padding:12px 16px; text-align:right; color:#374151; font-weight:600; font-size:13px;">Price</th>
                                <th style="padding:12px 16px; text-align:right; color:#374151; font-weight:600; font-size:13px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr style="border-bottom:1px solid #f3f4f6;">
                                    <td style="padding:14px 16px; color:#111827; font-weight:500;">{{ $item->product_title }}</td>
                                    <td style="padding:14px 16px; text-align:center; color:#6b7280;">{{ $item->quantity }}</td>
                                    <td style="padding:14px 16px; text-align:right; color:#6b7280;">
                                        @if ($item->sale_price)
                                            <span style="text-decoration:line-through; color:#9ca3af; margin-right:4px;">€{{ number_format((float) $item->unit_price, 2) }}</span>
                                            <span style="color:#059669; font-weight:600;">€{{ number_format((float) $item->sale_price, 2) }}</span>
                                        @else
                                            €{{ number_format((float) $item->unit_price, 2) }}
                                        @endif
                                    </td>
                                    <td style="padding:14px 16px; text-align:right; color:#111827; font-weight:600;">€{{ number_format((float) $item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="background: linear-gradient(135deg, #1e1b4b, #4c1d95);">
                                <td colspan="3" style="padding:16px; text-align:right; color:#c4b5fd; font-weight:600; font-size:14px; letter-spacing:0.5px;">Order Total</td>
                                <td style="padding:16px; text-align:right; color:#ffffff; font-weight:700; font-size:18px;">€{{ number_format((float) $order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Notes --}}
            @if ($order->notes)
                <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:12px; padding:18px 20px; margin-bottom:28px;">
                    <h2 style="font-size:11px; font-weight:700; color:#d97706; letter-spacing:1.5px; text-transform:uppercase; margin:0 0 8px;">📝 &nbsp;Order Notes</h2>
                    <p style="color:#92400e; font-size:14px; margin:0; line-height:1.6;">{{ $order->notes }}</p>
                </div>
            @endif

            {{-- Closing message --}}
            <div style="background:#f5f3ff; border-radius:12px; padding:20px 24px; text-align:center;">
                <p style="color:#6d28d9; font-size:14px; font-weight:500; margin:0 0 4px;">Questions about your order?</p>
                <p style="color:#7c3aed; font-size:13px; margin:0;">Simply reply to this email and we'll be happy to help.</p>
            </div>
        </div>

        {{-- Footer --}}
        <div style="background:#1e1b4b; padding:24px 40px; text-align:center;">
            <p style="color:#a5b4fc; font-size:13px; margin:0 0 4px; font-weight:600;">{{ config('app.name') }}</p>
            <p style="color:#6366f1; font-size:12px; margin:0;">&copy; {{ date('Y') }} All rights reserved.</p>
        </div>
    </div>
</body>
</html>
