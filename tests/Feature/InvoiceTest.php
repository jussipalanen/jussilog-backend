<?php

namespace Tests\Feature;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        $user = User::factory()->create();
        $user->setRole('admin');

        return $user;
    }

    private function makeCustomer(): User
    {
        return User::factory()->create();
    }

    // -------------------------------------------------------------------------
    // Options
    // -------------------------------------------------------------------------

    public function test_options_returns_statuses_and_item_types(): void
    {
        $response = $this->getJson('/api/invoices/options');

        $response->assertStatus(200)
            ->assertJsonStructure(['statuses', 'item_types'])
            ->assertJsonCount(4, 'statuses')
            ->assertJsonFragment(['value' => 'draft'])
            ->assertJsonFragment(['value' => 'issued'])
            ->assertJsonFragment(['value' => 'paid'])
            ->assertJsonFragment(['value' => 'cancelled']);
    }

    // -------------------------------------------------------------------------
    // Index
    // -------------------------------------------------------------------------

    public function test_unauthenticated_cannot_list_invoices(): void
    {
        $this->getJson('/api/invoices')->assertStatus(401);
    }

    public function test_admin_sees_all_invoices(): void
    {
        $admin    = $this->makeAdmin();
        $customer = $this->makeCustomer();

        Invoice::factory()->create(['user_id' => $admin->id]);
        Invoice::factory()->create(['user_id' => $customer->id]);

        $response = $this->actingAs($admin)->getJson('/api/invoices');

        $response->assertStatus(200);
        $this->assertGreaterThanOrEqual(2, $response->json('total'));
    }

    public function test_customer_only_sees_own_invoices(): void
    {
        $customer1 = $this->makeCustomer();
        $customer2 = $this->makeCustomer();

        Invoice::factory()->count(2)->create(['user_id' => $customer1->id]);
        Invoice::factory()->count(3)->create(['user_id' => $customer2->id]);

        $response = $this->actingAs($customer1)->getJson('/api/invoices');

        $response->assertStatus(200);
        $this->assertSame(2, $response->json('total'));

        $ids = collect($response->json('data'))->pluck('user_id')->unique()->values()->toArray();
        $this->assertSame([$customer1->id], $ids);
    }

    // -------------------------------------------------------------------------
    // Show
    // -------------------------------------------------------------------------

    public function test_admin_can_view_any_invoice(): void
    {
        $admin   = $this->makeAdmin();
        $invoice = Invoice::factory()->create();

        $this->actingAs($admin)->getJson("/api/invoices/{$invoice->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $invoice->id]);
    }

    public function test_customer_can_view_own_invoice(): void
    {
        $customer = $this->makeCustomer();
        $invoice  = Invoice::factory()->create(['user_id' => $customer->id]);

        $this->actingAs($customer)->getJson("/api/invoices/{$invoice->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $invoice->id]);
    }

    public function test_customer_cannot_view_another_users_invoice(): void
    {
        $customer1 = $this->makeCustomer();
        $customer2 = $this->makeCustomer();
        $invoice   = Invoice::factory()->create(['user_id' => $customer2->id]);

        $this->actingAs($customer1)->getJson("/api/invoices/{$invoice->id}")
            ->assertStatus(403);
    }

    public function test_show_returns_404_for_nonexistent_invoice(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)->getJson('/api/invoices/99999')
            ->assertStatus(404);
    }

    // -------------------------------------------------------------------------
    // Store
    // -------------------------------------------------------------------------

    public function test_admin_can_create_invoice_from_order(): void
    {
        $admin    = $this->makeAdmin();
        $customer = $this->makeCustomer();

        $order = Order::factory()->create(['user_id' => $customer->id]);
        OrderItem::factory()->count(2)->create(['order_id' => $order->id]);

        $response = $this->actingAs($admin)->postJson('/api/invoices', [
            'order_id' => $order->id,
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'invoice_number', 'status', 'items'])
            ->assertJsonPath('order_id', $order->id)
            ->assertJsonPath('user_id', $customer->id)
            ->assertJsonCount(2, 'items');

        $this->assertDatabaseHas('invoices', ['order_id' => $order->id]);
        $this->assertDatabaseCount('invoice_items', 2);
    }

    public function test_store_validates_required_order_id(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)->postJson('/api/invoices', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['order_id']);
    }

    public function test_store_returns_422_for_nonexistent_order(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)->postJson('/api/invoices', ['order_id' => 99999])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['order_id']);
    }

    // -------------------------------------------------------------------------
    // Update
    // -------------------------------------------------------------------------

    public function test_status_change_to_issued_sets_issued_at(): void
    {
        $admin   = $this->makeAdmin();
        $invoice = Invoice::factory()->create(['status' => InvoiceStatus::DRAFT]);

        $response = $this->actingAs($admin)->putJson("/api/invoices/{$invoice->id}", [
            'status' => 'issued',
        ]);

        $response->assertStatus(200);

        $this->assertNotNull($invoice->fresh()->issued_at);
        $this->assertNull($invoice->fresh()->paid_at);
    }

    public function test_status_change_to_paid_sets_paid_at(): void
    {
        $admin   = $this->makeAdmin();
        $invoice = Invoice::factory()->create(['status' => InvoiceStatus::DRAFT]);

        $response = $this->actingAs($admin)->putJson("/api/invoices/{$invoice->id}", [
            'status' => 'paid',
        ]);

        $response->assertStatus(200);

        $this->assertNotNull($invoice->fresh()->paid_at);
    }

    public function test_update_syncs_invoice_items(): void
    {
        $admin   = $this->makeAdmin();
        $invoice = Invoice::factory()->create();
        $item    = InvoiceItem::factory()->create(['invoice_id' => $invoice->id]);

        // Replace item — send new item only, existing one should be deleted
        $response = $this->actingAs($admin)->putJson("/api/invoices/{$invoice->id}", [
            'items' => [
                [
                    'type'        => 'product',
                    'description' => 'New widget',
                    'quantity'    => 3,
                    'unit_price'  => 25.00,
                    'total'       => 75.00,
                ],
            ],
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('invoice_items', ['id' => $item->id]);
        $this->assertDatabaseHas('invoice_items', ['description' => 'New widget']);
    }

    public function test_update_returns_404_for_nonexistent_invoice(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)->putJson('/api/invoices/99999', ['status' => 'issued'])
            ->assertStatus(404);
    }

    // -------------------------------------------------------------------------
    // Destroy
    // -------------------------------------------------------------------------

    public function test_admin_can_delete_invoice(): void
    {
        $admin   = $this->makeAdmin();
        $invoice = Invoice::factory()->create();

        $this->actingAs($admin)->deleteJson("/api/invoices/{$invoice->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Invoice deleted']);

        $this->assertDatabaseMissing('invoices', ['id' => $invoice->id]);
    }

    public function test_delete_also_removes_invoice_items(): void
    {
        $admin   = $this->makeAdmin();
        $invoice = Invoice::factory()->create();
        InvoiceItem::factory()->count(2)->create(['invoice_id' => $invoice->id]);

        $this->actingAs($admin)->deleteJson("/api/invoices/{$invoice->id}")
            ->assertStatus(200);

        $this->assertDatabaseCount('invoice_items', 0);
    }

    public function test_delete_returns_404_for_nonexistent_invoice(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)->deleteJson('/api/invoices/99999')
            ->assertStatus(404);
    }
}
