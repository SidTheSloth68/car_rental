<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get dashboard statistics
        $stats = [
            'upcoming_orders' => 3, // This will be dynamic when booking system is implemented
            'coupons' => 12,
            'total_orders' => 58,
            'cancelled_orders' => 24
        ];

        // Get recent orders (mock data for now)
        $recentOrders = collect([
            [
                'id' => '#01236',
                'car_name' => 'Jeep Renegade',
                'pickup_location' => 'New York',
                'dropoff_location' => 'Los Angeles',
                'pickup_date' => 'March 2, 2023',
                'return_date' => 'March 10, 2023',
                'status' => 'completed'
            ],
            [
                'id' => '#01263',
                'car_name' => 'Mini Cooper',
                'pickup_location' => 'San Fransisco',
                'dropoff_location' => 'Chicago',
                'pickup_date' => 'March 8, 2023',
                'return_date' => 'March 10, 2023',
                'status' => 'cancelled'
            ],
            [
                'id' => '#01245',
                'car_name' => 'Ferrari Enzo',
                'pickup_location' => 'Philadelphia',
                'dropoff_location' => 'Washington',
                'pickup_date' => 'March 6, 2023',
                'return_date' => 'March 10, 2023',
                'status' => 'scheduled'
            ],
            [
                'id' => '#01287',
                'car_name' => 'Hyundai Staria',
                'pickup_location' => 'Kansas City',
                'dropoff_location' => 'Houston',
                'pickup_date' => 'March 13, 2023',
                'return_date' => 'March 10, 2023',
                'status' => 'completed'
            ],
            [
                'id' => '#01216',
                'car_name' => 'Toyota Rav 4',
                'pickup_location' => 'Baltimore',
                'dropoff_location' => 'Sacramento',
                'pickup_date' => 'March 7, 2023',
                'return_date' => 'March 10, 2023',
                'status' => 'scheduled'
            ]
        ]);

        // Get favorite cars (mock data for now)
        $favoriteCars = collect([
            [
                'name' => 'Jeep Renegade',
                'image' => 'images/cars/jeep-renegade.jpg',
                'seats' => 4,
                'luggage' => 2,
                'doors' => 4,
                'fuel' => 'Petrol',
                'horsepower' => 500,
                'engine' => 3000,
                'drive' => '4x4',
                'type' => 'Hatchback',
                'daily_rate' => 265
            ],
            [
                'name' => 'BMW M2',
                'image' => 'images/cars/bmw-m5.jpg',
                'seats' => 4,
                'luggage' => 2,
                'doors' => 4,
                'fuel' => 'Petrol',
                'horsepower' => 500,
                'engine' => 3000,
                'drive' => '4x4',
                'type' => 'Hatchback',
                'daily_rate' => 244
            ],
            [
                'name' => 'Ferrari Enzo',
                'image' => 'images/cars/ferrari-enzo.jpg',
                'seats' => 4,
                'luggage' => 2,
                'doors' => 4,
                'fuel' => 'Petrol',
                'horsepower' => 500,
                'engine' => 3000,
                'drive' => '4x4',
                'type' => 'Hatchback',
                'daily_rate' => 167
            ]
        ]);

        return view('dashboard.index', compact('user', 'stats', 'recentOrders', 'favoriteCars'));
    }

    /**
     * Show the user profile page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    /**
     * Show the user bookings page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function bookings()
    {
        $user = Auth::user();
        
        // Mock booking data (will be replaced with real data when booking system is implemented)
        $scheduledOrders = collect([
            [
                'id' => '#01245',
                'car_name' => 'Ferrari Enzo',
                'pickup_location' => 'Kentucky',
                'dropoff_location' => 'Michigan',
                'pickup_date' => 'March 14, 2023',
                'return_date' => 'March 16, 2023',
                'status' => 'scheduled'
            ],
            [
                'id' => '#01246',
                'car_name' => 'VW Polo',
                'pickup_location' => 'Philadelphia',
                'dropoff_location' => 'Washington',
                'pickup_date' => 'March 16, 2023',
                'return_date' => 'March 18, 2023',
                'status' => 'scheduled'
            ],
            [
                'id' => '#01216',
                'car_name' => 'Toyota Rav 4',
                'pickup_location' => 'Baltimore',
                'dropoff_location' => 'Sacramento',
                'pickup_date' => 'March 19, 2023',
                'return_date' => 'March 20, 2023',
                'status' => 'scheduled'
            ]
        ]);

        $completedOrders = collect([
            [
                'id' => '#01236',
                'car_name' => 'Jeep Renegade',
                'pickup_location' => 'New York',
                'dropoff_location' => 'Los Angeles',
                'pickup_date' => 'March 2, 2023',
                'return_date' => 'March 11, 2023',
                'status' => 'completed'
            ],
            [
                'id' => '#01287',
                'car_name' => 'Hyundai Staria',
                'pickup_location' => 'Nevada',
                'dropoff_location' => 'New Mexico',
                'pickup_date' => 'March 6, 2023',
                'return_date' => 'March 12, 2023',
                'status' => 'completed'
            ],
            [
                'id' => '#01237',
                'car_name' => 'Range Rover',
                'pickup_location' => 'Virginia',
                'dropoff_location' => 'Oregon',
                'pickup_date' => 'March 2, 2023',
                'return_date' => 'March 13, 2023',
                'status' => 'completed'
            ],
            [
                'id' => '#01238',
                'car_name' => 'BMW M2',
                'pickup_location' => 'Kansas City',
                'dropoff_location' => 'Houston',
                'pickup_date' => 'March 1, 2023',
                'return_date' => 'March 14, 2023',
                'status' => 'completed'
            ]
        ]);

        $cancelledOrders = collect([
            [
                'id' => '#01263',
                'car_name' => 'Mini Cooper',
                'pickup_location' => 'San Francisco',
                'dropoff_location' => 'Chicago',
                'pickup_date' => 'March 8, 2023',
                'return_date' => 'March 12, 2023',
                'status' => 'cancelled'
            ],
            [
                'id' => '#01264',
                'car_name' => 'Ford Raptor',
                'pickup_location' => 'Georgia',
                'dropoff_location' => 'Louisiana',
                'pickup_date' => 'March 8, 2023',
                'return_date' => 'March 13, 2023',
                'status' => 'cancelled'
            ]
        ]);

        return view('dashboard.bookings', compact('user', 'scheduledOrders', 'completedOrders', 'cancelledOrders'));
    }

    /**
     * Show the user favorites page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function favorites()
    {
        $user = Auth::user();
        
        // Mock favorite cars data (will be replaced with real data when favorites system is implemented)
        // You can uncomment this to show sample favorite cars or leave empty to show the empty state
        $favoriteCars = collect([
            [
                'id' => 1,
                'name' => 'Jeep Renegade',
                'image' => 'images/cars/jeep-renegade.jpg',
                'seats' => 4,
                'luggage' => 2,
                'doors' => 4,
                'fuel' => 'Petrol',
                'horsepower' => 500,
                'engine' => 3000,
                'drive' => '4x4',
                'type' => 'Hatchback',
                'daily_rate' => 265
            ],
            [
                'id' => 2,
                'name' => 'BMW M2',
                'image' => 'images/cars/bmw-m5.jpg',
                'seats' => 4,
                'luggage' => 2,
                'doors' => 4,
                'fuel' => 'Petrol',
                'horsepower' => 500,
                'engine' => 3000,
                'drive' => '4x4',
                'type' => 'Hatchback',
                'daily_rate' => 244
            ],
            [
                'id' => 3,
                'name' => 'Ferrari Enzo',
                'image' => 'images/cars/ferrari-enzo.jpg',
                'seats' => 4,
                'luggage' => 2,
                'doors' => 4,
                'fuel' => 'Petrol',
                'horsepower' => 500,
                'engine' => 3000,
                'drive' => '4x4',
                'type' => 'Hatchback',
                'daily_rate' => 167
            ]
        ]);
        
        // To test the empty state, uncomment the line below:
        // $favoriteCars = collect([]);

        return view('dashboard.favorites', compact('user', 'favoriteCars'));
    }
}