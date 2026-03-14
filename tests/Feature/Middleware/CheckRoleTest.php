<?php

namespace Tests\Feature\Middleware;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckRoleTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        $user = User::factory()->create();
        $user->setRole('admin');

        return $user;
    }

    private function makeVendor(): User
    {
        $user = User::factory()->create();
        $user->setRole('vendor');

        return $user;
    }

    private function makeCustomer(): User
    {
        return User::factory()->create(); // UserFactory assigns customer by default
    }

    public function test_admin_can_access_admin_only_route(): void
    {
        $admin = $this->makeAdmin();

        // POST /api/invoices requires role:admin,vendor
        $response = $this->actingAs($admin)->postJson('/api/invoices', [
            'order_id' => 9999,
        ]);

        // 422 (validation) means middleware let the request through
        $response->assertStatus(422);
    }

    public function test_vendor_can_access_admin_vendor_route(): void
    {
        $vendor = $this->makeVendor();

        $response = $this->actingAs($vendor)->postJson('/api/invoices', [
            'order_id' => 9999,
        ]);

        $response->assertStatus(422);
    }

    public function test_customer_is_forbidden_on_admin_vendor_route(): void
    {
        $customer = $this->makeCustomer();

        $response = $this->actingAs($customer)->postJson('/api/invoices', [
            'order_id' => 9999,
        ]);

        $response->assertStatus(403);
    }

    public function test_unauthenticated_user_gets_401_on_auth_route(): void
    {
        $response = $this->postJson('/api/invoices', [
            'order_id' => 9999,
        ]);

        $response->assertStatus(401);
    }

    public function test_customer_can_access_auth_only_route_without_role_restriction(): void
    {
        $customer = $this->makeCustomer();

        // GET /api/invoices requires auth:sanctum but no role restriction
        $response = $this->actingAs($customer)->getJson('/api/invoices');

        $response->assertStatus(200);
    }

    public function test_admin_can_delete_invoice(): void
    {
        $admin   = $this->makeAdmin();
        $invoice = Invoice::factory()->create();

        $response = $this->actingAs($admin)->deleteJson("/api/invoices/{$invoice->id}");

        $response->assertStatus(200);
    }

    public function test_customer_cannot_delete_invoice(): void
    {
        $customer = $this->makeCustomer();
        $invoice  = Invoice::factory()->create();

        $response = $this->actingAs($customer)->deleteJson("/api/invoices/{$invoice->id}");

        $response->assertStatus(403);
    }
}
