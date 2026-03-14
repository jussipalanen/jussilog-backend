<?php

namespace App\Http\Controllers;

use App\Enums\InvoiceItemType;
use App\Enums\InvoiceStatus;
use App\Mail\InvoiceMail;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Translations\InvoiceTranslations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class InvoiceController extends Controller
{
    /**
     * Return available invoice statuses and item types with translated labels.
     *
     * @group Invoices
     *
     * @unauthenticated
     *
     * @queryParam lang string Language code (en, fi). Defaults to en. Example: fi
     */
    public function options(Request $request): JsonResponse
    {
        $lang = $this->resolveLanguage($request);
        $t    = InvoiceTranslations::get($lang);

        $statuses = array_map(
            fn (InvoiceStatus $s) => [
                'value' => $s->value,
                'label' => $t['status_'.$s->value] ?? $s->label(),
                'color' => $s->color(),
            ],
            InvoiceStatus::cases(),
        );

        $itemTypes = array_map(
            fn (InvoiceItemType $type) => [
                'value' => $type->value,
                'label' => $t['type_'.$type->value] ?? $type->label(),
            ],
            InvoiceItemType::cases(),
        );

        return response()->json([
            'statuses'   => $statuses,
            'item_types' => $itemTypes,
        ]);
    }

    /**
     * List invoices.
     *
     * Returns a paginated list of invoices. Results can be filtered by order, user and status.
     *
     * @group         Invoices
     *
     * @authenticated
     *
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

        $user  = $request->user();
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

        $sortBy       = $request->query('sort_by', 'created_at');
        $sortDir      = strtolower($request->query('sort_dir', 'desc'));
        $allowedSorts = ['id', 'invoice_number', 'subtotal', 'total', 'status', 'issued_at', 'paid_at', 'created_at'];
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
     * List invoices for the authenticated user.
     *
     * Returns a paginated list of invoices belonging to the currently authenticated user.
     *
     * @group         Invoices
     *
     * @authenticated
     *
     * @queryParam    per_page integer Items per page (1–100). Example: 10
     * @queryParam    page integer Page number. Example: 1
     * @queryParam    status string Filter by status (draft, issued, paid, cancelled). Example: paid
     * @queryParam    sort_by string Sort field (id, invoice_number, subtotal, total, status, issued_at, paid_at, created_at). Example: created_at
     * @queryParam    sort_dir string Sort direction (asc, desc). Example: desc
     */
    public function myInvoices(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 10);
        $perPage = max(1, min(100, $perPage));

        $query = Invoice::with(['order', 'items'])
            ->where('user_id', $request->user()->id);

        if ($request->has('status')) {
            $query->where('status', $request->query('status'));
        }

        $sortBy       = $request->query('sort_by', 'created_at');
        $sortDir      = strtolower($request->query('sort_dir', 'desc'));
        $allowedSorts = ['id', 'invoice_number', 'subtotal', 'total', 'status', 'issued_at', 'paid_at', 'created_at'];
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
     * Create an invoice.
     *
     * Creates a new invoice for the given order and automatically generates invoice items from the order's line items.
     *
     * @group     Invoices
     *
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
                'due_date' => 'nullable|date',
                'notes'    => 'nullable|string',
                'status'   => 'sometimes|string|in:draft,issued,unpaid,overdue,paid,cancelled',
            ]
        );

        $order = Order::with('items.product')->findOrFail($data['order_id']);
        assert($order instanceof Order);

        $status = $data['status'] ?? InvoiceStatus::DRAFT->value;

        $invoice = null;

        DB::transaction(
            function () use ($order, $data, $status, &$invoice) {
                $invoice = Invoice::create(
                    [
                        'order_id'            => $order->id,
                        'user_id'             => $order->user_id,
                        'invoice_number'      => null,
                        'customer_first_name' => $order->customer_first_name,
                        'customer_last_name'  => $order->customer_last_name,
                        'customer_email'      => $order->customer_email,
                        'customer_phone'      => $order->customer_phone,
                        'billing_address'     => $order->billing_address,
                        'subtotal'            => $order->total_amount,
                        'total'               => $order->total_amount,
                        'status'              => $status,
                        'issued_at'           => $status === InvoiceStatus::ISSUED->value ? now() : null,
                        'due_date'            => $data['due_date'] ?? null,
                        'paid_at'             => $status === InvoiceStatus::PAID->value ? now() : null,
                        'notes'               => $data['notes'] ?? null,
                    ]
                );

                $invoice->invoice_number = 'INV-'.date('Y').'-'.str_pad((string) $invoice->id, 5, '0', STR_PAD_LEFT);
                $invoice->save();

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
            }
        );

        return response()->json($invoice->load(['order', 'user', 'items']), 201);
    }

    /**
     * Get an invoice.
     *
     * Returns a single invoice with its items, associated order and user.
     *
     * @group         Invoices
     *
     * @authenticated
     *
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

        if (! $invoice) {
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
     *
     * @authenticated
     *
     * @urlParam      id integer required The invoice ID. Example: 1
     *
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

        if (! $invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $data = $request->validate(
            [
                'status'              => 'sometimes|string|in:draft,issued,unpaid,overdue,paid,cancelled',
                'customer_first_name' => 'sometimes|string|max:255',
                'customer_last_name'  => 'sometimes|string|max:255',
                'customer_email'      => 'sometimes|email|max:255',
                'customer_phone'      => 'sometimes|nullable|string|max:50',
                'billing_address'     => 'sometimes|array',
                'subtotal'            => 'sometimes|numeric|min:0',
                'total'               => 'sometimes|numeric|min:0',
                'due_date'            => 'sometimes|nullable|date',
                'notes'               => 'nullable|string',
                'items'               => 'sometimes|array',
                'items.*.id'          => 'sometimes|integer|exists:invoice_items,id',
                'items.*.type'        => 'required_with:items|string|in:product,shipping,discount,fee,other',
                'items.*.description' => 'required_with:items|string|max:500',
                'items.*.quantity'    => 'required_with:items|integer|min:1',
                'items.*.unit_price'  => 'required_with:items|numeric',
                'items.*.tax_rate'    => 'sometimes|numeric|min:0|max:1',
                'items.*.total'       => 'required_with:items|numeric',
            ]
        );

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

        foreach (['customer_first_name', 'customer_last_name', 'customer_email', 'billing_address', 'subtotal', 'total', 'due_date', 'notes'] as $field) {
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

                if (! empty($itemData['id'])) {
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
     *
     * @authenticated
     *
     * @urlParam      id integer required The invoice ID. Example: 1
     *
     * @response 200 scenario="Deleted" {"message": "Invoice deleted"}
     * @response 403 scenario="Forbidden" {"message": "Forbidden."}
     * @response 404 scenario="Not found" {"message": "Invoice not found"}
     */
    public function destroy(int $id): JsonResponse
    {
        $invoice = Invoice::find($id);

        if (! $invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted']);
    }

    /**
     * Send an invoice by email.
     *
     * Sends the invoice as a PDF attachment to the customer email or to a specific email address if provided.
     *
     * @group         Invoices
     *
     * @authenticated
     *
     * @urlParam      id integer required The invoice ID. Example: 1
     *
     * @bodyParam     email string Optional recipient email. Defaults to the invoice's customer email. Example: someone@example.com
     *
     * @response 200 scenario="Sent" {"message": "Invoice sent to someone@example.com"}
     * @response 403 scenario="Forbidden" {"message": "Forbidden."}
     * @response 404 scenario="Not found" {"message": "Invoice not found"}
     * @response 422 scenario="Validation error" {"message": "The email field must be a valid email address.", "errors": {}}
     */
    public function sendEmail(Request $request, int $id): JsonResponse
    {
        $invoice = Invoice::with(['order', 'user', 'items'])->find($id);

        if (! $invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $data = $request->validate([
            'email' => 'sometimes|nullable|email',
            'lang'  => 'sometimes|nullable|string|in:en,fi',
        ]);

        $recipient = $data['email'] ?? $invoice->customer_email;

        if (! $recipient) {
            return response()->json(['message' => 'No recipient email address available.'], 422);
        }

        $lang       = $this->resolveLanguage($request);
        $pdfContent = Pdf::view('invoices.pdf', ['invoice' => $invoice, 'lang' => $lang, 't' => InvoiceTranslations::get($lang)])
            ->format('a4')
            ->withBrowsershot(fn (Browsershot $b) => $b
                ->setChromePath(env('CHROME_PATH', '/usr/bin/chromium-browser'))
                ->noSandbox()
                ->addChromiumArguments(['--disable-gpu'])
            )
            ->base64();

        Mail::to($recipient)->send(new InvoiceMail($invoice, base64_decode($pdfContent), $lang));

        return response()->json(['message' => 'Invoice sent to '.$recipient]);
    }

    /**
     * Download invoice as PDF.
     *
     * Returns a PDF file of the invoice.
     *
     * @group         Invoices
     *
     * @authenticated
     *
     * @urlParam      id integer required The invoice ID. Example: 1
     *
     * @response 200 scenario="PDF file" {"binary": "application/pdf"}
     * @response 403 scenario="Forbidden" {"message": "Forbidden."}
     * @response 404 scenario="Not found" {"message": "Invoice not found"}
     */
    public function pdf(Request $request, int $id): Response|JsonResponse
    {
        $invoice = Invoice::with(['order', 'user', 'items'])->find($id);

        if (! $invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $user = $request->user();
        if ($user->hasRole('customer') && $invoice->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $lang     = $this->resolveLanguage($request);
        $filename = $invoice->invoice_number.'.pdf';

        return Pdf::view('invoices.pdf', ['invoice' => $invoice, 'lang' => $lang, 't' => InvoiceTranslations::get($lang)])
            ->format('a4')
            ->withBrowsershot(fn (Browsershot $b) => $b
                ->setChromePath(env('CHROME_PATH', '/usr/bin/chromium-browser'))
                ->noSandbox()
                ->addChromiumArguments(['--disable-gpu'])
            )
            ->download($filename)
            ->toResponse($request);
    }

    /**
     * Download a stored invoice as HTML.
     *
     * @group         Invoices
     *
     * @authenticated
     *
     * @urlParam      id integer required The invoice ID. Example: 1
     *
     * @response 200 scenario="HTML file" {"binary": "text/html"}
     * @response 403 scenario="Forbidden" {"message": "Forbidden."}
     * @response 404 scenario="Not found" {"message": "Invoice not found"}
     */
    public function html(Request $request, int $id): Response|JsonResponse
    {
        $invoice = Invoice::with(['order', 'user', 'items'])->find($id);

        if (! $invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $user = $request->user();
        if ($user->hasRole('customer') && $invoice->user_id !== $user->id) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $lang     = $this->resolveLanguage($request);
        $t        = InvoiceTranslations::get($lang);
        $html     = view('invoices.pdf', compact('invoice', 'lang', 't'))->render();
        $filename = $invoice->invoice_number.'.html';

        return response()->make($html, 200, [
            'Content-Type'        => 'text/html',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    /**
     * Export a preview invoice as PDF (no auth, no database save).
     *
     * Builds a transient invoice from the request body and returns it as a downloadable PDF.
     *
     * @group  Invoices
     *
     * @unauthenticated
     *
     * @bodyParam invoice_number string Invoice number shown on the document. Example: INV-2026-00001
     * @bodyParam customer_first_name string Customer first name. Example: Jussi
     * @bodyParam customer_last_name string Customer last name. Example: Palanen
     * @bodyParam customer_email string Customer email. Example: jussi@example.com
     * @bodyParam customer_phone string Customer phone. Example: +358401234567
     * @bodyParam billing_address object Billing address (street, city, postal_code, country).
     * @bodyParam subtotal number Invoice subtotal. Example: 99.00
     * @bodyParam total number Invoice total. Example: 122.76
     * @bodyParam status string Invoice status (draft, issued, paid, cancelled). Example: draft
     * @bodyParam notes string Optional notes. Example: Thank you for your business.
     * @bodyParam items array Invoice line items.
     * @bodyParam items[].type string required Item type (product, shipping, discount, adjustment). Example: product
     * @bodyParam items[].description string required Item description. Example: Example Product
     * @bodyParam items[].quantity integer required Quantity. Example: 2
     * @bodyParam items[].unit_price number required Unit price. Example: 49.50
     * @bodyParam items[].tax_rate number Tax rate (0–1). Example: 0.24
     * @bodyParam items[].total number required Line total. Example: 99.00
     *
     * @response 200 scenario="PDF file" {"binary": "application/pdf"}
     * @response 422 scenario="Validation error" {"message": "The items.0.type field is required.", "errors": {}}
     */
    public function exportPdf(Request $request): Response
    {
        $invoice  = $this->buildPreviewInvoice($request);
        $lang     = $this->resolveLanguage($request);
        $filename = ($invoice->invoice_number ?: 'invoice-preview').'.pdf';

        return Pdf::view('invoices.pdf', ['invoice' => $invoice, 'lang' => $lang, 't' => InvoiceTranslations::get($lang)])
            ->format('a4')
            ->withBrowsershot(fn (Browsershot $b) => $b
                ->setChromePath(env('CHROME_PATH', '/usr/bin/chromium-browser'))
                ->noSandbox()
                ->addChromiumArguments(['--disable-gpu'])
            )
            ->download($filename)
            ->toResponse($request);
    }

    /**
     * Export a preview invoice as HTML (no auth, no database save).
     *
     * Builds a transient invoice from the request body and returns it as an HTML file.
     *
     * @group  Invoices
     *
     * @unauthenticated
     *
     * @bodyParam invoice_number string Invoice number shown on the document. Example: INV-2026-00001
     * @bodyParam customer_first_name string Customer first name. Example: Jussi
     * @bodyParam customer_last_name string Customer last name. Example: Palanen
     * @bodyParam customer_email string Customer email. Example: jussi@example.com
     * @bodyParam customer_phone string Customer phone. Example: +358401234567
     * @bodyParam billing_address object Billing address (street, city, postal_code, country).
     * @bodyParam subtotal number Invoice subtotal. Example: 99.00
     * @bodyParam total number Invoice total. Example: 122.76
     * @bodyParam status string Invoice status (draft, issued, paid, cancelled). Example: draft
     * @bodyParam notes string Optional notes. Example: Thank you for your business.
     * @bodyParam items array Invoice line items.
     * @bodyParam items[].type string required Item type (product, shipping, discount, adjustment). Example: product
     * @bodyParam items[].description string required Item description. Example: Example Product
     * @bodyParam items[].quantity integer required Quantity. Example: 2
     * @bodyParam items[].unit_price number required Unit price. Example: 49.50
     * @bodyParam items[].tax_rate number Tax rate (0–1). Example: 0.24
     * @bodyParam items[].total number required Line total. Example: 99.00
     *
     * @response 200 scenario="HTML file" {"binary": "text/html"}
     * @response 422 scenario="Validation error" {"message": "The items.0.type field is required.", "errors": {}}
     */
    public function exportHtml(Request $request): Response
    {
        $invoice = $this->buildPreviewInvoice($request);
        $lang    = $this->resolveLanguage($request);
        $t       = InvoiceTranslations::get($lang);

        $html     = view('invoices.pdf', compact('invoice', 'lang', 't'))->render();
        $filename = ($invoice->invoice_number ?: 'invoice-preview').'.html';

        return response()->make($html, 200, [
            'Content-Type'        => 'text/html',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    /**
     * Send a preview invoice by email (no auth, no database save).
     *
     * Builds a transient invoice from the request body and sends it to `to_email`.
     * If `to_email` is omitted, falls back to `customer_email` in the payload.
     *
     * @group  Invoices
     *
     * @unauthenticated
     *
     * @bodyParam to_email string required Recipient email address. Example: someone@example.com
     * @bodyParam invoice_number string Invoice number shown on the document. Example: INV-2026-00001
     * @bodyParam customer_first_name string Customer first name. Example: Jussi
     * @bodyParam customer_last_name string Customer last name. Example: Palanen
     * @bodyParam customer_email string Customer email shown on the document. Example: jussi@example.com
     * @bodyParam customer_phone string Customer phone. Example: +358401234567
     * @bodyParam billing_address object Billing address (street, city, postal_code, country).
     * @bodyParam subtotal number Invoice subtotal. Example: 99.00
     * @bodyParam total number Invoice total. Example: 122.76
     * @bodyParam status string Invoice status (draft, issued, paid, cancelled). Example: draft
     * @bodyParam notes string Optional notes. Example: Thank you for your business.
     * @bodyParam items array Invoice line items.
     * @bodyParam items[].type string required Item type (product, shipping, discount, adjustment). Example: product
     * @bodyParam items[].description string required Item description. Example: Example Product
     * @bodyParam items[].quantity integer required Quantity. Example: 2
     * @bodyParam items[].unit_price number required Unit price. Example: 49.50
     * @bodyParam items[].tax_rate number Tax rate (0–1). Example: 0.24
     * @bodyParam items[].total number required Line total. Example: 99.00
     *
     * @response 200 scenario="Sent" {"message": "Invoice sent to someone@example.com"}
     * @response 422 scenario="Validation error" {"message": "The to email field is required.", "errors": {}}
     */
    public function exportEmail(Request $request): JsonResponse
    {
        $request->validate(['to_email' => 'required|email|max:255']);

        $invoice   = $this->buildPreviewInvoice($request);
        $lang      = $this->resolveLanguage($request);
        $recipient = $request->input('to_email');

        Mail::to($recipient)->send(new InvoiceMail($invoice, null, $lang));

        return response()->json(['message' => 'Invoice sent to '.$recipient]);
    }

    private function resolveLanguage(Request $request): string
    {
        $lang = strtolower((string) ($request->query('lang') ?? $request->input('lang', 'en')));

        return in_array($lang, ['en', 'fi'], true) ? $lang : 'en';
    }

    private function buildPreviewInvoice(Request $request): Invoice
    {
        $data = $request->validate(
            [
                'invoice_number'      => 'nullable|string|max:100',
                'customer_first_name' => 'nullable|string|max:255',
                'customer_last_name'  => 'nullable|string|max:255',
                'customer_email'      => 'nullable|email|max:255',
                'customer_phone'      => 'nullable|string|max:50',
                'billing_address'     => 'nullable|array',
                'subtotal'            => 'nullable|numeric|min:0',
                'total'               => 'nullable|numeric|min:0',
                'status'              => 'nullable|string|in:draft,issued,unpaid,overdue,paid,cancelled',
                'due_date'            => 'nullable|date',
                'notes'               => 'nullable|string',
                'items'               => 'nullable|array',
                'items.*.type'        => 'required_with:items|string|in:product,shipping,discount,adjustment',
                'items.*.description' => 'required_with:items|string|max:500',
                'items.*.quantity'    => 'required_with:items|integer|min:1',
                'items.*.unit_price'  => 'required_with:items|numeric',
                'items.*.tax_rate'    => 'nullable|numeric|min:0|max:1',
                'items.*.total'       => 'required_with:items|numeric',
            ]
        );

        $invoice                      = new Invoice;
        $invoice->invoice_number      = $data['invoice_number'] ?? 'PREVIEW';
        $invoice->customer_first_name = $data['customer_first_name'] ?? '';
        $invoice->customer_last_name  = $data['customer_last_name'] ?? '';
        $invoice->customer_email      = $data['customer_email'] ?? null;
        $invoice->customer_phone      = $data['customer_phone'] ?? null;
        $invoice->billing_address     = $data['billing_address'] ?? null;
        $invoice->subtotal            = $data['subtotal'] ?? 0;
        $invoice->total               = $data['total'] ?? 0;
        $invoice->status              = $data['status'] ?? InvoiceStatus::DRAFT->value;
        $invoice->due_date            = $data['due_date'] ?? null;
        $invoice->notes               = $data['notes'] ?? null;
        $invoice->created_at          = now();

        $items = collect($data['items'] ?? [])->map(function (array $itemData) {
            $item              = new InvoiceItem;
            $item->type        = $itemData['type'];
            $item->description = $itemData['description'];
            $item->quantity    = $itemData['quantity'];
            $item->unit_price  = $itemData['unit_price'];
            $item->tax_rate    = $itemData['tax_rate'] ?? 0;
            $item->total       = $itemData['total'];

            return $item;
        });

        $invoice->setRelation('items', $items);
        $invoice->setRelation('order', null);

        return $invoice;
    }
}
