<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pickupDate = $this->faker->dateTimeBetween('now', '+30 days');
        // Calculate return date as 1-7 days after pickup date
        $pickupCarbon = Carbon::parse($pickupDate);
        $returnDate = $this->faker->dateTimeBetween(
            $pickupCarbon->copy()->addDay(), 
            $pickupCarbon->copy()->addDays(7)
        );
        
        $days = Carbon::parse($pickupDate)->diffInDays(Carbon::parse($returnDate));
        if ($days == 0) $days = 1; // Minimum 1 day
        
        $dailyRate = $this->faker->randomFloat(2, 50, 200);
        $totalAmount = $dailyRate * $days;
        $taxAmount = $totalAmount * 0.10; // 10% tax
        $discountAmount = $this->faker->boolean(30) ? $totalAmount * 0.05 : 0; // 30% chance of 5% discount
        $finalAmount = $totalAmount + $taxAmount - $discountAmount;

        $locations = [
            'Downtown Office',
            'Airport Terminal',
            'City Center',
            'Suburban Branch',
            'North Branch',
            'South Branch',
            'Hotel Pickup',
            'Custom Location'
        ];

        $statuses = ['pending', 'confirmed', 'active', 'completed', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'partial', 'refunded', 'failed'];
        $paymentMethods = ['credit_card', 'debit_card', 'paypal', 'bank_transfer', 'cash'];

        return [
            'user_id' => User::factory(),
            'car_id' => Car::factory(),
            'booking_number' => 'BK-' . strtoupper($this->faker->bothify('??####')),
            'pickup_location' => $this->faker->randomElement($locations),
            'dropoff_location' => $this->faker->randomElement($locations),
            'pickup_date' => $pickupDate,
            'return_date' => $returnDate,
            'days' => $days,
            'daily_rate' => $dailyRate,
            'total_amount' => $totalAmount,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'final_amount' => $finalAmount,
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->safeEmail(),
            'customer_phone' => $this->faker->phoneNumber(),
            'customer_address' => $this->faker->address(),
            'special_requirements' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'extras' => $this->faker->boolean(40) ? $this->generateExtras() : null,
            'status' => $this->faker->randomElement($statuses),
            'payment_status' => $this->faker->randomElement($paymentStatuses),
            'payment_method' => $this->faker->randomElement($paymentMethods),
            'transaction_id' => $this->faker->boolean(70) ? 'TXN-' . strtoupper($this->faker->bothify('########')) : null,
            'confirmed_at' => $this->faker->boolean(60) ? $this->faker->dateTimeBetween('-1 week', 'now') : null,
            'cancelled_at' => $this->faker->boolean(10) ? $this->faker->dateTimeBetween('-1 week', 'now') : null,
            'completed_at' => $this->faker->boolean(20) ? $this->faker->dateTimeBetween('-1 month', 'now') : null,
            'admin_notes' => $this->faker->boolean(20) ? $this->faker->sentence() : null,
        ];
    }

    /**
     * Generate extras array for booking.
     */
    private function generateExtras(): array
    {
        $allExtras = [
            'gps_navigation' => ['name' => 'GPS Navigation', 'price' => 10.00],
            'child_seat' => ['name' => 'Child Safety Seat', 'price' => 15.00],
            'additional_driver' => ['name' => 'Additional Driver', 'price' => 25.00],
            'insurance_upgrade' => ['name' => 'Full Coverage Insurance', 'price' => 30.00],
            'fuel_prepaid' => ['name' => 'Pre-paid Fuel', 'price' => 50.00],
            'wifi_hotspot' => ['name' => 'Mobile WiFi Hotspot', 'price' => 8.00],
            'roof_rack' => ['name' => 'Roof Rack', 'price' => 20.00],
        ];

        $selectedExtras = $this->faker->randomElements($allExtras, $this->faker->numberBetween(1, 3));
        
        return $selectedExtras;
    }

    /**
     * Create a pending booking.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'payment_status' => 'pending',
            'confirmed_at' => null,
            'cancelled_at' => null,
            'completed_at' => null,
        ]);
    }

    /**
     * Create a confirmed booking.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'confirmed_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'cancelled_at' => null,
            'completed_at' => null,
        ]);
    }

    /**
     * Create a cancelled booking.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'payment_status' => 'refunded',
            'cancelled_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'completed_at' => null,
        ]);
    }

    /**
     * Create a completed booking.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'payment_status' => 'paid',
            'confirmed_at' => $this->faker->dateTimeBetween('-1 month', '-1 week'),
            'completed_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'cancelled_at' => null,
        ]);
    }
}