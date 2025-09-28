<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

// Home route - display homepage with car search
Route::get('/', [HomeController::class, 'index'])->name('home');

// Car routes - accessible to all users
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::post('/cars/search', [CarController::class, 'search'])->name('cars.search');
Route::get('/cars/{id}', [CarController::class, 'show'])->name('cars.show');
Route::get('/cars-list', [CarController::class, 'list'])->name('cars.list');

// Booking routes - accessible to all users but require auth to submit
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::get('/quick-booking', [BookingController::class, 'quickBooking'])->name('booking.quick');

// About and Contact pages
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// News/Blog routes
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/search', [NewsController::class, 'search'])->name('news.search');
Route::get('/news/category/{category}', [NewsController::class, 'category'])->name('news.category');

// Different news layout views
Route::get('/news/grid/right-sidebar', [NewsController::class, 'gridRightSidebar'])->name('news.grid.right');
Route::get('/news/grid/left-sidebar', [NewsController::class, 'gridLeftSidebar'])->name('news.grid.left');
Route::get('/news/grid/no-sidebar', [NewsController::class, 'gridNoSidebar'])->name('news.grid.none');
Route::get('/news/standard/right-sidebar', [NewsController::class, 'standardRightSidebar'])->name('news.standard.right');
Route::get('/news/standard/left-sidebar', [NewsController::class, 'standardLeftSidebar'])->name('news.standard.left');
Route::get('/news/standard/no-sidebar', [NewsController::class, 'standardNoSidebar'])->name('news.standard.none');

Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

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
    
    // Booking routes
    Route::resource('bookings', BookingController::class);
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/booking-summary', [BookingController::class, 'getSummary'])->name('bookings.summary');
    
    // Admin News management routes
    Route::resource('admin/news', NewsController::class)->except(['index', 'show'])->names([
        'create' => 'admin.news.create',
        'store' => 'admin.news.store',
        'edit' => 'admin.news.edit',
        'update' => 'admin.news.update',
        'destroy' => 'admin.news.destroy'
    ]);
});

// Include authentication routes
require __DIR__.'/auth.php';
