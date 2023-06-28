<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TravelResource;
use App\Models\Travel;

/**
 * @group Public endpoint
 */
class TravelController extends Controller
{
    /**
     * Travel list
     * 
     * Returns paginated list of travels
     *
     * @return void
     * 
     * @response{
     * "data": [
     *  {
     *     "id": "99829c82-4784-4fd9-9899-b531f86e1e2f",
     *     "name": "travel one",
     *    "slug": "travel-one",
     *    "description": "this is information about the Travel one",
     *    "number_of_days": 9,
     *    "number_of_nights": 8
     * },]}
     * 
     */
    public function index()
    {
        $travels = Travel::where('is_public', true)->paginate();

        return TravelResource::collection($travels);
    }
}
