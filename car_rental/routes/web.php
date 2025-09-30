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
Route::get('/news/grid/right-sidebar', [NewsController::class, 'gridRightSidebar'])->name('news.grid-right-sidebar');
Route::get('/news/grid/left-sidebar', [NewsController::class, 'gridLeftSidebar'])->name('news.grid-left-sidebar');
Route::get('/news/grid/no-sidebar', [NewsController::class, 'gridNoSidebar'])->name('news.grid-no-sidebar');
Route::get('/news/standard/right-sidebar', [NewsController::class, 'standardRightSidebar'])->name('news.standard-right-sidebar');
Route::get('/news/standard/left-sidebar', [NewsController::class, 'standardLeftSidebar'])->name('news.standard-left-sidebar');
Route::get('/news/standard/no-sidebar', [NewsController::class, 'standardNoSidebar'])->name('news.standard-no-sidebar');

Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// Newsletter subscription (placeholder route)
Route::post('/newsletter/subscribe', function () {
    return response()->json(['success' => true, 'message' => 'Subscribed successfully!']);
})->name('newsletter.subscribe');

// Dark theme demo route
Route::get('/dark-theme-demo', function () {
    return view('dark-theme-demo');
})->name('dark-theme-demo');

// UI Components demo route
Route::get('/ui-components', function () {
    return view('ui-components-demo');
})->name('ui-components-demo');

// Icon Components demo route
Route::get('/icon-components', function () {
    return view('icon-components-demo');
})->name('icon-components-demo');

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

// Admin routes - require authentication and admin role
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index']); // Redirect /admin to dashboard
    
    // User Management
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    
    // Car Management
    Route::resource('cars', \App\Http\Controllers\Admin\CarController::class);
    Route::patch('/cars/{car}/toggle-availability', [\App\Http\Controllers\Admin\CarController::class, 'toggleAvailability'])->name('cars.toggle-availability');
    
    // Booking Management
    Route::get('/bookings', [\App\Http\Controllers\Admin\AdminController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{booking}', [\App\Http\Controllers\Admin\AdminController::class, 'showBooking'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [\App\Http\Controllers\Admin\AdminController::class, 'updateBookingStatus'])->name('bookings.update-status');
    
    // News Management
    Route::get('/news', [\App\Http\Controllers\Admin\AdminController::class, 'news'])->name('news');
    Route::get('/news/{news}', [\App\Http\Controllers\Admin\AdminController::class, 'showNews'])->name('news.show');
    Route::patch('/news/{news}/status', [\App\Http\Controllers\Admin\AdminController::class, 'updateNewsStatus'])->name('news.update-status');
    
    // Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\AdminController::class, 'settings'])->name('settings');
});

// Include authentication routes
require __DIR__.'/auth.php';
