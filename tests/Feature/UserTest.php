<?php

namespace Tests\Feature;

use App\Mail\AccountDeleted;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        $user = User::factory()->create();
        $user->setRole('admin');
        return $user;
    }

    // -------------------------------------------------------------------------
    // Destroy
    // -------------------------------------------------------------------------

    public function test_admin_can_delete_any_user(): void
    {
        Mail::fake();

        $admin  = $this->makeAdmin();
        $target = User::factory()->create();

        $this->actingAs($admin)->deleteJson("/api/users/{$target->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'User deleted successfully']);

        $this->assertDatabaseMissing('users', ['id' => $target->id]);
    }

    public function test_admin_delete_queues_account_deleted_mail(): void
    {
        Mail::fake();

        $admin  = $this->makeAdmin();
        $target = User::factory()->create(['email' => 'target@example.com']);

        $this->actingAs($admin)->deleteJson("/api/users/{$target->id}");

        Mail::assertQueued(AccountDeleted::class, function ($mail) {
            return $mail->hasTo('target@example.com');
        });
    }

    public function test_user_can_delete_own_account(): void
    {
        Mail::fake();

        $user = User::factory()->create();

        $this->actingAs($user)->deleteJson("/api/users/{$user->id}")
            ->assertStatus(200);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_user_cannot_delete_another_user(): void
    {
        Mail::fake();

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user1)->deleteJson("/api/users/{$user2->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('users', ['id' => $user2->id]);
    }

    public function test_delete_returns_404_for_nonexistent_user(): void
    {
        $admin = $this->makeAdmin();

        $this->actingAs($admin)->deleteJson('/api/users/99999')
            ->assertStatus(404);
    }

    public function test_unauthenticated_cannot_delete_user(): void
    {
        $user = User::factory()->create();

        $this->deleteJson("/api/users/{$user->id}")
            ->assertStatus(401);
    }

    // -------------------------------------------------------------------------
    // Show
    // -------------------------------------------------------------------------

    public function test_show_returns_user_data(): void
    {
        $user = User::factory()->create(['email' => 'jussi@example.com']);

        $this->getJson("/api/users/{$user->id}")
            ->assertStatus(200)
            ->assertJsonFragment(['email' => 'jussi@example.com']);
    }

    public function test_show_returns_404_for_nonexistent_user(): void
    {
        $this->getJson('/api/users/99999')
            ->assertStatus(404);
    }

    // -------------------------------------------------------------------------
    // Index
    // -------------------------------------------------------------------------

    public function test_index_returns_list_of_users(): void
    {
        User::factory()->count(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200);
        $this->assertGreaterThanOrEqual(3, count($response->json()));
    }
}
