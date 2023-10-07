<?php

namespace Tests\API\V1\Controllers\Admin;

use App\Models\Role;
use App\Models\Travel;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\API\V1\V1TestCase;

class AdminTourTest extends V1TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function public_users_cannot_access_adding_tour(): void
    {
        $user = User::factory()->create();
        $travel = Travel::factory()->create();

        $response = $this->actingAs($user)->postJson('admin/travels/'.$travel->id.'/tours');

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function non_admin_users_cannot_access_adding_tour(): void
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('name', 'editor')->first()->id);
        $travel = Travel::factory()->create();

        $response = $this->actingAs($user)->postJson('admin/travels/'.$travel->id.'/tours');

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function saves_tour_successfully_with_valid_data(): void
    {
        $this->seed(RoleSeeder::class);
        $admin = User::factory()->create();
        $admin->roles()->attach(Role::where('name', 'admin')->first()->id);
        $travel = Travel::factory()->create();

        $response = $this->actingAs($admin)->postJson('admin/travels/'.$travel->id.'/tours', [
            'name' => 'tour one',
            'starting_date' => now(),
            'ending_date' => now()->addDays(2),
            'price' => 150,
            'travel_id' => $travel->id,
        ]);

        $response->assertStatus(200);

        $response = $this->get('travels/'.$travel->slug.'/tours');
        $response->assertJsonFragment(['name' => 'tour one']);
    }

    /**
     * @test
     */
    public function saves_tour_felid_with_invalid_data_and_returns_error(): void
    {
        $this->seed(RoleSeeder::class);
        $admin = User::factory()->create();
        $admin->roles()->attach(Role::where('name', 'admin')->first()->id);
        $travel = Travel::factory()->create();

        $response = $this->actingAs($admin)->postJson('admin/travels/'.$travel->id.'/tours', [
            'name' => 'tour one',
            'starting_date' => now()->addDays(2),
            'ending_date' => now(),
            'price' => 150,
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment(['message' => 'The ending date field must be a date after starting date.']);
    }

    /**
     * @test
     */
    public function editor_update_travel_successfully_with_valid_data(): void
    {
        $this->seed(RoleSeeder::class);
        $editor = User::factory()->create();
        $editor->roles()->attach(Role::where('name', 'editor')->first()->id);
        $travel = Travel::factory()->create([
            'is_public' => 1,
            'name' => 'travel one',
            'description' => 'this is best travel ',
            'number_of_days' => 5,

        ]);

        $response = $this->actingAs($editor)->putJson('editor/travels/'.$travel->id, [
            'is_public' => 1,
            'name' => 'travel one updated',
            'description' => 'this is best travel updated',
            'number_of_days' => 10,

        ]);

        $response->assertStatus(200);

        $response = $this->get('travels/');
        $response->assertJsonFragment([
            'name' => 'travel one updated',
            'description' => 'this is best travel updated',
        ]);
    }

    /**
     * @test
     */
    public function editor_update_travel_felid_with_invalid_data_and_returns_error(): void
    {
        $this->seed(RoleSeeder::class);
        $editor = User::factory()->create();
        $editor->roles()->attach(Role::where('name', 'editor')->first()->id);
        $travel = Travel::factory()->create([
            'is_public' => 1,
            'name' => 'travel one',
            'description' => 'this is best travel ',
            'number_of_days' => 5,

        ]);

        $response = $this->actingAs($editor)->putJson('editor/travels/'.$travel->id, [
            'is_public' => 1,
            'name' => 'travel one',
            'description' => 'this is best travel updated',
            'number_of_days' => 10,

        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'The name has already been taken.',
        ]);

    }
}
