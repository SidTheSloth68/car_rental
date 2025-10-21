<?php

// Simple test to check booking functionality
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Car;
use App\Models\Booking;

echo "Testing Booking System...\n\n";

// Test 1: Check if we can create a user
echo "1. Testing User creation...\n";
try {
    $testUser = User::first();
    if ($testUser) {
        echo "✓ User found: {$testUser->name} ({$testUser->email})\n";
    } else {
        echo "✗ No users found in database\n";
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

// Test 2: Check if we can get cars
echo "\n2. Testing Car availability...\n";
try {
    $cars = Car::available()->take(3)->get();
    if ($cars->count() > 0) {
        echo "✓ Found {$cars->count()} available cars\n";
        foreach ($cars as $car) {
            echo "  - {$car->make} {$car->model} ({$car->year}) - \${$car->daily_rate}/day\n";
        }
    } else {
        echo "✗ No available cars found\n";
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

// Test 3: Check if we can create a booking
echo "\n3. Testing Booking creation...\n";
try {
    if ($testUser && $cars->count() > 0) {
        $car = $cars->first();
        $booking = new Booking([
            'user_id' => $testUser->id,
            'car_id' => $car->id,
            'booking_number' => 'TEST-' . time(),
            'pickup_location' => 'Test Location',
            'dropoff_location' => 'Test Location',
            'pickup_date' => now()->addDay(),
            'return_date' => now()->addDays(3),
            'days' => 2,
            'daily_rate' => $car->daily_rate,
            'total_amount' => $car->daily_rate * 2,
            'tax_amount' => $car->daily_rate * 2 * 0.1,
            'discount_amount' => 0,
            'final_amount' => $car->daily_rate * 2 * 1.1,
            'customer_name' => $testUser->name,
            'customer_email' => $testUser->email,
            'customer_phone' => '123-456-7890',
            'license_number' => 'TEST123',
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);
        
        echo "✓ Booking object created successfully\n";
        echo "  - Booking Number: {$booking->booking_number}\n";
        echo "  - Car: {$car->make} {$car->model}\n";
        echo "  - Total: \${$booking->final_amount}\n";
        
        // Try to save it (but don't actually save for testing)
        // $booking->save();
        
    } else {
        echo "✗ Cannot test booking - missing user or cars\n";
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\nTest completed.\n";