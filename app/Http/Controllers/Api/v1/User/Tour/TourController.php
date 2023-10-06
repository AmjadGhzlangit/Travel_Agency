<?php

namespace App\Http\Controllers\Api\v1\User\Tour;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Http\Resources\TourResource;
use App\Models\Travel;

/**
 * @group Public endpoint
 */
class TourController extends Controller
{
    /**
     * GET Travel Tours
     *
     * Returns paginated list of tour by travel slug
     * Ordering by starting_data
     *
     *
     *@response{
     *   "data": [
     *  {"id": "99830a0a-016b-4c03-94f1-e99390a37bac","name": "amjad","starting_date": "2023-06-01","ending_date": "2023-06-25","price": "200.00"},
     *
     * {"id": "99830f31-8496-457c-9ec5-0f78717cad92","name": "amjad tour","starting_date": "2023-06-20","ending_date": "2023-06-25","price": "300.00"}
     * ],
     *   }
     */
    public function index(Travel $travel, TourRequest $request)
    {
        $tours = $travel->tours()
            ->when($request->priceFrom, function ($query) use ($request) {
                $query->where('price', '>=', $request->priceFrom);
            })
            ->when($request->priceTo, function ($query) use ($request) {
                $query->where('price', '<=', $request->priceTo);
            })
            ->when($request->dateFrom, function ($query) use ($request) {
                $query->where('starting_date', '>=', $request->dateFrom);
            })
            ->when($request->dateTo, function ($query) use ($request) {
                $query->where('starting_date', '<=', $request->dateTo);
            })
            ->when($request->sortBy && $request->orderBy, function ($query) use ($request) {
                $query->orderBy($request->sortBy, $request->orderBy);
            })

            ->orderBy('starting_date')->paginate();

        return TourResource::collection($tours);
    }
}
