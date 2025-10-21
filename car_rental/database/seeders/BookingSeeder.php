<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Car;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run()
    {
        // Get some users and cars
        $users = User::where('role', 'user')->take(10)->get();
        $cars = Car::where('is_available', true)->get();

        if ($users->isEmpty() || $cars->isEmpty()) {
            $this->command->info('No users or cars found. Please seed users and cars first.');
            return;
        }

        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'refunded'];

        // Create 25 sample bookings
        for ($i = 0; $i < 25; $i++) {
            $user = $users->random();
            $car = $cars->random();
            
            // Random dates
            $pickupDate = Carbon::now()->addDays(rand(-30, 30));
            $returnDate = $pickupDate->copy()->addDays(rand(1, 7));
            $days = $pickupDate->diffInDays($returnDate);
            
            $dailyRate = $car->daily_rate ?? 100;
            $totalAmount = $dailyRate * $days;
            $taxAmount = $totalAmount * 0.10;
            $finalAmount = $totalAmount + $taxAmount;

            Booking::create([
                'user_id' => $user->id,
                'car_id' => $car->id,
                'booking_number' => 'BK' . date('Y') . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'pickup_location' => ['Downtown', 'Airport', 'City Center', 'Mall', 'Hotel'][rand(0, 4)],
                'dropoff_location' => ['Downtown', 'Airport', 'City Center', 'Mall', 'Hotel'][rand(0, 4)],
                'pickup_date' => $pickupDate,
                'return_date' => $returnDate,
                'days' => $days,
                'daily_rate' => $dailyRate,
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'discount_amount' => 0,
                'final_amount' => $finalAmount,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone ?? '555-000' . rand(1000, 9999),
                'special_requirements' => ['Business trip', 'Family vacation', 'Weekend getaway', 'Airport transfer', null][rand(0, 4)],
                'status' => $statuses[rand(0, 3)],
                'payment_status' => $paymentStatuses[rand(0, 2)],
                'created_at' => Carbon::now()->subDays(rand(0, 90)),
                'updated_at' => Carbon::now()->subDays(rand(0, 30)),
            ]);
        }

        $this->command->info('✅ Created 25 sample bookings successfully!');
    }
}