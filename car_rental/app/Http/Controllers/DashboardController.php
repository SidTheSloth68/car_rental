<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Car;

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
        
        // Get real dashboard statistics from database
        $userBookings = $user->bookings();
        $stats = [
            'upcoming_orders' => $userBookings->whereIn('status', ['confirmed', 'pending'])->count(),
            'coupons' => 0, // TODO: Implement coupons system
            'total_orders' => $userBookings->count(),
            'cancelled_orders' => $userBookings->where('status', 'cancelled')->count()
        ];

        // Get recent orders from database
        $recentBookings = $user->bookings()
            ->with('car')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentOrders = $recentBookings->map(function($booking) {
            return [
                'id' => '#' . str_pad($booking->id, 5, '0', STR_PAD_LEFT),
                'car_name' => $booking->car->make . ' ' . $booking->car->model,
                'pickup_location' => $booking->pickup_location,
                'dropoff_location' => $booking->dropoff_location,
                'pickup_date' => $booking->pickup_date->format('F j, Y'),
                'return_date' => $booking->return_date->format('F j, Y'),
                'status' => $booking->status
            ];
        });

        // Get favorite cars from available cars (top rated or most booked)
        $favoriteCars = \App\Models\Car::where('available', true)
            ->select('id', 'make', 'model', 'year', 'image', 'seats', 'luggage_capacity', 'doors', 'fuel_type', 'horsepower', 'engine_size', 'transmission', 'type', 'daily_rate')
            ->orderBy('daily_rate', 'desc') // Show premium cars as favorites
            ->take(6)
            ->get()
            ->map(function($car) {
                return [
                    'name' => $car->make . ' ' . $car->model,
                    'image' => $car->image ?: 'images/cars/default.jpg',
                    'seats' => $car->seats ?: 4,
                    'luggage' => $car->luggage_capacity ?: 2,
                    'doors' => $car->doors ?: 4,
                    'fuel' => $car->fuel_type ?: 'Petrol',
                    'horsepower' => $car->horsepower ?: 200,
                    'engine' => $car->engine_size ?: 2000,
                    'drive' => $car->transmission ?: 'Manual',
                    'type' => $car->type ?: 'Sedan',
                    'daily_rate' => $car->daily_rate ?: 100
                ];
            });

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
        
        // Get real booking data
        $bookings = $user->bookings()->with('car')->orderBy('created_at', 'desc')->get();
        
        // If there are real bookings, use them; otherwise, fall back to mock data
        if ($bookings->isNotEmpty()) {
            // Group real bookings by status for the view
            $scheduledOrders = $bookings->where('status', 'confirmed')->map(function($booking) {
                return [
                    'id' => '#' . str_pad($booking->id, 5, '0', STR_PAD_LEFT),
                    'car_name' => $booking->car->make . ' ' . $booking->car->model,
                    'pickup_location' => $booking->pickup_location,
                    'dropoff_location' => $booking->dropoff_location,
                    'pickup_date' => $booking->pickup_date,
                    'return_date' => $booking->return_date,
                    'status' => 'scheduled'
                ];
            })->values();
            
            $completedOrders = $bookings->where('status', 'completed')->map(function($booking) {
                return [
                    'id' => '#' . str_pad($booking->id, 5, '0', STR_PAD_LEFT),
                    'car_name' => $booking->car->make . ' ' . $booking->car->model,
                    'pickup_location' => $booking->pickup_location,
                    'dropoff_location' => $booking->dropoff_location,
                    'pickup_date' => $booking->pickup_date,
                    'return_date' => $booking->return_date,
                    'status' => 'completed'
                ];
            })->values();
            
            $cancelledOrders = $bookings->where('status', 'cancelled')->map(function($booking) {
                return [
                    'id' => '#' . str_pad($booking->id, 5, '0', STR_PAD_LEFT),
                    'car_name' => $booking->car->make . ' ' . $booking->car->model,
                    'pickup_location' => $booking->pickup_location,
                    'dropoff_location' => $booking->dropoff_location,
                    'pickup_date' => $booking->pickup_date,
                    'return_date' => $booking->return_date,
                    'status' => 'cancelled'
                ];
            })->values();
        } else {
            // Fall back to mock data if no real bookings exist
            $scheduledOrders = collect([]);
            $completedOrders = collect([]);
            $cancelledOrders = collect([]);
        }

        return view('dashboard.bookings', compact('user', 'bookings', 'scheduledOrders', 'completedOrders', 'cancelledOrders'));
    }

    /**
     * Show the user favorites page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function favorites()
    {
        $user = Auth::user();
        
        // TODO: Implement user favorites system with a favorites table
        // For now, show available premium cars as sample favorites
        $favoriteCars = Car::where('available', true)
            ->where('daily_rate', '>', 200) // Show premium cars as favorites
            ->select('id', 'make', 'model', 'year', 'image', 'seats', 'luggage_capacity', 'doors', 'fuel_type', 'horsepower', 'engine_size', 'transmission', 'type', 'daily_rate')
            ->orderBy('daily_rate', 'desc')
            ->take(6)
            ->get()
            ->map(function($car) {
                return [
                    'id' => $car->id,
                    'name' => $car->make . ' ' . $car->model,
                    'image' => $car->image ?: 'images/cars/default.jpg',
                    'seats' => $car->seats ?: 4,
                    'luggage' => $car->luggage_capacity ?: 2,
                    'doors' => $car->doors ?: 4,
                    'fuel' => $car->fuel_type ?: 'Petrol',
                    'horsepower' => $car->horsepower ?: 200,
                    'engine' => $car->engine_size ?: 2000,
                    'drive' => $car->transmission ?: 'Manual',
                    'type' => $car->type ?: 'Sedan',
                    'daily_rate' => $car->daily_rate ?: 100
                ];
            });
        
        return view('dashboard.favorites', compact('user', 'favoriteCars'));
    }
}