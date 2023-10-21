<?php

namespace Tests\API\V1\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\API\V1\V1TestCase;

class LogoutTest extends V1TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function logout_without_authentication_fails(): void
    {
        $response = $this->getJson('auth/logout');

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

    }

    /**
     * @test
     */
    public function logout_user_success(): void
    {
        $user = User::factory()->create();
        $token = $user->createAuthToken();
        Sanctum::actingAs($user);
        $response = $this->getJson('auth/logout');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Successfully logged out']);

    }

    /**
     * @test
     */
    public function login_returns_error_with_invalid_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('auth/login', [
            'email' => 'nonexisting@user.com',
            'password' => 'password',
        ]
        );

        $response->assertStatus(422);
    }
}
