<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventApiController;
use App\Http\Controllers\Api\CommitteeApiController;

Route::get('/events', [EventApiController::class, 'index']);
Route::get('/events/{event}', [EventApiController::class, 'show']);


Route::prefix('committee')->group(function () {

    // Get all available years
    Route::get('/years', [CommitteeApiController::class, 'years']);

    // Get committee members of a specific year
    Route::get('/years/{year}', [CommitteeApiController::class, 'byYear']);

    // Get a single committee member
    Route::get('/member/{id}', [CommitteeApiController::class, 'show']);

});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
