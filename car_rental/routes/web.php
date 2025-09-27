<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Home route - display homepage with car search
Route::get('/', [HomeController::class, 'index'])->name('home');

// Car routes - accessible to all users
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::post('/cars/search', [CarController::class, 'search'])->name('cars.search');
Route::get('/cars/{id}', [CarController::class, 'show'])->name('cars.show');
Route::get('/cars-list', [CarController::class, 'list'])->name('cars.list');

// Authenticated user dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated user profile management and dashboard sub-pages
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Dashboard sub-pages
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::get('/dashboard/bookings', [DashboardController::class, 'bookings'])->name('dashboard.bookings');
    Route::get('/dashboard/favorites', [DashboardController::class, 'favorites'])->name('dashboard.favorites');
});

// Include authentication routes
require __DIR__.'/auth.php';
