<?php

namespace App\Http\Controllers;

use App\Enums\InvoiceItemType;
use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    /**
     * List invoices.
     *
     * Returns a paginated list of invoices. Results can be filtered by order, user and status.
     *
     * @group         Invoices
     * @authenticated
     * @queryParam    per_page integer Items per page (1–100). Example: 25
     * @queryParam    page integer Page number. Example: 2
     * @queryParam    order_id integer Filter by order ID. Example: 5
     * @queryParam    user_id integer Filter by user ID. Example: 3
     * @queryParam    status string Filter by status (draft, issued, paid, cancelled). Example: issued
     * @queryParam    sort_by string Sort field (id, invoice_number, subtotal, total, status, issued_at, paid_at, created_at). Example: created_at
     * @queryParam    sort_dir string Sort direction (asc, desc). Example: desc
     *
     * @response 200 scenario="Success" {
     *   "current_page": 1,
     *   "data": [
     *     {
     *       "id": 1,
     *       "order_id": 1,
     *       "user_id": 2,
     *       "invoice_number": "INV-2026-00001",
     *       "customer_first_name": "Jussi",
     *       "customer_last_name": "Palanen",
     *       "customer_email": "jussi@example.com",
     *       "customer_phone": "+358401234567",
     *       "billing_address": {"street": "Mannerheimintie 1", "city": "Helsinki", "postal_code": "00100", "country": "FI"},
     *       "subtotal": "99.00",
     *       "total": "99.00",
     *       "status": "issued",
     *       "issued_at": "2026-03-10T20:00:00.000000Z",
     *       "paid_at": null,
     *       "notes": null,
     *       "created_at": "2026-03-10T19:00:00.000000Z",
     *       "updated_at": "2026-03-10T20:00:00.000000Z"
     *     }
     *   ],
     *   "per_page": 25,
     *   "total": 1
     * }
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $user = $request->user();
        $query = Invoice::with(['order', 'user', 'items']);

        // Customers can only see their own invoices
        if ($user->hasRole('customer')) {
            $query->where('user_id', $user->id);
        } else {
            if ($request->has('order_id')) {
                $query->where('order_id', $request->query('order_id'));
            }

            if ($request->has('user_id')) {
                $query->where('user_id', $request->query('user_id'));
            }
        }

        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }

        $sortBy = $request->query('sort_by', 'created_at');
        $sortDir = strtolower($request->query('sort_dir', 'desc'));
        $allowedSorts = ['id', 'invoice_number', 'subtotal', 'total', 'status', 'issued_at', 'paid_at', 'created_at'];
        $allowedDirs = ['asc', 'desc'];

        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'created_at';
        }
        if (!in_array($sortDir, $allowedDirs, true)) {
            $sortDir = 'desc';
        }

        $query->orderBy($sortBy, $sortDir);

        return response()->json($query->paginate($perPage));
    }

    /**
     * Create an invoice.
     *
     * Creates a new invoice for the given order and automatically generates invoice items from the order's line items.
     *
     * @group     Invoices
     * @bodyParam order_id integer required The ID of the order to invoice. Example: 1
     * @bodyParam status string Invoice status on creation (draft, issued, paid, cancelled). Defaults to draft. Example: draft
     * @bodyParam notes string Optional free-text notes. Example: Net 30
     *
     * @response 201 scenario="Created" {
     *   "id": 1,
     *   "order_id": 1,
     *   "user_id": 2,
     *   "invoice_number": "INV-2026-00001",
     *   "customer_first_name": "Jussi",
     *   "customer_last_name": "Palanen",
     *   "customer_email": "jussi@example.com",
     *   "customer_phone": "+358401234567",
     *   "billing_address": {"street": "Mannerheimintie 1", "city": "Helsinki", "postal_code": "00100", "country": "FI"},
     *   "subtotal": "99.00",
     *   "total": "99.00",
     *   "status": "draft",
     *   "issued_at": null,
     *   "paid_at": null,
     *   "notes": "Net 30",
     *   "items": [
     *     {
     *       "id": 1,
     *       "invoice_id": 1,
     *       "order_item_id": 3,
     *       "type": "product",
     *       "description": "Example Product",
     *       "quantity": 2,
     *       "unit_price": "49.50",
     *       "tax_rate": "0.0000",
     *       "total": "99.00"
     *     }
     *   ],
     *   "created_at": "2026-03-10T19:00:00.000000Z",
     *   "updated_at": "2026-03-10T19:00:00.000000Z"
     * }
     * @response 422 scenario="Validation error" {
     *   "message": "The order id field is required.",
     *   "errors": {"order_id": ["The order id field is required."]}
     * }
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate(
            [
            'order_id' => 'required|integer|exists:orders,id',
            'notes' => 'nullable|string',
            'status' => 'sometimes|string|in:draft,issued,paid,cancelled',
            ]
        );

        $order = Order::with('items.product')->findOrFail($data['order_id']);

        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad((string) (Invoice::count() + 1), 5, '0', STR_PAD_LEFT);

        $status = $data['status'] ?? InvoiceStatus::DRAFT->value;

        $invoice = Invoice::create(
            [
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'invoice_number' => $invoiceNumber,
            'customer_first_name' => $order->customer_first_name,
            'customer_last_name' => $order->customer_last_name,
            'customer_email' => $order->customer_email,
            'customer_phone' => $order->customer_phone,
            'billing_address' => $order->billing_address,
            'subtotal' => $order->total_amount,
            'total' => $order->total_amount,
            'status' => $status,
            'issued_at' => $status === InvoiceStatus::ISSUED->value ? now() : null,
            'paid_at' => $status === InvoiceStatus::PAID->value ? now() : null,
            'notes' => $data['notes'] ?? null,
            ]
        );

        // Create invoice items from order items
        foreach ($order->items as $orderItem) {
            InvoiceItem::create(
                [
                'invoice_id'    => $invoice->id,
                'order_item_id' => $orderItem->id,
                'type'          => InvoiceItemType::PRODUCT->value,
                'description'   => $orderItem->product_title,
                'quantity'      => $orderItem->quantity,
                'unit_price'    => $orderItem->unit_price,
                'tax_rate'      => 0,
                'total'         => $orderItem->subtotal,
                ]
            );
        }

        return response()->json($invoice->load(['order', 'user', 'items']), 201);
    }

    /**
     * Get an invoice.
     *
     * Returns a single invoice with its items, associated order and user.
     *
     * @group         Invoices
     * @authenticated
     * @urlParam      id integer required The invoice ID. Example: 1
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "order_id": 1,
     *   "user_id": 2,
     *   "invoice_number": "INV-2026-00001",
     *   "status": "issued",
     *   "items": [],
     *   "created_at": "2026-03-10T19:00:00.000000Z",
     *   "updated_at": "2026-03-10T20:00:00.000000Z"
     * }
     * @response 403 scenario="Forbidden" {"message": "Forbidden."}
     * @response 404 scenario="Not found" {"message": "Invoice not found"}
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $invoice = Invoice::with(['order.items.product', 'user', 'items.orderItem'])->find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $user = $request->user();
        if ($user->hasRole('customer') && $invoice->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        return response()->json($invoice);
    }

    /**
     * Update an invoice.
     *
     * Updates an existing invoice. Automatically sets `issued_at` when status changes to `issued`, and `paid_at` when status changes to `paid`.
     *
     * @group         Invoices
     * @authenticated
     * @urlParam      id integer required The invoice ID. Example: 1
     * @bodyParam     status string Invoice status (draft, issued, paid, cancelled). Example: issued
     * @bodyParam     customer_first_name string Customer first name. Example: Jussi
     * @bodyParam     customer_last_name string Customer last name. Example: Palanen
     * @bodyParam     customer_email string Customer email address. Example: jussi@example.com
     * @bodyParam     customer_phone string Customer phone number. Example: +358401234567
     * @bodyParam     billing_address object Billing address object.
     * @bodyParam     subtotal number Subtotal amount. Example: 153.47
     * @bodyParam     total number Total amount. Example: 153.47
     * @bodyParam     notes string Free-text notes. Example: Net 30
     * @bodyParam     items object[] Optional array of invoice items to sync. Items with `id` are updated, items without `id` are created, existing items omitted from the array are deleted.
     * @bodyParam     items[].id integer Existing item ID to update. Omit to create a new item. Example: 1
     * @bodyParam     items[].type string Item type (product, shipping, discount, adjustment). Example: product
     * @bodyParam     items[].description string Item description. Example: Wireless Headphones
     * @bodyParam     items[].quantity integer Quantity. Example: 2
     * @bodyParam     items[].unit_price number Unit price. Example: 79.99
     * @bodyParam     items[].tax_rate number Tax rate as decimal (e.g. 0.24 = 24%). Example: 0.24
     * @bodyParam     items[].total number Line total. Example: 159.98
     *
     * @response 200 scenario="Success" {
     *   "id": 1,
     *   "order_id": 1,
     *   "user_id": 2,
     *   "invoice_number": "INV-2026-00001",
     *   "customer_first_name": "Jussi",
     *   "customer_last_name": "Palanen",
     *   "customer_email": "jussi@example.com",
     *   "customer_phone": "+358401234567",
     *   "billing_address": {"street": "Mannerheimintie 1", "city": "Helsinki", "postal_code": "00100", "country": "FI"},
     *   "subtotal": "99.00",
     *   "total": "99.00",
     *   "status": "issued",
     *   "issued_at": "2026-03-10T20:00:00.000000Z",
     *   "paid_at": null,
     *   "notes": "Net 30",
     *   "items": [],
     *   "created_at": "2026-03-10T19:00:00.000000Z",
     *   "updated_at": "2026-03-10T20:00:00.000000Z"
     * }
     * @response 404 scenario="Not found" {"message": "Invoice not found"}
     * @response 422 scenario="Validation error" {
     *   "message": "The status field must be one of draft, issued, paid, cancelled.",
     *   "errors": {"status": ["The status field must be one of draft, issued, paid, cancelled."]}
     * }
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $data = $request->validate([
            'status'              => 'sometimes|string|in:draft,issued,paid,cancelled',
            'customer_first_name' => 'sometimes|string|max:255',
            'customer_last_name'  => 'sometimes|string|max:255',
            'customer_email'      => 'sometimes|email|max:255',
            'customer_phone'      => 'sometimes|nullable|string|max:50',
            'billing_address'     => 'sometimes|array',
            'subtotal'            => 'sometimes|numeric|min:0',
            'total'               => 'sometimes|numeric|min:0',
            'notes'               => 'nullable|string',
            'items'               => 'sometimes|array',
            'items.*.id'          => 'sometimes|integer|exists:invoice_items,id',
            'items.*.type'        => 'required_with:items|string|in:product,shipping,discount,adjustment',
            'items.*.description' => 'required_with:items|string|max:500',
            'items.*.quantity'    => 'required_with:items|integer|min:1',
            'items.*.unit_price'  => 'required_with:items|numeric',
            'items.*.tax_rate'    => 'sometimes|numeric|min:0|max:1',
            'items.*.total'       => 'required_with:items|numeric',
        ]);

        if (isset($data['status'])) {
            $newStatus = InvoiceStatus::from($data['status']);

            if ($newStatus === InvoiceStatus::ISSUED && $invoice->status !== InvoiceStatus::ISSUED) {
                $invoice->issued_at = now();
            }

            if ($newStatus === InvoiceStatus::PAID && $invoice->status !== InvoiceStatus::PAID) {
                $invoice->paid_at = now();
            }

            $invoice->status = $newStatus;
        }

        foreach (['customer_first_name', 'customer_last_name', 'customer_email', 'billing_address', 'subtotal', 'total', 'notes'] as $field) {
            if (array_key_exists($field, $data)) {
                $invoice->{$field} = $data[$field];
            }
        }

        if (array_key_exists('customer_phone', $data)) {
            $invoice->customer_phone = $data['customer_phone'];
        }

        $invoice->save();

        // Sync items if provided
        if (array_key_exists('items', $data)) {
            $incomingIds = collect($data['items'])->pluck('id')->filter()->values();

            // Delete items not present in the payload
            $invoice->items()->whereNotIn('id', $incomingIds)->delete();

            foreach ($data['items'] as $itemData) {
                $fields = [
                    'type'        => $itemData['type'],
                    'description' => $itemData['description'],
                    'quantity'    => $itemData['quantity'],
                    'unit_price'  => $itemData['unit_price'],
                    'tax_rate'    => $itemData['tax_rate'] ?? 0,
                    'total'       => $itemData['total'],
                ];

                if (!empty($itemData['id'])) {
                    // Update existing item (must belong to this invoice)
                    $invoice->items()->where('id', $itemData['id'])->update($fields);
                } else {
                    // Create new item
                    $invoice->items()->create($fields);
                }
            }
        }

        return response()->json($invoice->load(['order', 'user', 'items']));
    }

    /**
     * Delete an invoice.
     *
     * Permanently deletes an invoice and all its associated items.
     *
     * @group         Invoices
     * @authenticated
     * @urlParam      id integer required The invoice ID. Example: 1
     *
     * @response 200 scenario="Deleted" {"message": "Invoice deleted"}
     * @response 403 scenario="Forbidden" {"message": "Forbidden."}
     * @response 404 scenario="Not found" {"message": "Invoice not found"}
     */
    public function destroy(int $id): JsonResponse
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted']);
    }

    /**
     * Download invoice as PDF.
     *
     * Returns a PDF file of the invoice.
     *
     * @group         Invoices
     * @authenticated
     * @urlParam      id integer required The invoice ID. Example: 1
     *
     * @response 200 scenario="PDF file" {"binary": "application/pdf"}
     * @response 403 scenario="Forbidden" {"message": "Forbidden."}
     * @response 404 scenario="Not found" {"message": "Invoice not found"}
     */
    public function pdf(Request $request, int $id): Response|JsonResponse
    {
        $invoice = Invoice::with(['order', 'user', 'items'])->find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $user = $request->user();
        if ($user->hasRole('customer') && $invoice->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))
            ->setPaper('a4', 'portrait');

        $filename = $invoice->invoice_number . '.pdf';

        return $pdf->download($filename);
    }
}
