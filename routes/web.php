<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommitteeController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {


    

    Route::get('/admin', [DashboardController::class, 'index'])
    ->name('dashboard');

    Route::resource('admin/events', EventController::class);
    Route::resource('admin/committees', CommitteeController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';