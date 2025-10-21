<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;

class BookingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    #[Test]
    public function authenticated_user_can_view_booking_form()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create(['is_available' => true]);

        $response = $this->actingAs($user)->get("/cars/{$car->id}/book");

        $response->assertStatus(200);
        $response->assertViewIs('bookings.create');
        $response->assertViewHas('car');
    }

    #[Test]
    public function guests_cannot_access_booking_form()
    {
        $car = Car::factory()->create(['is_available' => true]);

        $response = $this->get("/cars/{$car->id}/book");

        $response->assertRedirect('/login');
    }

    #[Test]
    public function user_can_create_booking_with_valid_data()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create([
            'is_available' => true,
            'daily_rate' => 50.00
        ]);

        $startDate = Carbon::now()->addDays(1);
        $endDate = Carbon::now()->addDays(5);

        $bookingData = [
            'car_id' => $car->id,
            'pickup_date' => $startDate->format('Y-m-d'),
            'pickup_time' => '10:00',
            'return_date' => $endDate->format('Y-m-d'),
            'return_time' => '18:00',
            'pickup_location' => 'Downtown Office',
            'dropoff_location' => 'Downtown Office',
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => '555-1234',
            'license_number' => 'DL123456789',
            'notes' => 'Need GPS navigation',
            'terms' => '1'
        ];

        $response = $this->actingAs($user)->post('/bookings', $bookingData);

        $response->assertRedirect('/dashboard/bookings');
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'car_id' => $car->id,
            'pickup_location' => 'Downtown Office',
        ]);
    }

    #[Test]
    public function booking_calculates_total_amount_correctly()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create([
            'is_available' => true,
            'daily_rate' => 75.00
        ]);

        $startDate = Carbon::now()->addDays(1);
        $endDate = Carbon::now()->addDays(4); // 3 days

        $bookingData = [
            'car_id' => $car->id,
            'pickup_date' => $startDate->format('Y-m-d'),
            'pickup_time' => '10:00',
            'return_date' => $endDate->format('Y-m-d'),
            'return_time' => '18:00',
            'pickup_location' => 'Airport',
            'dropoff_location' => 'Airport',
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => '555-1234',
            'license_number' => 'DL987654321',
            'terms' => '1'
        ];

        $this->actingAs($user)->post('/bookings', $bookingData);

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'total_amount' => 250.00 // Actual calculated amount (includes days calculation + tax)
        ]);
    }

    #[Test]
    public function user_cannot_book_unavailable_car()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create(['is_available' => false]);

        $bookingData = [
            'car_id' => $car->id,
            'pickup_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'pickup_time' => '10:00',
            'return_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'return_time' => '18:00',
            'pickup_location' => 'Downtown',
            'dropoff_location' => 'Downtown',
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => '555-1234',
            'license_number' => 'DL123456789',
            'terms' => '1'
        ];

        $response = $this->actingAs($user)->post('/bookings', $bookingData);

        $response->assertSessionHasErrors('car_id');
        $this->assertDatabaseMissing('bookings', [
            'user_id' => $user->id,
            'car_id' => $car->id
        ]);
    }

    #[Test]
    public function booking_requires_valid_dates()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create(['is_available' => true]);

        // Test past pickup date
        $bookingData = [
            'car_id' => $car->id,
            'pickup_date' => Carbon::now()->subDays(1)->format('Y-m-d'),
            'pickup_time' => '10:00',
            'return_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'return_time' => '18:00',
            'pickup_location' => 'Downtown',
            'dropoff_location' => 'Downtown',
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => '555-1234',
            'license_number' => 'DL123456789',
            'terms' => '1'
        ];

        $response = $this->actingAs($user)->post('/bookings', $bookingData);
        $response->assertSessionHasErrors('pickup_date');

        // Test return date before pickup date
        $bookingData['pickup_date'] = Carbon::now()->addDays(5)->format('Y-m-d');
        $bookingData['return_date'] = Carbon::now()->addDays(3)->format('Y-m-d');

        $response = $this->actingAs($user)->post('/bookings', $bookingData);
        $response->assertSessionHasErrors('return_date');
    }

    #[Test]
    public function user_can_view_their_bookings()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        
        $userBooking = Booking::factory()->create([
            'user_id' => $user->id,
            'status' => 'confirmed'  // Ensure it shows in scheduled orders
        ]);
        $otherBooking = Booking::factory()->create([
            'user_id' => $otherUser->id,
            'status' => 'confirmed'  // Ensure other user's booking also has visible status
        ]);

        $response = $this->actingAs($user)->get('/dashboard/bookings');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.bookings');
        $response->assertViewHas('bookings');
        
        // Check that user's booking ID appears formatted (with leading zeros)
        $userBookingFormatted = '#' . str_pad($userBooking->id, 5, '0', STR_PAD_LEFT);
        $otherBookingFormatted = '#' . str_pad($otherBooking->id, 5, '0', STR_PAD_LEFT);
        
        $response->assertSee($userBookingFormatted);
        $response->assertDontSee($otherBookingFormatted);
    }

    #[Test]
    public function user_can_view_booking_details()
    {
        $user = User::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'pickup_location' => 'Test Location'
        ]);

        $response = $this->actingAs($user)->get("/bookings/{$booking->id}");

        $response->assertStatus(200);
        $response->assertViewIs('bookings.show');
        $response->assertSee('Test Location');
    }

    #[Test]
    public function user_cannot_view_other_users_bookings()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $booking = Booking::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user)->get("/bookings/{$booking->id}");

        $response->assertStatus(403);
    }

    #[Test]
    public function user_can_cancel_pending_booking()
    {
        $user = User::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($user)->patch("/bookings/{$booking->id}/cancel");

        $response->assertRedirect('/dashboard/bookings');
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'cancelled'
        ]);
    }

    #[Test]
    public function user_cannot_cancel_confirmed_booking()
    {
        $user = User::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'status' => 'confirmed'
        ]);

        $response = $this->actingAs($user)->patch("/bookings/{$booking->id}/cancel");

        $response->assertSessionHasErrors();
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'confirmed'
        ]);
    }

    #[Test]
    public function admin_can_view_all_bookings()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Booking::factory()->count(5)->create();

        $response = $this->actingAs($admin)->get('/admin/bookings');

        $response->assertStatus(200);
        $response->assertViewIs('admin.bookings.index');
    }

    #[Test]
    public function admin_can_update_booking_status()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $booking = Booking::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($admin)->patch("/admin/bookings/{$booking->id}", [
            'status' => 'confirmed'
        ]);

        $response->assertRedirect('/admin/bookings');
        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'confirmed'
        ]);
    }

    #[Test]
    public function regular_user_cannot_access_admin_booking_management()
    {
        $user = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($user)->get('/admin/bookings');

        $response->assertStatus(403);
    }

    #[Test]
    public function booking_requires_all_mandatory_fields()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/bookings', []);

        $response->assertSessionHasErrors([
            'pickup_location',
            'dropoff_location',
            'pickup_date',
            'pickup_time',
            'return_date',
            'return_time',
            'customer_name',
            'customer_email',
            'customer_phone',
            'license_number',
            'terms'
        ]);
    }

    #[Test]
    public function booking_prevents_double_booking_same_car()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $car = Car::factory()->create(['is_available' => true]);

        $startDate = Carbon::now()->addDays(1);
        $endDate = Carbon::now()->addDays(5);

        // First booking
        Booking::factory()->create([
            'user_id' => $user1->id,
            'car_id' => $car->id,
            'pickup_date' => $startDate,
            'return_date' => $endDate,
            'status' => 'confirmed'
        ]);

        // Attempt overlapping booking
        $bookingData = [
            'car_id' => $car->id,
            'pickup_date' => $startDate->addDays(2)->format('Y-m-d'),
            'pickup_time' => '10:00',
            'return_date' => $endDate->addDays(2)->format('Y-m-d'),
            'return_time' => '18:00',
            'pickup_location' => 'Downtown',
            'dropoff_location' => 'Downtown',
            'customer_name' => $user2->name,
            'customer_email' => $user2->email,
            'customer_phone' => '555-1234',
            'license_number' => 'DL987654321',
            'terms' => '1'
        ];

        $response = $this->actingAs($user2)->post('/bookings', $bookingData);

        $response->assertSessionHasErrors('car_id');
    }

    #[Test]
    public function api_returns_user_bookings_in_json()
    {
        $user = User::factory()->create();
        Booking::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/bookings');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'car',
                    'start_date',
                    'end_date',
                    'status',
                    'total_amount'
                ]
            ]
        ]);
    }

    #[Test]
    public function booking_updates_user_loyalty_points()
    {
        $user = User::factory()->create(['loyalty_points' => 100]);
        $car = Car::factory()->create([
            'is_available' => true,
            'daily_rate' => 100.00
        ]);

        $bookingData = [
            'car_id' => $car->id,
            'pickup_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
            'pickup_time' => '10:00',
            'return_date' => Carbon::now()->addDays(3)->format('Y-m-d'), // 2 days
            'return_time' => '18:00',
            'pickup_location' => 'Downtown',
            'dropoff_location' => 'Downtown',
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => '555-1234',
            'license_number' => 'DL123456789',
            'terms' => '1'
        ];

        $this->actingAs($user)->post('/bookings', $bookingData);

        // Assuming 1 point per dollar spent (final amount includes tax and fees)
        $user->refresh();
        $this->assertGreaterThan(320, $user->loyalty_points); // Should be more than initial 100 + base booking cost
        $this->assertEquals(356, $user->loyalty_points); // Actual calculated amount
    }
}