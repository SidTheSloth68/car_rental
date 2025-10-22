<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Car;
use App\Models\Booking;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_customers' => User::where('role', 'customer')->count(),
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

        // Monthly statistics
        $monthly_stats = [
            'bookings' => $this->getMonthlyBookings(),
            'revenue' => $this->getMonthlyRevenue(),
            'new_users' => $this->getMonthlyUsers(),
        ];

        // Popular cars
        $popular_cars = Car::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_users',
            'recent_bookings',
            'recent_news',
            'monthly_stats',
            'popular_cars'
        ));
    }

    /**
     * Users management page
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Cars management page
     */
    public function cars(Request $request)
    {
        $query = Car::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('make', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%");
            });
        }

        // Filter by availability
        if ($request->has('available') && $request->available != '') {
            $query->where('is_available', $request->available);
        }

        // Filter by type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        $cars = $query->withCount('bookings')->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.cars', compact('cars'));
    }

    /**
     * Bookings management page
     */
    public function bookings(Request $request)
    {
        $query = Booking::with(['car' => function($q) {
            $q->withTrashed();
        }, 'user']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reference_number', 'LIKE', "%{$search}%")
                  ->orWhere('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_email', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->where('pickup_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->where('return_date', '<=', $request->date_to);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * News management page
     */
    public function news(Request $request)
    {
        $query = News::with('author');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $news = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.news', compact('news'));
    }

    /**
     * System settings page
     */
    public function settings()
    {
        $system_info = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database_type' => config('database.default'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
            'storage_path' => storage_path(),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
        ];

        return view('admin.settings', compact('system_info'));
    }

    /**
     * Update a booking
     */
    public function updateBooking(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,active,completed,cancelled'
        ]);

        $booking->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.bookings')
            ->with('success', 'Booking status updated successfully.');
    }

    /**
     * Get monthly bookings data
     */
    private function getMonthlyBookings()
    {
        return Booking::select(
            DB::raw('COUNT(*) as count'),
            DB::raw("strftime('%m', created_at) as month"),
            DB::raw("strftime('%Y', created_at) as year")
        )
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
    }

    /**
     * Get monthly revenue data
     */
    private function getMonthlyRevenue()
    {
        return Booking::select(
            DB::raw('SUM(final_amount) as revenue'),
            DB::raw("strftime('%m', created_at) as month"),
            DB::raw("strftime('%Y', created_at) as year")
        )
        ->whereIn('status', ['active', 'done'])
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
    }

    /**
     * Get monthly new users data
     */
    private function getMonthlyUsers()
    {
        return User::select(
            DB::raw('COUNT(*) as count'),
            DB::raw("strftime('%m', created_at) as month"),
            DB::raw("strftime('%Y', created_at) as year")
        )
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
    }
}