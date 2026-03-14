<?php

namespace Tests\Feature\Auth;

use App\Mail\RegistrationWelcome;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'first_name' => 'Jussi',
            'last_name'  => 'Palanen',
            'username'   => 'jussipalanen',
            'email'      => 'jussi@example.com',
            'password'   => 'strongpassword',
        ], $overrides);
    }

    public function test_successful_registration_returns_token_and_user(): void
    {
        Mail::fake();

        $response = $this->postJson('/api/register', $this->validPayload());

        $response->assertStatus(201)
            ->assertJsonStructure(['token', 'user' => ['id', 'email', 'roles']]);

        $this->assertDatabaseHas('users', ['email' => 'jussi@example.com']);
    }

    public function test_registered_user_is_assigned_customer_role(): void
    {
        Mail::fake();

        $response = $this->postJson('/api/register', $this->validPayload());

        $user = User::where('email', 'jussi@example.com')->first();

        $this->assertTrue($user->hasRole('customer'));
        $this->assertContains('customer', $response->json('user.roles'));
    }

    public function test_registration_sends_welcome_email(): void
    {
        Mail::fake();

        $this->postJson('/api/register', $this->validPayload());

        Mail::assertSent(RegistrationWelcome::class, function ($mail) {
            return $mail->hasTo('jussi@example.com');
        });
    }

    public function test_duplicate_email_returns_422(): void
    {
        Mail::fake();
        User::factory()->create(['email' => 'jussi@example.com']);

        $response = $this->postJson('/api/register', $this->validPayload());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_duplicate_username_returns_422(): void
    {
        Mail::fake();
        User::factory()->create(['username' => 'jussipalanen']);

        $response = $this->postJson('/api/register', $this->validPayload());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['username']);
    }

    public function test_missing_required_fields_return_422(): void
    {
        $response = $this->postJson('/api/register', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['first_name', 'last_name', 'username', 'email', 'password']);
    }

    public function test_short_password_returns_422(): void
    {
        $response = $this->postJson('/api/register', $this->validPayload(['password' => 'short']));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function test_invalid_email_format_returns_422(): void
    {
        $response = $this->postJson('/api/register', $this->validPayload(['email' => 'not-an-email']));

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
