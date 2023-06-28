<?php

use App\Http\Controllers\Api\v1\Admin\TourController as AdminTourController;
use App\Http\Controllers\Api\v1\Admin\TravelController as AdminTravelController;
use App\Http\Controllers\Api\v1\Auth\loginController;
use App\Http\Controllers\Api\v1\TourController;
use App\Http\Controllers\Api\v1\TravelController;
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

Route::get('/travels', [TravelController::class, 'index']);
Route::get('/travels/{travel:slug}/tours', [TourController::class, 'index']);

Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('travels', [AdminTravelController::class, 'store']);
    Route::post('travels/{travel}/tours', [AdminTourController::class, 'store']);
    Route::put('travels/{travel}', [AdminTravelController::class, 'update']);

});
Route::prefix('editor')->middleware(['auth:sanctum', 'role:editor'])->group(function () {
    Route::put('travels/{travel}', [AdminTravelController::class, 'update']);
});
Route::post('login', loginController::class);
