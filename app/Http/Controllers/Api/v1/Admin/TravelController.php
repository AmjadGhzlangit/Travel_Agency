<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TravelRequest;
use App\Http\Resources\TravelResource;
use App\Models\Travel;

/**
 * @group Admin endpoint
 */
class TravelController extends Controller
{

    /**
      * Post Tour
     * 
     * Create a new Tour record
     * 
     * @authenticated
     * @param TravelRequest $request
     * 
     */
    public function store(TravelRequest $request)
    {
        $travel = Travel::create($request->validated());

        return new TravelResource($travel);
    }

     /**
      * PUT Tour
     * 
     * Update the Tour record
     * 
     * @authenticated
     * @param TravelRequest $request
     * 
     */
    public function update(Travel $travel, TravelRequest $request)
    {
        $travel->update($request->validated());

        return new TravelResource($travel);
    }
}
