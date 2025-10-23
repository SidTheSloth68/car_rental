<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Car;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'total_customers' => User::where('role', 'user')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_cars' => Car::count(),
            'available_cars' => Car::where('is_available', true)->count(),
        ];

        // Recent activities
        $recent_users = User::latest()->take(5)->get();
        $recent_bookings = Booking::with(['car' => function($query) {
            $query->withTrashed();
        }, 'user'])->latest()->take(5)->get();
        $recent_cars = Car::latest()->take(5)->get();

        // DEBUG: DashboardController is running this page
        return view('admin.dashboard', compact(
            'stats',
            'recent_users',
            'recent_bookings',
            'recent_cars'
        ));
    }
}
