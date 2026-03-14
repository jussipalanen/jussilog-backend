<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_with_valid_username_returns_token(): void
    {
        $user = User::factory()->create(['username' => 'jussi']);

        $response = $this->postJson('/api/login', [
            'username' => 'jussi',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_login_with_valid_email_returns_token(): void
    {
        $user = User::factory()->create(['email' => 'jussi@example.com']);

        $response = $this->postJson('/api/login', [
            'username' => 'jussi@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_login_with_wrong_password_returns_401(): void
    {
        User::factory()->create(['username' => 'jussi']);

        $response = $this->postJson('/api/login', [
            'username' => 'jussi',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJsonFragment(['message' => 'Invalid credentials']);
    }

    public function test_login_with_nonexistent_user_returns_401(): void
    {
        $response = $this->postJson('/api/login', [
            'username' => 'nobody',
            'password' => 'password',
        ]);

        $response->assertStatus(401);
    }

    public function test_login_without_credentials_returns_422(): void
    {
        $response = $this->postJson('/api/login', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['username', 'password']);
    }
}
