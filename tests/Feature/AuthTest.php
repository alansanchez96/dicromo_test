<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Modules\Auth\Infrastructure\Database\AuthDB;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_register(): void
    {
        $this->withoutExceptionHandling();

        $payload = [
            'name' => 'user',
            'email' => "exam@exam.com",
            'password' => '123123'
        ];

        $response = $this->post('/api/auth/register', $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => $payload['email']
        ]);

        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);

    }

    #[Test]
    public function user_can_login(): void
    {
        $user = AuthDB::factory()->create([
            'password' => Hash::make('123123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => '123123'
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);

        $response->assertJson([
            'token_type' => 'bearer',
            'expires_in' => 3600,
        ]);
    }
}
