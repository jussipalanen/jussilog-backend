<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thanks for an order</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-white">Thanks for an order placement</h1>
        <p class="mb-6 text-gray-700 dark:text-gray-300">We have received your order and will start processing it soon.</p>

        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
            <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Customer details</h2>
            <p class="text-gray-700 dark:text-gray-300">
                {{ $order->customer_first_name }} {{ $order->customer_last_name }}<br>
                {{ $order->customer_email }}
                @if ($order->customer_phone)
                    <br>{{ $order->customer_phone }}
                @endif
            </p>
        </div>

        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
            <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Shipping address</h2>
            <p class="text-gray-700 dark:text-gray-300">
                @foreach ($order->shipping_address ?? [] as $key => $value)
                    {{ ucfirst(str_replace('_', ' ', (string) $key)) }}: {{ $value }}<br>
                @endforeach
            </p>
        </div>

        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
            <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Billing address</h2>
            <p class="text-gray-700 dark:text-gray-300">
                @foreach ($order->billing_address ?? [] as $key => $value)
                    {{ ucfirst(str_replace('_', ' ', (string) $key)) }}: {{ $value }}<br>
                @endforeach
            </p>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Items</h2>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300 dark:border-gray-700">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-800">
                            <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-left text-gray-900 dark:text-white">Product</th>
                            <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-right text-gray-900 dark:text-white">Qty</th>
                            <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-right text-gray-900 dark:text-white">Unit price</th>
                            <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-right text-gray-900 dark:text-white">Sale price</th>
                            <th class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-right text-gray-900 dark:text-white">Line total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr class="bg-white dark:bg-gray-900">
                                <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-700 dark:text-gray-300">{{ $item->product_title }}</td>
                                <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-right text-gray-700 dark:text-gray-300">{{ $item->quantity }}</td>
                                <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-right text-gray-700 dark:text-gray-300">
                                    @if ($item->sale_price)
                                        <span class="line-through text-gray-500 dark:text-gray-500">{{ number_format((float) $item->unit_price, 2) }}</span>
                                    @else
                                        {{ number_format((float) $item->unit_price, 2) }}
                                    @endif
                                </td>
                                <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-right text-gray-700 dark:text-gray-300">
                                    @if ($item->sale_price)
                                        <span class="text-green-600 dark:text-green-400 font-semibold">{{ number_format((float) $item->sale_price, 2) }}</span>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-right text-gray-700 dark:text-gray-300">{{ number_format((float) $item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-100 dark:bg-gray-800 font-bold">
                            <td colspan="4" class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-right text-gray-900 dark:text-white">Total</td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-right text-gray-900 dark:text-white">{{ number_format((float) $order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
