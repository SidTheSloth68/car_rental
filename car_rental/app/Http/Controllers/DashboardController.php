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
            'upcoming_orders' => $userBookings->where('status', 'active')->count(),
            'coupons' => 0, // TODO: Implement coupons system
            'total_orders' => $userBookings->count(),
            'cancelled_orders' => $userBookings->where('status', 'done')->count()
        ];

        // Get recent orders from database
        $recentBookings = $user->bookings()
            ->with(['car' => function($query) {
                $query->withTrashed();
            }])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentOrders = $recentBookings->map(function($booking) {
            $carName = 'Unknown Car';
            if ($booking->car) {
                $carName = ($booking->car->make ?? 'Unknown') . ' ' . ($booking->car->model ?? '');
            }
            
            // Map the 2-status system to display format
            $displayStatus = $booking->status === 'active' ? 'scheduled' : 'completed';
            
            return [
                'id' => '#' . str_pad($booking->id, 5, '0', STR_PAD_LEFT),
                'car_name' => $carName,
                'pickup_location' => $booking->pickup_location,
                'dropoff_location' => $booking->dropoff_location,
                'pickup_date' => $booking->pickup_date->format('F j, Y'),
                'return_date' => $booking->return_date->format('F j, Y'),
                'status' => $displayStatus
            ];
        });

        return view('dashboard.index', compact('user', 'stats', 'recentOrders'));
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
        $bookings = $user->bookings()->with(['car' => function($query) {
            $query->withTrashed();
        }])->orderBy('created_at', 'desc')->get();
        
        // If there are real bookings, use them; otherwise, fall back to mock data
        if ($bookings->isNotEmpty()) {
            // Group real bookings by status for the view
            $scheduledOrders = $bookings->where('status', 'active')->map(function($booking) {
                $carName = 'Unknown Car';
                if ($booking->car) {
                    $carName = ($booking->car->make ?? 'Unknown') . ' ' . ($booking->car->model ?? '');
                }
                
                return [
                    'id' => '#' . str_pad($booking->id, 5, '0', STR_PAD_LEFT),
                    'car_name' => $carName,
                    'pickup_location' => $booking->pickup_location,
                    'dropoff_location' => $booking->dropoff_location,
                    'pickup_date' => $booking->pickup_date,
                    'return_date' => $booking->return_date,
                    'status' => 'scheduled'
                ];
            })->values();
            
            $completedOrders = $bookings->where('status', 'done')->map(function($booking) {
                $carName = 'Unknown Car';
                if ($booking->car) {
                    $carName = ($booking->car->make ?? 'Unknown') . ' ' . ($booking->car->model ?? '');
                }
                
                return [
                    'id' => '#' . str_pad($booking->id, 5, '0', STR_PAD_LEFT),
                    'car_name' => $carName,
                    'pickup_location' => $booking->pickup_location,
                    'dropoff_location' => $booking->dropoff_location,
                    'pickup_date' => $booking->pickup_date,
                    'return_date' => $booking->return_date,
                    'status' => 'completed'
                ];
            })->values();
            
            // No cancelled orders in 2-status system, so empty array
            $cancelledOrders = collect([]);
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
        
        // Get actual user favorites from the database
        $favoriteCars = $user->favorites()
            ->select('cars.id', 'cars.make', 'cars.model', 'cars.year', 'cars.image', 'cars.seats', 'cars.luggage_capacity', 'cars.doors', 'cars.fuel_type', 'cars.transmission', 'cars.type', 'cars.daily_rate', 'cars.is_available')
            ->get()
            ->map(function($car) {
                // Determine the image path
                $imagePath = 'images/cars/default-car.jpg'; // default fallback
                
                if ($car->image) {
                    $imagePath = 'images/cars/' . $car->image;
                }
                
                return [
                    'id' => $car->id,
                    'name' => $car->make . ' ' . $car->model,
                    'image' => $imagePath,
                    'seats' => $car->seats ?: 4,
                    'luggage' => $car->luggage_capacity ?: 2,
                    'doors' => $car->doors ?: 4,
                    'fuel' => $car->fuel_type ?: 'Petrol',
                    'drive' => $car->transmission ?: 'Manual',
                    'type' => $car->type ?: 'Sedan',
                    'daily_rate' => $car->daily_rate ?: 100,
                    'is_available' => $car->is_available
                ];
            });
        
        return view('dashboard.favorites', compact('user', 'favoriteCars'));
    }
}