<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreToursRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;

/**
 * @group Admin endpoint
 */
class TourController extends Controller
{
    /**
     * Post Travel
     * 
     * Create a new Travel record
     * 
     * 
     * @authenticated
     *
     * @param Travel $travel
     * @param StoreToursRequest $request
     * @return void
     */
    public function store(Travel $travel, StoreToursRequest $request)
    {
        $tour = $travel->tours()->create($request->validated());

        return new TourResource($tour);
    }
}
