<?php

namespace App\Http\Controllers\Api\v1\Admin\Travel;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Travel\TravelRepository;
use App\Http\Requests\TravelRequest;
use App\Http\Resources\TravelResource;
use App\Models\Travel;

/**
 * @group Admin endpoint
 */
class TravelController extends Controller
{
    public function __construct(protected TravelRepository $travelRepository)
    {
        $this->middleware(['auth:sanctum']);
        // $this->authorizeResource(Travel::class);
    }

    /**
     * Add Travel
     *
     * This endpoint lets the user add travel
     *
     * @authenticated
     *
     * @responseFile storage/responses/admin/travel/store.json
     */
    public function store(TravelRequest $request)
    {
        $travel_data = $request->validated();

        $travel = $this->travelRepository->store($travel_data);

        return $this->showOne($travel, TravelResource::class, __('The Travel added successfully'));
    }

    /**
     * Update specific Travel
     *
     * This endpoint lets you update specific travel
     *
     * @authenticated
     *
     * @responseFile storage/responses/admin/travel/update.json
     */
    public function update(Travel $travel, TravelRequest $request)
    {
        $travel_data = $request->validated();
        $travelUpdate = $this->travelRepository->update($travel, $travel_data);

        return $this->showOne($travelUpdate, TravelResource::class, __('The Travel updated successfully'));
    }
}
