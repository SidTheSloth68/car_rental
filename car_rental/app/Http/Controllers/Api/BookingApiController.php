<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingApiController extends Controller
{
    /**
     * Display a listing of bookings.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Booking::with(['car', 'user']);

            // Apply filters based on user role
            if (Auth::check()) {
                if (Auth::user()->role !== 'admin') {
                    $query->where('user_id', Auth::id());
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required'
                ], 401);
            }

            // Apply additional filters
            $this->applyBookingFilters($query, $request);

            // Apply sorting
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Pagination
            $perPage = min($request->get('per_page', 15), 50);
            $bookings = $query->paginate($perPage);

            // Transform the data
            $transformedBookings = $bookings->through(function ($booking) {
                return $this->transformBooking($booking);
            });

            return response()->json([
                'success' => true,
                'message' => 'Bookings retrieved successfully',
                'data' => [
                    'bookings' => $transformedBookings->items(),
                    'pagination' => [
                        'current_page' => $transformedBookings->currentPage(),
                        'per_page' => $transformedBookings->perPage(),
                        'total' => $transformedBookings->total(),
                        'last_page' => $transformedBookings->lastPage(),
                        'from' => $transformedBookings->firstItem(),
                        'to' => $transformedBookings->lastItem(),
                    ],
                    'statistics' => $this->getBookingStatistics(Auth::user()),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve bookings',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Store a newly created booking.
     */
    public function store(BookingRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            // Generate reference number
            $referenceNumber = $this->generateReferenceNumber();

            // Calculate booking details
            $car = Car::findOrFail($request->car_id);
            $bookingDetails = $this->calculateBookingDetails($car, $request->validated());

            // Create booking
            $booking = Booking::create(array_merge($request->validated(), [
                'user_id' => Auth::id(),
                'reference_number' => $referenceNumber,
                'status' => 'pending',
                'total_amount' => $bookingDetails['total_amount'],
                'tax_amount' => $bookingDetails['tax_amount'],
                'insurance_amount' => $bookingDetails['insurance_amount'],
                'additional_fees' => $bookingDetails['additional_fees'],
                'discount_amount' => $bookingDetails['discount_amount'],
                'final_amount' => $bookingDetails['final_amount'],
                'rental_days' => $bookingDetails['rental_days'],
                'created_at' => now(),
                'updated_at' => now(),
            ]));

            // Load relationships
            $booking->load(['car', 'user']);

            // Update car booking count
            $car->increment('total_bookings');

            // Send confirmation notification (you can implement this later)
            // $this->sendBookingConfirmation($booking);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully',
                'data' => [
                    'booking' => $this->transformBooking($booking, true),
                    'payment_instructions' => $this->getPaymentInstructions($booking),
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create booking',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking): JsonResponse
    {
        try {
            // Check authorization
            if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access to booking'
                ], 403);
            }

            $booking->load(['car', 'user']);

            return response()->json([
                'success' => true,
                'message' => 'Booking details retrieved successfully',
                'data' => [
                    'booking' => $this->transformBooking($booking, true),
                    'timeline' => $this->getBookingTimeline($booking),
                    'payment_history' => $this->getPaymentHistory($booking),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve booking details',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Update the specified booking.
     */
    public function update(Request $request, Booking $booking): JsonResponse
    {
        try {
            // Check authorization
            if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to update this booking'
                ], 403);
            }

            // Validate update request based on current status
            $allowedUpdates = $this->getAllowedUpdates($booking->status);
            $updateData = $request->only($allowedUpdates);

            // Apply business rules for updates
            if (isset($updateData['status'])) {
                $statusUpdate = $this->validateStatusUpdate($booking, $updateData['status']);
                if (!$statusUpdate['allowed']) {
                    return response()->json([
                        'success' => false,
                        'message' => $statusUpdate['message']
                    ], 400);
                }
            }

            // Update booking
            $booking->update($updateData);
            $booking->load(['car', 'user']);

            return response()->json([
                'success' => true,
                'message' => 'Booking updated successfully',
                'data' => [
                    'booking' => $this->transformBooking($booking, true)
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update booking',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Cancel the specified booking.
     */
    public function cancel(Request $request, Booking $booking): JsonResponse
    {
        try {
            // Check authorization
            if (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized to cancel this booking'
                ], 403);
            }

            // Check if cancellation is allowed
            $cancellationCheck = $this->checkCancellationPolicy($booking);
            if (!$cancellationCheck['allowed']) {
                return response()->json([
                    'success' => false,
                    'message' => $cancellationCheck['message'],
                    'data' => [
                        'cancellation_fee' => $cancellationCheck['fee'],
                        'refund_amount' => $cancellationCheck['refund_amount'],
                    ]
                ], 400);
            }

            DB::beginTransaction();

            // Update booking status
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $request->get('reason', 'Customer cancellation'),
                'cancellation_fee' => $cancellationCheck['fee'],
                'refund_amount' => $cancellationCheck['refund_amount'],
            ]);

            // Process refund (implement payment gateway integration)
            // $this->processRefund($booking);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Booking cancelled successfully',
                'data' => [
                    'booking' => $this->transformBooking($booking, true),
                    'refund_details' => [
                        'refund_amount' => $cancellationCheck['refund_amount'],
                        'cancellation_fee' => $cancellationCheck['fee'],
                        'refund_timeline' => '3-5 business days',
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel booking',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get booking statistics.
     */
    public function statistics(): JsonResponse
    {
        try {
            $user = Auth::user();
            $isAdmin = $user->role === 'admin';

            $cacheKey = $isAdmin ? 'admin_booking_statistics' : "user_booking_statistics_{$user->id}";
            
            $statistics = Cache::remember($cacheKey, 1800, function () use ($user, $isAdmin) {
                $query = $isAdmin ? Booking::query() : Booking::where('user_id', $user->id);

                return [
                    'total_bookings' => $query->count(),
                    'active_bookings' => (clone $query)->whereIn('status', ['confirmed', 'in_progress'])->count(),
                    'completed_bookings' => (clone $query)->where('status', 'completed')->count(),
                    'cancelled_bookings' => (clone $query)->where('status', 'cancelled')->count(),
                    'pending_bookings' => (clone $query)->where('status', 'pending')->count(),
                    'total_amount_spent' => (clone $query)->where('status', '!=', 'cancelled')->sum('final_amount'),
                    'average_booking_value' => (clone $query)->where('status', '!=', 'cancelled')->avg('final_amount'),
                    'bookings_by_month' => $this->getBookingsByMonth($query, $isAdmin),
                    'popular_cars' => $this->getPopularCars($query, $isAdmin),
                    'booking_status_distribution' => (clone $query)->select('status', DB::raw('count(*) as count'))
                        ->groupBy('status')
                        ->pluck('count', 'status'),
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Booking statistics retrieved successfully',
                'data' => $statistics
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve booking statistics',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get upcoming bookings.
     */
    public function upcoming(): JsonResponse
    {
        try {
            $query = Booking::with(['car', 'user'])
                ->whereIn('status', ['confirmed', 'pending'])
                ->where('pickup_date', '>=', now());

            if (Auth::user()->role !== 'admin') {
                $query->where('user_id', Auth::id());
            }

            $upcomingBookings = $query->orderBy('pickup_date', 'asc')
                ->limit(10)
                ->get()
                ->map(function ($booking) {
                    return $this->transformBooking($booking);
                });

            return response()->json([
                'success' => true,
                'message' => 'Upcoming bookings retrieved successfully',
                'data' => [
                    'upcoming_bookings' => $upcomingBookings,
                    'count' => $upcomingBookings->count(),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve upcoming bookings',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Apply booking filters.
     */
    private function applyBookingFilters($query, Request $request): void
    {
        // Status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->where('pickup_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->where('return_date', '<=', $request->date_to);
        }

        // Car filter
        if ($request->has('car_id') && !empty($request->car_id)) {
            $query->where('car_id', $request->car_id);
        }

        // Amount range filter
        if ($request->has('amount_min') && !empty($request->amount_min)) {
            $query->where('final_amount', '>=', $request->amount_min);
        }
        if ($request->has('amount_max') && !empty($request->amount_max)) {
            $query->where('final_amount', '<=', $request->amount_max);
        }

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference_number', 'LIKE', "%{$search}%")
                  ->orWhere('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_email', 'LIKE', "%{$search}%")
                  ->orWhereHas('car', function ($carQuery) use ($search) {
                      $carQuery->where('make', 'LIKE', "%{$search}%")
                               ->orWhere('model', 'LIKE', "%{$search}%");
                  });
            });
        }
    }

    /**
     * Transform booking data for API response.
     */
    private function transformBooking(Booking $booking, bool $detailed = false): array
    {
        $baseData = [
            'id' => $booking->id,
            'reference_number' => $booking->reference_number,
            'status' => $booking->status,
            'pickup_date' => $booking->pickup_date,
            'return_date' => $booking->return_date,
            'pickup_location' => $booking->pickup_location,
            'return_location' => $booking->return_location,
            'total_amount' => $booking->total_amount,
            'final_amount' => $booking->final_amount,
            'rental_days' => $booking->rental_days,
            'created_at' => $booking->created_at->toISOString(),
            'car' => [
                'id' => $booking->car->id,
                'make' => $booking->car->make,
                'model' => $booking->car->model,
                'year' => $booking->car->year,
                'image' => $booking->car->image,
                'type' => $booking->car->type,
            ],
        ];

        if ($detailed) {
            $baseData = array_merge($baseData, [
                'customer_name' => $booking->customer_name,
                'customer_email' => $booking->customer_email,
                'customer_phone' => $booking->customer_phone,
                'pickup_time' => $booking->pickup_time,
                'return_time' => $booking->return_time,
                'tax_amount' => $booking->tax_amount,
                'insurance_amount' => $booking->insurance_amount,
                'additional_fees' => $booking->additional_fees,
                'discount_amount' => $booking->discount_amount,
                'payment_method' => $booking->payment_method,
                'insurance_coverage' => $booking->insurance_coverage,
                'special_requests' => $booking->special_requests,
                'additional_drivers' => $booking->additional_drivers,
                'child_seats' => $booking->child_seats,
                'cancelled_at' => $booking->cancelled_at,
                'cancellation_reason' => $booking->cancellation_reason,
                'updated_at' => $booking->updated_at->toISOString(),
            ]);
        }

        return $baseData;
    }

    /**
     * Calculate booking details including pricing.
     */
    private function calculateBookingDetails(Car $car, array $bookingData): array
    {
        $pickupDate = Carbon::parse($bookingData['pickup_date']);
        $returnDate = Carbon::parse($bookingData['return_date']);
        $rentalDays = $pickupDate->diffInDays($returnDate);
        $rentalDays = max($rentalDays, 1); // Minimum 1 day

        // Base amount calculation
        $baseAmount = $rentalDays * $car->daily_rate;

        // Apply weekly/monthly discounts
        if ($rentalDays >= 30) {
            $baseAmount = min($baseAmount, $car->monthly_rate);
        } elseif ($rentalDays >= 7) {
            $weeks = floor($rentalDays / 7);
            $remainingDays = $rentalDays % 7;
            $baseAmount = ($weeks * $car->weekly_rate) + ($remainingDays * $car->daily_rate);
        }

        // Additional fees
        $additionalFees = 0;
        if (!empty($bookingData['additional_drivers'])) {
            $additionalFees += $bookingData['additional_drivers'] * 10 * $rentalDays; // $10 per driver per day
        }
        if (!empty($bookingData['child_seats'])) {
            $additionalFees += $bookingData['child_seats'] * 5 * $rentalDays; // $5 per seat per day
        }
        if (!empty($bookingData['gps_navigation'])) {
            $additionalFees += 5 * $rentalDays; // $5 per day for GPS
        }

        // Insurance amount
        $insuranceRates = [
            'basic' => 0.05,
            'standard' => 0.10,
            'premium' => 0.15,
            'comprehensive' => 0.20,
        ];
        $insuranceRate = $insuranceRates[$bookingData['insurance_coverage']] ?? 0.10;
        $insuranceAmount = $baseAmount * $insuranceRate;

        // Tax calculation (10%)
        $taxAmount = ($baseAmount + $additionalFees + $insuranceAmount) * 0.10;

        // Total before discount
        $totalAmount = $baseAmount + $additionalFees + $insuranceAmount + $taxAmount;

        // Apply discounts (you can implement loyalty discounts, promotional codes, etc.)
        $discountAmount = 0;

        // Final amount
        $finalAmount = $totalAmount - $discountAmount;

        return [
            'rental_days' => $rentalDays,
            'total_amount' => round($baseAmount, 2),
            'tax_amount' => round($taxAmount, 2),
            'insurance_amount' => round($insuranceAmount, 2),
            'additional_fees' => round($additionalFees, 2),
            'discount_amount' => round($discountAmount, 2),
            'final_amount' => round($finalAmount, 2),
        ];
    }

    /**
     * Generate unique reference number.
     */
    private function generateReferenceNumber(): string
    {
        do {
            $reference = 'BK' . date('Ymd') . strtoupper(Str::random(6));
        } while (Booking::where('reference_number', $reference)->exists());

        return $reference;
    }

    /**
     * Get allowed updates based on booking status.
     */
    private function getAllowedUpdates(string $status): array
    {
        $baseFields = ['special_requests'];

        switch ($status) {
            case 'pending':
                return array_merge($baseFields, ['pickup_date', 'return_date', 'pickup_time', 'return_time']);
            case 'confirmed':
                return array_merge($baseFields, ['pickup_time', 'return_time']);
            default:
                return $baseFields;
        }
    }

    /**
     * Validate status update.
     */
    private function validateStatusUpdate(Booking $booking, string $newStatus): array
    {
        $allowedTransitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['in_progress', 'cancelled'],
            'in_progress' => ['completed'],
            'completed' => [],
            'cancelled' => [],
        ];

        $allowed = in_array($newStatus, $allowedTransitions[$booking->status] ?? []);

        return [
            'allowed' => $allowed,
            'message' => $allowed ? 'Status update allowed' : 'Invalid status transition'
        ];
    }

    /**
     * Check cancellation policy.
     */
    private function checkCancellationPolicy(Booking $booking): array
    {
        $now = now();
        $pickupDate = Carbon::parse($booking->pickup_date);
        $hoursUntilPickup = $now->diffInHours($pickupDate, false);

        if ($hoursUntilPickup < 0) {
            return [
                'allowed' => false,
                'message' => 'Cannot cancel booking after pickup date has passed',
                'fee' => $booking->final_amount,
                'refund_amount' => 0,
            ];
        }

        // Cancellation policy based on time until pickup
        if ($hoursUntilPickup >= 48) {
            // Free cancellation 48+ hours before
            $fee = 0;
        } elseif ($hoursUntilPickup >= 24) {
            // 25% fee for 24-48 hours before
            $fee = $booking->final_amount * 0.25;
        } else {
            // 50% fee for less than 24 hours
            $fee = $booking->final_amount * 0.50;
        }

        $refundAmount = $booking->final_amount - $fee;

        return [
            'allowed' => true,
            'message' => 'Cancellation allowed',
            'fee' => round($fee, 2),
            'refund_amount' => round($refundAmount, 2),
        ];
    }

    /**
     * Get booking statistics for a user.
     */
    private function getBookingStatistics(User $user): array
    {
        $query = $user->role === 'admin' ? Booking::query() : Booking::where('user_id', $user->id);

        return [
            'total' => $query->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'confirmed' => (clone $query)->where('status', 'confirmed')->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
            'cancelled' => (clone $query)->where('status', 'cancelled')->count(),
        ];
    }

    /**
     * Get booking timeline.
     */
    private function getBookingTimeline(Booking $booking): array
    {
        // Implementation for booking timeline/history
        return [
            [
                'date' => $booking->created_at->toISOString(),
                'event' => 'Booking Created',
                'description' => 'Booking was created and is pending confirmation',
            ],
            // Add more timeline events based on booking history
        ];
    }

    /**
     * Get payment history.
     */
    private function getPaymentHistory(Booking $booking): array
    {
        // Implementation for payment history
        // This would integrate with your payment system
        return [];
    }

    /**
     * Get payment instructions.
     */
    private function getPaymentInstructions(Booking $booking): array
    {
        return [
            'reference_number' => $booking->reference_number,
            'amount' => $booking->final_amount,
            'currency' => 'USD',
            'payment_methods' => ['credit_card', 'debit_card', 'paypal'],
            'payment_deadline' => now()->addHours(24)->toISOString(),
        ];
    }

    /**
     * Get bookings by month.
     */
    private function getBookingsByMonth($query, bool $isAdmin): array
    {
        return (clone $query)
            ->select(DB::raw("strftime('%Y', created_at) as year, strftime('%m', created_at) as month, COUNT(*) as count"))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get()
            ->toArray();
    }

    /**
     * Get popular cars.
     */
    private function getPopularCars($query, bool $isAdmin): array
    {
        return (clone $query)
            ->join('cars', 'bookings.car_id', '=', 'cars.id')
            ->select('cars.make', 'cars.model', DB::raw('COUNT(bookings.id) as booking_count'))
            ->groupBy('cars.id', 'cars.make', 'cars.model')
            ->orderByDesc('booking_count')
            ->limit(5)
            ->get()
            ->toArray();
    }
}