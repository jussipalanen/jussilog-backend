<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     *
     * @group Orders
     *
     * @queryParam per_page integer Items per page. Example: 25
     * @queryParam page integer Page number. Example: 2
     * @queryParam user_id integer Filter by user ID. Example: 5
     * @queryParam customer_id integer Legacy filter by user ID. Example: 5
     * @queryParam status string Filter by status. Example: pending
     * @queryParam sort_by string Sort field. Example: created_at
     * @queryParam sort_dir string Sort direction. Example: desc
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $query = Order::with(['user', 'items.product']);

        // Filter by user_id (or customer_id for backward compatibility)
        if ($request->has('user_id')) {
            $query->where('user_id', $request->query('user_id'));
        } elseif ($request->has('customer_id')) {
            $query->where('user_id', $request->query('customer_id'));
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }

        // Sort
        $sortBy       = $request->query('sort_by', 'created_at');
        $sortDir      = strtolower($request->query('sort_dir', 'desc'));
        $allowedSorts = ['id', 'order_number', 'total_amount', 'status', 'created_at', 'updated_at'];
        $allowedDirs  = ['asc', 'desc'];

        if (! in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'created_at';
        }
        if (! in_array($sortDir, $allowedDirs, true)) {
            $sortDir = 'desc';
        }

        $query->orderBy($sortBy, $sortDir);

        return response()->json($query->paginate($perPage));
    }

    /**
     * Display a listing of orders for the authenticated user.
     *
     * @group Orders
     *
     * @authenticated
     *
     * @queryParam per_page integer Items per page. Example: 25
     * @queryParam page integer Page number. Example: 2
     * @queryParam status string Filter by status. Example: pending
     * @queryParam sort_by string Sort field. Example: created_at
     * @queryParam sort_dir string Sort direction. Example: desc
     */
    public function myOrders(Request $request): JsonResponse
    {
        $user = $request->user();
        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $perPage = (int) $request->query('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $query = Order::with(['user', 'items.product'])
            ->where('user_id', $user->id);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }

        // Sort
        $sortBy       = $request->query('sort_by', 'created_at');
        $sortDir      = strtolower($request->query('sort_dir', 'desc'));
        $allowedSorts = ['id', 'order_number', 'total_amount', 'status', 'created_at', 'updated_at'];
        $allowedDirs  = ['asc', 'desc'];

        if (! in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'created_at';
        }
        if (! in_array($sortDir, $allowedDirs, true)) {
            $sortDir = 'desc';
        }

        $query->orderBy($sortBy, $sortDir);

        return response()->json($query->paginate($perPage));
    }

    /**
     * Store a newly created order.
     *
     * @group Orders
     *
     * @bodyParam user_id integer Optional user ID. Example: 5
     * @bodyParam customer_first_name string required First name. Example: Jussi
     * @bodyParam customer_last_name string required Last name. Example: Palanen
     * @bodyParam customer_email string required Email address. Example: jussi@example.com
     * @bodyParam customer_phone string Phone number. Example: +358401234567
     * @bodyParam shipping_address object required Shipping address object.
     * @bodyParam billing_address object Billing address object.
     * @bodyParam notes string Order notes.
     * @bodyParam items array required Order items array.
     * @bodyParam items.*.product_id integer required Product ID. Example: 1
     * @bodyParam items.*.quantity integer required Quantity. Example: 2
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'customer_first_name' => 'required|string|max:255',
            'customer_last_name'  => 'required|string|max:255',
            'customer_email'      => 'required|email|max:255',
            'customer_phone'      => 'nullable|string|max:50',
            'shipping_address'    => 'required|array',
            'billing_address'     => 'nullable|array',
            'notes'               => 'nullable|string',
            'items'               => 'required|array|min:1',
            'items.*.product_id'  => 'required|integer|exists:products,id',
            'items.*.quantity'    => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($data, $request) {
            $userId = $request->input('user_id');

            // Generate unique order number
            $orderNumber = 'ORD-'.date('Y').'-'.str_pad(Order::count() + 1, 5, '0', STR_PAD_LEFT);

            // Calculate total
            $totalAmount = 0;
            $orderItems  = [];

            foreach ($data['items'] as $item) {
                // Lock the product row to avoid race conditions on concurrent orders.
                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();
                $effectivePrice = $product->sale_price ?? $product->price;
                $subtotal       = $effectivePrice * $item['quantity'];
                $totalAmount += $subtotal;

                // Allow backorders by letting quantity go negative.
                $currentQuantity   = $product->quantity ?? 0;
                $product->quantity = $currentQuantity - $item['quantity'];
                $product->save();

                $orderItems[] = [
                    'product_id'    => $product->id,
                    'product_title' => $product->title,
                    'quantity'      => $item['quantity'],
                    'unit_price'    => $product->price,
                    'sale_price'    => $product->sale_price,
                    'subtotal'      => $subtotal,
                ];
            }

            // Create order
            $order = Order::create([
                'user_id'             => $userId,
                'order_number'        => $orderNumber,
                'status'              => 'pending',
                'total_amount'        => $totalAmount,
                'customer_first_name' => $data['customer_first_name'],
                'customer_last_name'  => $data['customer_last_name'],
                'customer_email'      => $data['customer_email'],
                'customer_phone'      => $data['customer_phone'] ?? null,
                'shipping_address'    => $data['shipping_address'],
                'billing_address'     => $data['billing_address'] ?? $data['shipping_address'],
                'notes'               => $data['notes'] ?? null,
            ]);

            // Create order items
            foreach ($orderItems as $itemData) {
                $order->items()->create($itemData);
            }

            $order->load('items');

            $lang = in_array(strtolower((string) $request->query('lang', 'en')), ['en', 'fi'], true)
                ? strtolower((string) $request->query('lang', 'en'))
                : 'en';

            Mail::to($order->customer_email)->send(new OrderConfirmation($order, $lang));

            return response()->json($order->load(['user', 'items.product']), 201);
        });
    }

    /**
     * Display the specified order.
     *
     * @group Orders
     *
     * @urlParam id integer required Order ID. Example: 1
     */
    public function show(int $id): JsonResponse
    {
        $order = Order::with(['user', 'items.product'])->find($id);

        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    /**
     * Update the specified order.
     *
     * @group Orders
     *
     * @urlParam id integer required Order ID. Example: 1
     *
     * @bodyParam status string Order status. Example: processing
     * @bodyParam customer_first_name string First name. Example: Jussi
     * @bodyParam customer_last_name string Last name. Example: Palanen
     * @bodyParam customer_email string Email address. Example: jussi@example.com
     * @bodyParam customer_phone string Phone number. Example: +358401234567
     * @bodyParam shipping_address object Shipping address object.
     * @bodyParam billing_address object Billing address object.
     * @bodyParam notes string Order notes.
     * @bodyParam items array Order items array.
     * @bodyParam items.*.product_id integer Product ID. Example: 1
     * @bodyParam items.*.quantity integer Quantity. Example: 2
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $order = Order::find($id);

        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $data = $request->validate([
            'status'              => 'sometimes|string|in:pending,processing,completed,cancelled,refunded',
            'customer_first_name' => 'sometimes|string|max:255',
            'customer_last_name'  => 'sometimes|string|max:255',
            'customer_email'      => 'sometimes|email|max:255',
            'customer_phone'      => 'sometimes|nullable|string|max:50',
            'shipping_address'    => 'sometimes|array',
            'billing_address'     => 'sometimes|array',
            'notes'               => 'nullable|string',
            'items'               => 'sometimes|array|min:1',
            'items.*.product_id'  => 'required_with:items|integer|exists:products,id',
            'items.*.quantity'    => 'required_with:items|integer|min:1',
        ]);

        return DB::transaction(function () use ($order, $data) {
            // Update order fields
            if (isset($data['status'])) {
                $order->status = $data['status'];
            }
            if (isset($data['customer_first_name'])) {
                $order->customer_first_name = $data['customer_first_name'];
            }
            if (isset($data['customer_last_name'])) {
                $order->customer_last_name = $data['customer_last_name'];
            }
            if (isset($data['customer_email'])) {
                $order->customer_email = $data['customer_email'];
            }
            if (array_key_exists('customer_phone', $data)) {
                $order->customer_phone = $data['customer_phone'];
            }
            if (isset($data['shipping_address'])) {
                $order->shipping_address = $data['shipping_address'];
            }
            if (isset($data['billing_address'])) {
                $order->billing_address = $data['billing_address'];
            }
            if (array_key_exists('notes', $data)) {
                $order->notes = $data['notes'];
            }

            // Update items if provided
            if (isset($data['items'])) {
                // Delete existing items
                $order->items()->delete();

                // Recalculate total and create new items
                $totalAmount = 0;
                foreach ($data['items'] as $item) {
                    $product        = Product::findOrFail($item['product_id']);
                    $effectivePrice = $product->sale_price ?? $product->price;
                    $subtotal       = $effectivePrice * $item['quantity'];
                    $totalAmount += $subtotal;

                    $order->items()->create([
                        'product_id'    => $product->id,
                        'product_title' => $product->title,
                        'quantity'      => $item['quantity'],
                        'unit_price'    => $product->price,
                        'sale_price'    => $product->sale_price,
                        'subtotal'      => $subtotal,
                    ]);
                }
                $order->total_amount = $totalAmount;
            }

            $order->save();

            return response()->json($order->load(['user', 'items.product']));
        });
    }

    /**
     * Remove the specified order.
     *
     * @group Orders
     *
     * @urlParam id integer required Order ID. Example: 1
     */
    public function destroy(int $id): JsonResponse
    {
        $order = Order::find($id);

        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted']);
    }
}
