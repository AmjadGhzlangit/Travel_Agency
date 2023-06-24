<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TourListTest extends TestCase
{
    use RefreshDatabase;

    public function test_tour_slug_returns_correct_data()
    {
        $travel = Travel::factory()->create();
        $tour = Tour::factory()->create(['travel_id' => $travel->id]);

        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $tour->id]);
    }

    public function test_tour_price_shows_correct_formate_to_api_client()
    {
        $travel = Travel::factory()->create();
        Tour::factory()->create([
            'travel_id' => $travel->id,
            'price' => 123.45
        ]);
        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['price' => '123.45']);
    }


    public function test_tour_list_returns_correct_paginated_data()
    {
        $travel = Travel::factory()->create();
        Tour::factory(16)->create(['travel_id' => $travel->id]);

        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours');

        $response->assertStatus(200);
        $response->assertJsonCount(15, 'data');
        $response->assertJsonPath('meta.last_page', 2);
    }

    public function test_tours_list_sorts_by_starting_date_correctly(): void
    {
        $travel = Travel::factory()->create();
        $laterTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => now()->addDays(2),
            'ending_date' => now()->addDays(3),
        ]);

        $earlierTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'starting_date' => now(),
            'ending_date' => now()->addDays(1),
        ]);

        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonPath('data.0.id', $earlierTour->id);
        $response->assertJsonPath('data.1.id', $laterTour->id);
    }
    public function test_tours_list_sorts_by_price_correctly(): void
    {
        $travel = Travel::factory()->create();
        $expansiveTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price' => 300
        ]);

        $chipLaterTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price' => 200,
            'starting_date' => now()->addDays(2),
            'ending_date' => now()->addDays(1),
        ]);
        $chipEarlierTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price' => 200,
            'starting_date' => now(),
            'ending_date' => now()->addDays(1),
        ]);

        $response = $this->get('/api/v1/travels/' . $travel->slug . '/tours?sortBy=price&orderBy=asc');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
        $response->assertJsonPath('data.0.id', $chipEarlierTour->id);
        $response->assertJsonPath('data.1.id', $chipLaterTour->id);
        $response->assertJsonPath('data.2.id', $expansiveTour->id);
    }
    public function test_tours_list_filters_by_price_correctly(): void
    {
        $travel = Travel::factory()->create();
        $expansiveTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price' => 300
        ]);

        $chipTour = Tour::factory()->create([
            'travel_id' => $travel->id,
            'price' => 200,
            'starting_date' => now()->addDays(2),
            'ending_date' => now()->addDays(1),
        ]);
        $endpoint = '/api/v1/travels/' . $travel->slug . '/tours';

        $response = $this->get($endpoint . '?priceFrom=150');
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['id'=> $chipTour->id]);
        $response->assertJsonFragment(['id'=> $expansiveTour->id]);

        $response = $this->get($endpoint . '?priceFrom=200');
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['id'=> $chipTour->id]);
        $response->assertJsonFragment(['id'=> $expansiveTour->id]);

        $response = $this->get($endpoint . '?priceFrom=250');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $response->assertJsonMissing(['id'=> $chipTour->id]);
        $response->assertJsonFragment(['id'=> $expansiveTour->id]);

        $response = $this->get($endpoint . '?priceFrom=400');
        $response->assertJsonCount(0, 'data');

        $response = $this->get($endpoint . '?priceTo=300');
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['id'=> $chipTour->id]);
        $response->assertJsonFragment(['id'=>  $expansiveTour->id]);

        $response = $this->get($endpoint . '?priceTo=200');
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id'=> $chipTour->id]);
        $response->assertJsonMissing(['id'=> $expansiveTour->id]);

        $response = $this->get($endpoint . '?priceTo=150');
        $response->assertJsonCount(0, 'data');

        $response = $this->get($endpoint . '?priceFrom=100&priceTo=200');
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id'=> $chipTour->id]);
        $response->assertJsonMissing(['id'=> $expansiveTour->id]);
    }
    public function test_tours_list_returns_validation_errors(): void
    {
        $travel = Travel::factory()->create();

        $endpoint = '/api/v1/travels/' . $travel->slug . '/tours';

        $response = $this->getJson($endpoint . '?priceFrom=asc');
        $response->assertStatus(422);

        
        $response = $this->getJson($endpoint . '?dateFrom=asc');
        $response->assertStatus(422);

        $response = $this->getJson($endpoint . '?sortBy=asc');
        $response->assertStatus(422);

        $response = $this->getJson($endpoint . '?orderBy=random');
        $response->assertStatus(422);


    }
}
