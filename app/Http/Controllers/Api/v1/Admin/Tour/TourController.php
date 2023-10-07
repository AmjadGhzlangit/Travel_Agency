<?php

namespace App\Http\Controllers\Api\v1\Admin\Tour;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Tour\TourRepository;
use App\Http\Requests\StoreToursRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;

/**
 * @group Admin endpoint
 */
class TourController extends Controller
{
    public function __construct(protected TourRepository $tourRepository)
    {
        $this->middleware(['auth:sanctum']);
    }

    /**
     * Post Travel
     *
     * Create a new Travel record
     *
     *
     * @authenticated
     *
     * @return void
     */
    public function store(Travel $travel, StoreToursRequest $request)
    {




        
        $tour_data = $request->validated();
        $tour_data['travel_id'] = $travel->id;
        $tour = $this->tourRepository->store($tour_data);
        // $travel->tours()->attach($tour->id);

        return $this->showOne($tour, TourResource::class, __('The tour added successfully'));
    }
}
