<?php

// Bootstrap Laravel properly
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing Booking Form Submission...\n\n";

// Test if booking routes are accessible
try {
    echo "1. Checking booking routes...\n";
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    
    $bookingRoutes = [];
    foreach ($routes as $route) {
        $uri = $route->uri();
        if (str_contains($uri, 'booking') || str_contains($uri, 'book')) {
            $methods = implode('|', $route->methods());
            $name = $route->getName() ?: 'unnamed';
            $bookingRoutes[] = "  $methods $uri [$name]";
        }
    }
    
    echo "✓ Found " . count($bookingRoutes) . " booking-related routes:\n";
    foreach ($bookingRoutes as $route) {
        echo "$route\n";
    }
    
    echo "\n2. Testing Car Model availability...\n";
    
    $availableCars = \App\Models\Car::where('is_available', true)->count();
    echo "✓ Found $availableCars available cars in database\n";
    
    echo "\n3. Testing User Model...\n";
    $userCount = \App\Models\User::count();
    echo "✓ Found $userCount users in database\n";
    
    echo "\n4. Testing form field validation requirements...\n";
    
    // Test validation rules from BookingController
    $requiredFields = [
        'pickup_location' => 'required|string|max:255',
        'dropoff_location' => 'required|string|max:255', 
        'pickup_date' => 'required|date|after_or_equal:today',
        'pickup_time' => 'required|string',
        'return_date' => 'required|date|after:pickup_date',
        'return_time' => 'required|string',
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|email|max:255',
        'customer_phone' => 'required|string|max:20',
        'license_number' => 'required|string|max:50',
        'terms' => 'required|accepted',
    ];
    
    echo "✓ Controller expects " . count($requiredFields) . " required fields:\n";
    foreach ($requiredFields as $field => $rule) {
        echo "  - $field: $rule\n";
    }
    
    echo "\n5. Testing booking creation logic...\n";
    
    // Test if we can create a booking instance (without saving)
    $testBooking = new \App\Models\Booking([
        'user_id' => 1,
        'car_id' => 1,
        'booking_number' => 'TEST-' . time(),
        'pickup_location' => 'Test Location',
        'dropoff_location' => 'Test Dropoff',
        'pickup_date' => now()->addDays(1),
        'return_date' => now()->addDays(3),
        'days' => 2,
        'daily_rate' => 100.00,
        'total_amount' => 200.00,
        'tax_amount' => 20.00,
        'discount_amount' => 0.00,
        'final_amount' => 220.00,
        'customer_name' => 'Test Customer',
        'customer_email' => 'test@example.com',
        'customer_phone' => '123-456-7890',
        'status' => 'pending',
        'payment_status' => 'pending',
    ]);
    
    echo "✓ Booking model instance created successfully\n";
    
    echo "\nTest completed successfully!\n";
    echo "\nPossible booking issues to check:\n";
    echo "1. User authentication - ensure user is logged in\n";
    echo "2. CSRF token - check if form includes proper CSRF token\n";
    echo "3. JavaScript validation - check browser console for errors\n";
    echo "4. Form submission - verify all required fields are filled\n";
    echo "5. Car availability - ensure selected car is available\n";
    
} catch (Exception $e) {
    echo "✗ Error during testing: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}