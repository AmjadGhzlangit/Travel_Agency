<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTravelTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_user_cannot_access_adding_travels(): void
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(
            '/api/v1/admin/travels',
            [
                'is_public' => '1',
                'name' => 'travel one',
                'description' => 'travel one description',
                'number_of_days' => 5,
            ]
        );

        $response->assertStatus(403);
    }

    public function test_non_admin_user_cannot_access_adding_travels(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create(
            [
                'name' => 'non_admin',
                'email' => 'NonAdminUser@email.com',
            ]
        );
        $user->roles()->attach(Role::where('name', 'editor')->value(1));

        $response = $this->actingAs($user)->postJson(
            '/api/v1/admin/travels'
        );

        $response->assertStatus(403);
    }

    public function test_insert_tavel_with_invalid_data_returns_error_validation(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create(
            [
                'name' => 'admin',
                'email' => 'Admin@email.com',
            ]
        );
        $user->roles()->attach(Role::where('name', 'admin')->value('id'));

        $response = $this->actingAs($user)->postJson(
            '/api/v1/admin/travels'
        );

        $response->assertStatus(422);
    }

    public function test_insert_tavel_with_valid_data_successful(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create(
            [
                'name' => 'admin',
                'email' => 'Admin@email.com',
            ]
        );
        $user->roles()->attach(Role::where('name', 'admin')->value('id'));

        $response = $this->actingAs($user)->postJson(
            '/api/v1/admin/travels',
            [
                'is_public' => '1',
                'name' => 'travel one',
                'description' => 'travel one description',
                'number_of_days' => 5,
            ]
        );

        $response->assertStatus(201);

        $response = $this->get('api/v1/travels');
        $response->assertJsonFragment(['name' => 'travel one']);
    }
}
