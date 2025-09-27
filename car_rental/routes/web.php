<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/search', [HomeController::class, 'search'])->name('home.search');

// Car search route (placeholder for future implementation)
Route::post('/cars/search', [HomeController::class, 'searchCars'])->name('cars.search');
