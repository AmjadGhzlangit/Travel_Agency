<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreToursRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function store(Travel $travel , StoreToursRequest $request)
    {
        $tour = $travel->tours()->create($request->validated());

        return new TourResource($tour);


    }
}