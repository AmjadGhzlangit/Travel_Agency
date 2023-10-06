<?php

namespace Tests\API\V1\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\API\V1\V1TestCase;

class LoginTest extends V1TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function login_returns_token_with_valid_credentials(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]
        );

        $response->assertStatus(200);
        $this->saveResponseToFile($response, 'auth/login.json');
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
