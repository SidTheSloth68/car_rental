<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/search', [HomeController::class, 'search'])->name('home.search');

// Car routes
Route::resource('cars', CarController::class);
Route::get('/cars-list', [CarController::class, 'list'])->name('cars.list');

// Additional car routes
Route::get('/cars/type/{type}', [CarController::class, 'getByType'])->name('cars.by-type');
Route::get('/cars/search/autocomplete', [CarController::class, 'search'])->name('cars.autocomplete');
Route::patch('/cars/{car}/toggle-availability', [CarController::class, 'toggleAvailability'])->name('cars.toggle-availability');
Route::patch('/cars/{car}/toggle-featured', [CarController::class, 'toggleFeatured'])->name('cars.toggle-featured');

// Legacy car search route (can be updated later)
Route::post('/cars/search', [HomeController::class, 'searchCars'])->name('cars.search');
