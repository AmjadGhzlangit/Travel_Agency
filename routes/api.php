<?php

use App\Http\Controllers\Api\v1\Admin\TravelController as AdminTravelController;
use App\Http\Controllers\Api\v1\Auth\loginController;
use App\Http\Controllers\Api\v1\TravelController;
use App\Http\Controllers\Api\v1\TourController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/travels',[TravelController::class,'index']);
Route::get('/travels/{travel:slug}/tours',[TourController::class,'index']);


Route::prefix('admin')->middleware(['auth:sanctum','role:admin'])->group(function (){
    Route::post('travels',[AdminTravelController::class,'store']);
});

Route::post('login',loginController::class);