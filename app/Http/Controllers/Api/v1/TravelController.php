<?php


namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Http\Resources\TravelRrasource;
use App\Models\Travel;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    public function index()
    {
        $travels = Travel::where('is_public' , true)->paginate();

        return TravelRrasource::collection($travels);
    }
}
