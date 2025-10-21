<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CarController extends Controller
{
    /**
     * Apply middleware to controller methods
     */
    public function __construct()
    {
        // Require authentication for viewing car details (booking form)
        $this->middleware('auth')->only(['show']);
    }

    /**
     * Display a listing of cars
     */
    public function index(Request $request): View
    {
        $query = Car::query();

        // For guests and non-admin users, only show available cars
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            $query->available();
        }

        // Filter by car type
        if ($request->filled('car_type')) {
            $query->where('type', $request->car_type);
        }

        // Filter by fuel type
        if ($request->filled('fuel_type')) {
            $query->where('fuel_type', $request->fuel_type);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('daily_rate', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('daily_rate', '<=', $request->max_price);
        }

        // Filter by availability
        if ($request->filled('available')) {
            $query->available();
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Filter by date availability - check if car is not booked during requested dates
        if ($request->filled('pickup_date') && $request->filled('return_date')) {
            $pickupDate = $request->pickup_date;
            $returnDate = $request->return_date;
            
            // Get IDs of cars that have conflicting bookings
            $bookedCarIds = \App\Models\Booking::where(function($q) use ($pickupDate, $returnDate) {
                $q->whereBetween('start_date', [$pickupDate, $returnDate])
                  ->orWhereBetween('end_date', [$pickupDate, $returnDate])
                  ->orWhere(function($q) use ($pickupDate, $returnDate) {
                      $q->where('start_date', '<=', $pickupDate)
                        ->where('end_date', '>=', $returnDate);
                  });
            })
            ->whereIn('status', ['pending', 'confirmed', 'active'])
            ->pluck('car_id')
            ->toArray();
            
            // Exclude booked cars
            if (!empty($bookedCarIds)) {
                $query->whereNotIn('id', $bookedCarIds);
            }
        }

        // Search by make or model
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('make', 'like', '%' . $search . '%')
                  ->orWhere('model', 'like', '%' . $search . '%');
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSorts = ['daily_rate', 'price_per_day', 'year', 'created_at', 'make', 'model'];
        if (in_array($sortBy, $allowedSorts)) {
            // Map price_per_day to daily_rate for database queries
            $actualField = $sortBy === 'price_per_day' ? 'daily_rate' : $sortBy;
            $query->orderBy($actualField, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $cars = $query->paginate(12);

        // Pass search parameters to view for display
        $searchParams = [
            'pickup_location' => $request->pickup_location,
            'dropoff_location' => $request->dropoff_location,
            'pickup_date' => $request->pickup_date,
            'return_date' => $request->return_date,
            'car_type' => $request->car_type,
            'fuel_type' => $request->fuel_type,
            'search' => $request->search,
        ];

        return view('cars.index', compact('cars', 'searchParams'));
    }

    /**
     * Display cars in list view format
     */
    public function list(Request $request): View
    {
        $query = Car::query();

        // Filter by car type
        if ($request->filled('car_type')) {
            $query->whereIn('type', $request->car_type);
        }

        // Filter by fuel type
        if ($request->filled('fuel_type')) {
            $query->whereIn('fuel_type', $request->fuel_type);
        }

        // Filter by seats
        if ($request->filled('seats')) {
            $query->whereIn('seats', $request->seats);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('daily_rate', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('daily_rate', '<=', $request->max_price);
        }

        // Filter by availability
        if ($request->filled('available')) {
            $query->available();
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Search by make or model
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('make', 'like', '%' . $search . '%')
                  ->orWhere('model', 'like', '%' . $search . '%');
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        $allowedSorts = ['daily_rate', 'price_per_day', 'year', 'created_at', 'make', 'model'];
        if (in_array($sortBy, $allowedSorts)) {
            // Map price_per_day to daily_rate for database queries
            $actualField = $sortBy === 'price_per_day' ? 'daily_rate' : $sortBy;
            $query->orderBy($actualField, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $cars = $query->paginate(10); // Fewer items per page for list view

        return view('cars.list', compact('cars'));
    }

    /**
     * Show the form for creating a new car
     */
    public function create(): View
    {
        return view('cars.create');
    }

    /**
     * Store a newly created car in storage
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'type' => 'required|in:economy,compact,standard,intermediate,full_size,premium,luxury,suv,minivan,convertible,sports_car,truck,van,exotic',
            'fuel_type' => 'required|in:petrol,diesel,electric,hybrid,lpg',
            'transmission' => 'required|in:manual,automatic,cvt',
            'seats' => 'required|integer|min:1|max:12',
            'doors' => 'required|integer|min:2|max:6',
            'daily_rate' => 'required|numeric|min:0',
            'mileage' => 'nullable|integer|min:0',
            'color' => 'nullable|string|max:100',
            'license_plate' => 'nullable|string|max:20|unique:cars',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'gallery' => 'nullable|array',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'engine_size' => 'nullable|numeric|min:0',
            'horsepower' => 'nullable|integer|min:0',
            'fuel_consumption' => 'nullable|numeric|min:0',
            'insurance_included' => 'boolean',
            'deposit_required' => 'nullable|numeric|min:0'
        ]);

        $car = Car::create($validated);

        return redirect()->route('cars.show', $car)
                        ->with('success', 'Car created successfully!');
    }

    /**
     * Display the specified car
     */
    public function show(Car $car): View
    {
        // Get related cars (same type or make)
        $relatedCars = Car::where('id', '!=', $car->id)
                          ->where(function($query) use ($car) {
                              $query->where('car_type', $car->car_type)
                                    ->orWhere('make', $car->make);
                          })
                          ->available()
                          ->limit(4)
                          ->get();

        return view('cars.show', compact('car', 'relatedCars'));
    }

    /**
     * Show the form for editing the specified car
     */
    public function edit(Car $car): View
    {
        return view('cars.edit', compact('car'));
    }

    /**
     * Update the specified car in storage
     */
    public function update(Request $request, Car $car): RedirectResponse
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'type' => 'required|in:economy,compact,standard,intermediate,full_size,premium,luxury,suv,minivan,convertible,sports_car,truck,van,exotic',
            'fuel_type' => 'required|in:petrol,diesel,electric,hybrid,lpg',
            'transmission' => 'required|in:manual,automatic,cvt',
            'seats' => 'required|integer|min:1|max:12',
            'doors' => 'required|integer|min:2|max:6',
            'daily_rate' => 'required|numeric|min:0',
            'mileage' => 'nullable|integer|min:0',
            'color' => 'nullable|string|max:100',
            'license_plate' => 'nullable|string|max:20|unique:cars,license_plate,' . $car->id,
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'gallery' => 'nullable|array',
            'is_available' => 'boolean',
            'is_featured' => 'boolean',
            'engine_size' => 'nullable|numeric|min:0',
            'horsepower' => 'nullable|integer|min:0',
            'fuel_consumption' => 'nullable|numeric|min:0',
            'insurance_included' => 'boolean',
            'deposit_required' => 'nullable|numeric|min:0'
        ]);

        $car->update($validated);

        return redirect()->route('cars.show', $car)
                        ->with('success', 'Car updated successfully!');
    }

    /**
     * Remove the specified car from storage
     */
    public function destroy(Car $car): RedirectResponse
    {
        $car->delete();

        return redirect()->route('cars.index')
                        ->with('success', 'Car deleted successfully!');
    }

    /**
     * Get cars by type for AJAX requests
     */
    public function getByType(Request $request)
    {
        $type = $request->get('type');
        $cars = Car::where('type', $type)
                   ->available()
                   ->get(['id', 'make', 'model', 'year', 'daily_rate', 'image', 'gallery']);

        return response()->json($cars);
    }

    /**
     * Handle car search form submission and AJAX autocomplete
     */
    public function search(Request $request)
    {
        // If it's an AJAX request for autocomplete
        if ($request->ajax()) {
            $query = $request->get('q');
            
            if (strlen($query) < 2) {
                return response()->json([]);
            }

            $cars = Car::where('make', 'like', '%' . $query . '%')
                       ->orWhere('model', 'like', '%' . $query . '%')
                       ->available()
                       ->limit(10)
                       ->get(['id', 'make', 'model', 'year']);

            return response()->json($cars);
        }

        // Handle form submission - redirect to cars index with search parameters
        $searchParams = $request->only([
            'pickup_location',
            'dropoff_location', 
            'pickup_date',
            'dropoff_date',
            'car_type',
            'fuel_type',
            'min_price',
            'max_price',
            'search'
        ]);

        // Remove empty parameters
        $searchParams = array_filter($searchParams, function($value) {
            return !empty($value);
        });

        return redirect()->route('cars.index', $searchParams);
    }

    /**
     * Toggle car availability
     */
    public function toggleAvailability(Car $car): RedirectResponse
    {
        $car->update(['is_available' => !$car->is_available]);

        $status = $car->is_available ? 'available' : 'unavailable';
        
        return redirect()->back()
                        ->with('success', "Car marked as {$status}!");
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Car $car): RedirectResponse
    {
        $car->update(['is_featured' => !$car->is_featured]);

        $status = $car->is_featured ? 'featured' : 'unfeatured';
        
        return redirect()->back()
                        ->with('success', "Car marked as {$status}!");
    }
}