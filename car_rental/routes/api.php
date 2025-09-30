<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarApiController;
use App\Http\Controllers\Api\BookingApiController;

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

// Public API routes (no authentication required)
Route::prefix('v1')->group(function () {
    
    // Car related endpoints
    Route::prefix('cars')->group(function () {
        Route::get('/', [CarApiController::class, 'index']);
        Route::get('/featured', [CarApiController::class, 'featured']);
        Route::get('/makes', [CarApiController::class, 'makes']);
        Route::get('/statistics', [CarApiController::class, 'statistics']);
        Route::get('/{car}', [CarApiController::class, 'show']);
        Route::post('/{car}/availability', [CarApiController::class, 'availability']);
    });

    // Authentication endpoints (if you implement API authentication)
    // Route::post('/auth/login', [AuthApiController::class, 'login']);
    // Route::post('/auth/register', [AuthApiController::class, 'register']);
    // Route::post('/auth/forgot-password', [AuthApiController::class, 'forgotPassword']);
});

// Protected API routes (authentication required)
Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    
    // User endpoints
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    });

    // Booking endpoints
    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingApiController::class, 'index']);
        Route::post('/', [BookingApiController::class, 'store']);
        Route::get('/statistics', [BookingApiController::class, 'statistics']);
        Route::get('/upcoming', [BookingApiController::class, 'upcoming']);
        Route::get('/{booking}', [BookingApiController::class, 'show']);
        Route::put('/{booking}', [BookingApiController::class, 'update']);
        Route::post('/{booking}/cancel', [BookingApiController::class, 'cancel']);
    });

    // Authentication endpoints
    // Route::post('/auth/logout', [AuthApiController::class, 'logout']);
    // Route::post('/auth/refresh', [AuthApiController::class, 'refresh']);
    // Route::put('/auth/change-password', [AuthApiController::class, 'changePassword']);
});

// Rate limited API routes
Route::prefix('v1')->middleware(['throttle:api'])->group(function () {
    
    // Contact/Support endpoints (if implemented)
    // Route::post('/contact', [ContactApiController::class, 'store']);
    
    // Newsletter subscription (if implemented)
    // Route::post('/newsletter/subscribe', [NewsletterApiController::class, 'subscribe']);
    
    // File upload endpoints (if implemented)
    // Route::post('/upload/image', [UploadApiController::class, 'uploadImage']);
});

// Admin API routes (admin authentication required)
Route::prefix('v1/admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    
    // Car management endpoints
    Route::prefix('cars')->group(function () {
        Route::post('/', [CarApiController::class, 'store']);
        Route::put('/{car}', [CarApiController::class, 'update']);
        Route::delete('/{car}', [CarApiController::class, 'destroy']);
        Route::post('/{car}/toggle-availability', [CarApiController::class, 'toggleAvailability']);
        Route::get('/analytics', [CarApiController::class, 'analytics']);
    });

    // Booking management endpoints
    Route::prefix('bookings')->group(function () {
        Route::get('/all', [BookingApiController::class, 'index']);
        Route::put('/{booking}/status', [BookingApiController::class, 'updateStatus']);
        Route::get('/export', [BookingApiController::class, 'export']);
        Route::get('/analytics', [BookingApiController::class, 'analytics']);
    });

    // User management endpoints (if implemented)
    // Route::prefix('users')->group(function () {
    //     Route::get('/', [UserApiController::class, 'index']);
    //     Route::get('/{user}', [UserApiController::class, 'show']);
    //     Route::put('/{user}', [UserApiController::class, 'update']);
    //     Route::delete('/{user}', [UserApiController::class, 'destroy']);
    // });

    // System management endpoints (if implemented)
    // Route::get('/dashboard/statistics', [DashboardApiController::class, 'statistics']);
    // Route::get('/system/health', [SystemApiController::class, 'health']);
    // Route::get('/logs', [LogApiController::class, 'index']);
});

// Webhook endpoints (if you implement payment webhooks)
Route::prefix('webhooks')->group(function () {
    // Route::post('/stripe', [WebhookController::class, 'stripe']);
    // Route::post('/paypal', [WebhookController::class, 'paypal']);
});

// API Documentation endpoints (if you implement API docs)
Route::get('/docs', function () {
    return response()->json([
        'success' => true,
        'message' => 'Car Rental API Documentation',
        'version' => 'v1.0.0',
        'endpoints' => [
            'cars' => [
                'GET /api/v1/cars' => 'Get list of cars with filtering and search',
                'GET /api/v1/cars/{id}' => 'Get car details',
                'GET /api/v1/cars/featured' => 'Get featured cars',
                'GET /api/v1/cars/makes' => 'Get available car makes and models',
                'GET /api/v1/cars/statistics' => 'Get car statistics',
                'POST /api/v1/cars/{id}/availability' => 'Check car availability',
            ],
            'bookings' => [
                'GET /api/v1/bookings' => 'Get user bookings (authenticated)',
                'POST /api/v1/bookings' => 'Create new booking (authenticated)',
                'GET /api/v1/bookings/{id}' => 'Get booking details (authenticated)',
                'PUT /api/v1/bookings/{id}' => 'Update booking (authenticated)',
                'POST /api/v1/bookings/{id}/cancel' => 'Cancel booking (authenticated)',
                'GET /api/v1/bookings/statistics' => 'Get booking statistics (authenticated)',
                'GET /api/v1/bookings/upcoming' => 'Get upcoming bookings (authenticated)',
            ],
        ],
        'authentication' => [
            'type' => 'Laravel Sanctum',
            'header' => 'Authorization: Bearer {token}',
            'note' => 'Some endpoints require authentication while others are public',
        ],
        'response_format' => [
            'success' => [
                'success' => true,
                'message' => 'Success message',
                'data' => 'Response data'
            ],
            'error' => [
                'success' => false,
                'message' => 'Error message',
                'error' => 'Detailed error (only in debug mode)'
            ]
        ],
        'pagination' => [
            'per_page' => 'Number of items per page (default: 15, max: 50)',
            'page' => 'Page number (default: 1)',
            'sort_by' => 'Field to sort by',
            'sort_order' => 'Sort order (asc/desc)'
        ],
        'rate_limiting' => [
            'general' => '60 requests per minute',
            'throttled_endpoints' => '10 requests per minute',
        ]
    ]);
});

// Fallback route for API
Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'API endpoint not found',
        'documentation' => url('/api/docs')
    ], 404);
});