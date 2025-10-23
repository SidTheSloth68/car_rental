<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarSearchRequest;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CarApiController extends Controller
{
    /**
     * Display a listing of cars with search and filtering.
     */
    public function index(CarSearchRequest $request): JsonResponse
    {
        try {
            $query = Car::query();

            // Apply search filters
            $this->applySearchFilters($query, $request->validated());

            // Apply sorting
            $this->applySorting($query, $request->sort_by);

            // Get pagination parameters
            $perPage = min($request->per_page ?? 12, 60);
            
            // Execute query with pagination
            $cars = $query->paginate($perPage);

            // Transform the data
            $transformedCars = $cars->through(function ($car) {
                return $this->transformCar($car);
            });

            return response()->json([
                'success' => true,
                'message' => 'Cars retrieved successfully',
                'data' => [
                    'cars' => $transformedCars->items(),
                    'pagination' => [
                        'current_page' => $transformedCars->currentPage(),
                        'per_page' => $transformedCars->perPage(),
                        'total' => $transformedCars->total(),
                        'last_page' => $transformedCars->lastPage(),
                        'from' => $transformedCars->firstItem(),
                        'to' => $transformedCars->lastItem(),
                        'has_more_pages' => $transformedCars->hasMorePages(),
                    ],
                    'filters_applied' => $this->getAppliedFilters($request->validated()),
                    'total_available' => Car::where('is_available', true)->count(),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve cars',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Display the specified car.
     */
    public function show(Car $car): JsonResponse
    {
        try {
            // Increment view count
            $car->increment('views_count');

            $transformedCar = $this->transformCar($car, true);

            // Get related cars (same type or make)
            $relatedCars = Car::where('id', '!=', $car->id)
                ->where(function ($query) use ($car) {
                    $query->where('type', $car->type)
                          ->orWhere('make', $car->make);
                })
                ->where('is_available', true)
                ->limit(4)
                ->get()
                ->map(function ($relatedCar) {
                    return $this->transformCar($relatedCar);
                });

            return response()->json([
                'success' => true,
                'message' => 'Car details retrieved successfully',
                'data' => [
                    'car' => $transformedCar,
                    'related_cars' => $relatedCars,
                    'availability_calendar' => $this->getAvailabilityCalendar($car),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve car details',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get car availability for specific dates.
     */
    public function availability(Request $request, Car $car): JsonResponse
    {
        $request->validate([
            'pickup_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:pickup_date',
        ]);

        try {
            $isAvailable = $this->checkCarAvailability(
                $car->id,
                $request->pickup_date,
                $request->return_date
            );

            $conflictingBookings = [];
            if (!$isAvailable) {
                $conflictingBookings = $this->getConflictingBookings(
                    $car->id,
                    $request->pickup_date,
                    $request->return_date
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Availability checked successfully',
                'data' => [
                    'available' => $isAvailable,
                    'car_id' => $car->id,
                    'pickup_date' => $request->pickup_date,
                    'return_date' => $request->return_date,
                    'conflicting_bookings' => $conflictingBookings,
                    'alternative_dates' => $isAvailable ? [] : $this->suggestAlternativeDates($car->id),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to check availability',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get car statistics and analytics.
     */
    public function statistics(): JsonResponse
    {
        try {
            $cacheKey = 'car_statistics';
            
            $statistics = Cache::remember($cacheKey, 3600, function () {
                return [
                    'total_cars' => Car::count(),
                    'available_cars' => Car::where('is_available', true)->count(),
                    'featured_cars' => Car::where('is_featured', true)->count(),
                    'cars_by_type' => Car::select('type', DB::raw('count(*) as count'))
                        ->groupBy('type')
                        ->pluck('count', 'type'),
                    'cars_by_make' => Car::select('make', DB::raw('count(*) as count'))
                        ->groupBy('make')
                        ->orderByDesc('count')
                        ->limit(10)
                        ->pluck('count', 'make'),
                    'cars_by_fuel_type' => Car::select('fuel_type', DB::raw('count(*) as count'))
                        ->groupBy('fuel_type')
                        ->pluck('count', 'fuel_type'),
                    'cars_by_location' => Car::select('location', DB::raw('count(*) as count'))
                        ->groupBy('location')
                        ->pluck('count', 'location'),
                    'price_ranges' => [
                        'economy' => Car::where('daily_rate', '<', 50)->count(),
                        'mid_range' => Car::whereBetween('daily_rate', [50, 100])->count(),
                        'luxury' => Car::where('daily_rate', '>', 100)->count(),
                    ],
                    'average_rating' => Car::avg('rating'),
                    'total_bookings' => Car::sum('total_bookings'),
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Car statistics retrieved successfully',
                'data' => $statistics
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get featured cars.
     */
    public function featured(): JsonResponse
    {
        try {
            $featuredCars = Car::where('is_featured', true)
                ->where('is_available', true)
                ->orderByDesc('rating')
                ->limit(6)
                ->get()
                ->map(function ($car) {
                    return $this->transformCar($car);
                });

            return response()->json([
                'success' => true,
                'message' => 'Featured cars retrieved successfully',
                'data' => [
                    'featured_cars' => $featuredCars,
                    'count' => $featuredCars->count(),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve featured cars',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get car makes and models for filters.
     */
    public function makes(): JsonResponse
    {
        try {
            $cacheKey = 'car_makes_models';
            
            $makesAndModels = Cache::remember($cacheKey, 7200, function () {
                return Car::select('make', 'model')
                    ->distinct()
                    ->orderBy('make')
                    ->orderBy('model')
                    ->get()
                    ->groupBy('make')
                    ->map(function ($cars, $make) {
                        return [
                            'make' => $make,
                            'models' => $cars->pluck('model')->unique()->values(),
                            'count' => Car::where('make', $make)->count(),
                        ];
                    });
            });

            return response()->json([
                'success' => true,
                'message' => 'Car makes and models retrieved successfully',
                'data' => $makesAndModels
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve makes and models',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Apply search filters to the query.
     */
    private function applySearchFilters(Builder $query, array $filters): void
    {
        // Text search
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('make', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%");
            });
        }

        // Location filter
        if (!empty($filters['pickup_location']) && $filters['pickup_location'] !== 'all_locations') {
            $query->where('location', $filters['pickup_location']);
        }

        // Date availability filter
        if (!empty($filters['pickup_date']) && !empty($filters['return_date'])) {
            $query->whereDoesntHave('bookings', function ($q) use ($filters) {
                $q->where('status', '!=', 'cancelled')
                  ->where(function ($dateQuery) use ($filters) {
                      $dateQuery->whereBetween('pickup_date', [$filters['pickup_date'], $filters['return_date']])
                                ->orWhereBetween('return_date', [$filters['pickup_date'], $filters['return_date']])
                                ->orWhere(function ($overlapQuery) use ($filters) {
                                    $overlapQuery->where('pickup_date', '<=', $filters['pickup_date'])
                                                 ->where('return_date', '>=', $filters['return_date']);
                                });
                  });
            });
        }

        // Car type filter
        if (!empty($filters['car_type']) && $filters['car_type'] !== 'all') {
            $query->where('type', $filters['car_type']);
        }

        // Make and model filters
        if (!empty($filters['make'])) {
            $query->where('make', $filters['make']);
        }
        if (!empty($filters['model'])) {
            $query->where('model', $filters['model']);
        }

        // Year range filter
        if (!empty($filters['year_from'])) {
            $query->where('year', '>=', $filters['year_from']);
        }
        if (!empty($filters['year_to'])) {
            $query->where('year', '<=', $filters['year_to']);
        }

        // Fuel type filter
        if (!empty($filters['fuel_type']) && $filters['fuel_type'] !== 'all') {
            $query->where('fuel_type', $filters['fuel_type']);
        }

        // Transmission filter
        if (!empty($filters['transmission']) && $filters['transmission'] !== 'all') {
            $query->where('transmission', $filters['transmission']);
        }

        // Seats filter
        if (!empty($filters['seats'])) {
            $query->where('seats', '>=', $filters['seats']);
        }

        // Price range filter
        if (!empty($filters['price_min'])) {
            $query->where('daily_rate', '>=', $filters['price_min']);
        }
        if (!empty($filters['price_max'])) {
            $query->where('daily_rate', '<=', $filters['price_max']);
        }

        // Features filter
        if (!empty($filters['features']) && is_array($filters['features'])) {
            foreach ($filters['features'] as $feature) {
                $query->whereJsonContains('features', $feature);
            }
        }

        // Availability filter
        if (!empty($filters['availability']) && $filters['availability'] !== 'all') {
            $available = $filters['availability'] === 'available';
            $query->where('is_available', $available);
        }

        // Featured only filter
        if (!empty($filters['featured_only'])) {
            $query->where('is_featured', true);
        }

        // Rating filter
        if (!empty($filters['min_rating'])) {
            $query->where('rating', '>=', $filters['min_rating']);
        }

        // Mileage filter
        if (!empty($filters['mileage_max'])) {
            $query->where('mileage', '<=', $filters['mileage_max']);
        }

        // Color filter
        if (!empty($filters['color']) && $filters['color'] !== 'all') {
            $query->where('color', $filters['color']);
        }
    }

    /**
     * Apply sorting to the query.
     */
    private function applySorting(Builder $query, ?string $sortBy): void
    {
        switch ($sortBy) {
            case 'price_low_high':
                $query->orderBy('daily_rate', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('daily_rate', 'desc');
                break;
            case 'year_new_old':
                $query->orderByDesc('year');
                break;
            case 'year_old_new':
                $query->orderBy('year', 'asc');
                break;
            case 'rating_high_low':
                $query->orderByDesc('rating');
                break;
            case 'rating_low_high':
                $query->orderBy('rating', 'asc');
                break;
            case 'popularity':
                $query->orderByDesc('total_bookings')->orderByDesc('rating');
                break;
            case 'newest_first':
                $query->orderByDesc('created_at');
                break;
            case 'make_az':
                $query->orderBy('make', 'asc')->orderBy('model', 'asc');
                break;
            case 'make_za':
                $query->orderByDesc('make')->orderByDesc('model');
                break;
            default:
                $query->orderByDesc('is_featured')->orderByDesc('rating');
        }
    }

    /**
     * Transform car data for API response.
     */
    private function transformCar(Car $car, bool $detailed = false): array
    {
        $baseData = [
            'id' => $car->id,
            'make' => $car->make,
            'model' => $car->model,
            'year' => $car->year,
            'type' => $car->type,
            'fuel_type' => $car->fuel_type,
            'transmission' => $car->transmission,
            'seats' => $car->seats,
            'doors' => $car->doors,
            'daily_rate' => $car->daily_rate,
            'image' => $car->image,
            'images' => $car->images ?: [],
            'is_available' => $car->is_available,
            'rating' => $car->rating,
            'reviews_count' => $car->reviews_count,
            'slug' => str($car->make . ' ' . $car->model . ' ' . $car->year)->slug(),
        ];

        if ($detailed) {
            $baseData = array_merge($baseData, [
                'description' => $car->description,
                'features' => $car->features ? (is_string($car->features) ? json_decode($car->features, true) : $car->features) : [],
                'luggage_capacity' => $car->luggage_capacity,
                'last_service_date' => $car->last_service_date,
                'next_service_date' => $car->next_service_date,
            ]);
        }

        return $baseData;
    }

    /**
     * Check car availability for specific dates.
     */
    private function checkCarAvailability(int $carId, string $pickupDate, string $returnDate): bool
    {
        return !DB::table('bookings')
            ->where('car_id', $carId)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($pickupDate, $returnDate) {
                $query->whereBetween('pickup_date', [$pickupDate, $returnDate])
                      ->orWhereBetween('return_date', [$pickupDate, $returnDate])
                      ->orWhere(function ($subQuery) use ($pickupDate, $returnDate) {
                          $subQuery->where('pickup_date', '<=', $pickupDate)
                                   ->where('return_date', '>=', $returnDate);
                      });
            })
            ->exists();
    }

    /**
     * Get conflicting bookings for specific dates.
     */
    private function getConflictingBookings(int $carId, string $pickupDate, string $returnDate): array
    {
        return DB::table('bookings')
            ->where('car_id', $carId)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($pickupDate, $returnDate) {
                $query->whereBetween('pickup_date', [$pickupDate, $returnDate])
                      ->orWhereBetween('return_date', [$pickupDate, $returnDate])
                      ->orWhere(function ($subQuery) use ($pickupDate, $returnDate) {
                          $subQuery->where('pickup_date', '<=', $pickupDate)
                                   ->where('return_date', '>=', $returnDate);
                      });
            })
            ->get(['pickup_date', 'return_date', 'status'])
            ->toArray();
    }

    /**
     * Suggest alternative dates for car availability.
     */
    private function suggestAlternativeDates(int $carId): array
    {
        // Implementation for suggesting alternative dates
        // This is a simplified version - you can enhance based on business logic
        return [];
    }

    /**
     * Get availability calendar for a car.
     */
    private function getAvailabilityCalendar(Car $car): array
    {
        $startDate = now();
        $endDate = now()->addMonths(3);
        
        $bookings = DB::table('bookings')
            ->where('car_id', $car->id)
            ->where('status', '!=', 'cancelled')
            ->whereBetween('pickup_date', [$startDate, $endDate])
            ->get(['pickup_date', 'return_date'])
            ->toArray();

        return array_map(function ($booking) {
            return [
                'start' => $booking->pickup_date,
                'end' => $booking->return_date,
                'title' => 'Booked',
                'color' => '#dc3545'
            ];
        }, $bookings);
    }

    /**
     * Get applied filters summary.
     */
    private function getAppliedFilters(array $filters): array
    {
        $applied = [];
        
        foreach ($filters as $key => $value) {
            if (!empty($value) && $value !== 'all' && $value !== 'all_locations') {
                $applied[$key] = $value;
            }
        }

        return $applied;
    }
}