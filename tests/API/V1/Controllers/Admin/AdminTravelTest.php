<?php

namespace Tests\API\V1\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\API\V1\V1TestCase;

class AdminTravelTest extends V1TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function public_user_cannot_access_adding_travels(): void
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(
            'admin/travels',
            [
                'is_public' => '1',
                'name' => 'travel one',
                'description' => 'travel one description',
                'number_of_days' => 5,
            ]
        );

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function non_admin_user_cannot_access_adding_travels(): void
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
            'admin/travels'
        );

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function insert_tavel_with_invalid_data_returns_error_validation(): void
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
            'admin/travels'
        );

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function insert_tavel_with_valid_data_successful(): void
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
            'admin/travels',
            [
                'is_public' => '1',
                'name' => 'travel one',
                'description' => 'travel one description',
                'number_of_days' => 5,
            ]
        );

        $response->assertStatus(200);

        $response = $this->get('travels');
        $response->assertJsonFragment(['name' => 'travel one']);
    }
}
