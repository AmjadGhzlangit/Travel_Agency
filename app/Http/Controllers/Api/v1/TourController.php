<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TourRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Models\Travel;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function index(Travel $travel, TourRequest $request)
    {
        $tours = $travel->tours()
                ->when($request->priceFrom,function($query) use ($request){
                    $query->where('price','>=',$request->priceFrom);
                })
                ->when($request->priceTo,function($query) use ($request){
                    $query->where('price','<=',$request->priceTo);
                })
                ->when($request->dateFrom,function($query) use ($request){
                    $query->where('starting_date','>=',$request->dateFrom);
                })
                ->when($request->dateTo,function($query) use ($request){
                    $query->where('starting_date','<=',$request->dateTo);
                })
                ->when($request->sortBy && $request->orderBy ,function($query) use ($request){
                    $query->orderBy($request->sortBy , $request->orderBy);
                })
               
            ->orderBy('starting_date')->paginate();

        return TourResource::collection($tours);
    }
}
