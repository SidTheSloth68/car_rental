<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Car;
use App\Models\Booking;
use App\Models\News;
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
            'total_customers' => User::where('role', 'customer')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_cars' => Car::count(),
            'available_cars' => Car::where('is_available', true)->count(),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'active')->count(),
            'total_news' => News::count(),
            'published_news' => News::where('status', 'published')->count(),
        ];

        // Recent activities
        $recent_users = User::latest()->take(5)->get();
        $recent_bookings = Booking::with(['car' => function($query) {
            $query->withTrashed();
        }, 'user'])->latest()->take(5)->get();
        $recent_cars = Car::latest()->take(5)->get();
        $recent_news = News::latest()->take(5)->get();

        // Monthly statistics (SQLite compatible)
        $monthly_bookings = Booking::select(
            DB::raw("strftime('%m', created_at) as month"),
            DB::raw('COUNT(*) as count')
        )
        ->where(DB::raw("strftime('%Y', created_at)"), '=', now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Revenue statistics (if you have pricing)
        $revenue_stats = [
            'total_revenue' => Booking::whereIn('status', ['active', 'done'])->sum('final_amount') ?? 0,
            'monthly_revenue' => Booking::whereIn('status', ['active', 'done'])
                ->where(DB::raw("strftime('%Y-%m', created_at)"), '=', now()->format('Y-m'))
                ->sum('final_amount') ?? 0,
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recent_users',
            'recent_bookings',
            'recent_cars',
            'recent_news',
            'monthly_bookings',
            'revenue_stats'
        ));
    }
}