<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Require authentication for all booking routes
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's bookings.
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()->with('car')->latest()->paginate(10);
        
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create()
    {
        $cars = Car::where('availability_status', 'available')->get();
        
        return view('bookings.create', compact('cars'));
    }

    /**
     * Show the form for creating a booking for a specific car.
     */
    public function createForCar(Car $car)
    {
        if ($car->availability_status !== 'available') {
            return redirect()->route('cars.index')
                ->with('error', 'This car is not available for booking.');
        }
        
        $cars = Car::where('availability_status', 'available')->get();
        
        return view('bookings.create', compact('car', 'cars'));
    }

    /**
     * Quick booking form.
     */
    public function quickBooking(Request $request)
    {
        $cars = Car::where('availability_status', 'available')->get();
        
        // Pre-fill form with query parameters if provided
        $pickupLocation = $request->query('pickup_location');
        $pickupDate = $request->query('pickup_date');
        $returnDate = $request->query('return_date');
        $carId = $request->query('car_id');
        
        return view('bookings.create', compact('cars', 'pickupLocation', 'pickupDate', 'returnDate', 'carId'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'nullable|exists:cars,id',
            'car_type' => 'required|string',
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'pickup_date' => 'required|date|after_or_equal:today',
            'pickup_time' => 'required|string',
            'return_date' => 'required|date|after:pickup_date',
            'return_time' => 'required|string',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'license_number' => 'required|string|max:50',
            'customer_address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'insurance' => 'nullable|boolean',
            'gps' => 'nullable|boolean',
            'child_seat' => 'nullable|boolean',
            'terms' => 'required|accepted',
        ]);

        try {
            // Combine date and time first
            $pickupDateTime = $validated['pickup_date'] . ' ' . $validated['pickup_time'];
            $returnDateTime = $validated['return_date'] . ' ' . $validated['return_time'];
            
            $pickupDate = Carbon::parse($pickupDateTime);
            $returnDate = Carbon::parse($returnDateTime);

            // If no specific car selected, find available car of requested type
            if (empty($validated['car_id'])) {
                $car = Car::where('is_available', true)
                    ->where('type', $validated['car_type'])
                    ->whereDoesntHave('bookings', function($query) use ($pickupDate, $returnDate) {
                        $query->where('status', '!=', 'cancelled')
                              ->where(function($q) use ($pickupDate, $returnDate) {
                                  $q->whereBetween('pickup_date', [$pickupDate, $returnDate])
                                    ->orWhereBetween('return_date', [$pickupDate, $returnDate])
                                    ->orWhere(function($q2) use ($pickupDate, $returnDate) {
                                        $q2->where('pickup_date', '<=', $pickupDate)
                                           ->where('return_date', '>=', $returnDate);
                                    });
                              });
                    })
                    ->orderBy('daily_rate')
                    ->first();
                    
                if (!$car) {
                    return back()->withErrors(['car_type' => 'No ' . $validated['car_type'] . ' cars available for the selected dates.'])->withInput();
                }
            } else {
                $car = Car::findOrFail($validated['car_id']);
                
                // Check if car has conflicting bookings
                $hasConflict = $car->bookings()
                    ->where('status', '!=', 'cancelled')
                    ->where(function($query) use ($pickupDate, $returnDate) {
                        $query->whereBetween('pickup_date', [$pickupDate, $returnDate])
                              ->orWhereBetween('return_date', [$pickupDate, $returnDate])
                              ->orWhere(function($q) use ($pickupDate, $returnDate) {
                                  $q->where('pickup_date', '<=', $pickupDate)
                                    ->where('return_date', '>=', $returnDate);
                              });
                    })
                    ->exists();
                    
                if ($hasConflict) {
                    return back()->withErrors(['car_id' => 'This car is not available for the selected dates. Please choose different dates.'])->withInput();
                }
            }
            
            // Check car availability flag
            if (!$car->is_available) {
                return back()->withErrors(['car_id' => 'This car is not available for booking.'])->withInput();
            }

            // Calculate booking details
            $days = $pickupDate->diffInDays($returnDate);
            
            if ($days < 1) {
                $days = 1;
            }

            $dailyRate = $car->daily_rate;
            $totalAmount = $dailyRate * $days;
            
            // Calculate tax (10%)
            $taxAmount = $totalAmount * 0.10;
            
            // Calculate extras cost (convert BDT prices)
            $extrasAmount = 0;
            $extras = [];
            
            if (!empty($validated['insurance'])) {
                $extrasAmount += 1650 * $days; // ৳1,650/day
                $extras[] = 'insurance';
            }
            
            if (!empty($validated['gps'])) {
                $extrasAmount += 550 * $days; // ৳550/day
                $extras[] = 'gps';
            }
            
            if (!empty($validated['child_seat'])) {
                $extrasAmount += 880 * $days; // ৳880/day
                $extras[] = 'child_seat';
            }
            
            $finalAmount = $totalAmount + $taxAmount + $extrasAmount;

            // Create booking
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'car_id' => $car->id,
                'booking_number' => Booking::generateBookingNumber(),
                'pickup_location' => $validated['pickup_location'],
                'dropoff_location' => $validated['dropoff_location'],
                'pickup_date' => $pickupDate,
                'return_date' => $returnDate,
                'days' => $days,
                'daily_rate' => $dailyRate,
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'discount_amount' => 0,
                'final_amount' => $finalAmount,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'] ?? null,
                'special_requirements' => $validated['notes'] ?? null,
                'extras' => count($extras) > 0 ? $extras : null,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => 'pending', // User will select payment method later
            ]);

            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Booking created successfully! Please select your payment method to complete the booking.');

        } catch (\Exception $e) {
            Log::error('Booking creation failed: ' . $e->getMessage());
            
            return back()->withErrors(['error' => 'Failed to create booking. Please try again.'])->withInput();
        }
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        // Ensure user can only view their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to booking.');
        }
        
        $booking->load('car');
        
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking)
    {
        // Ensure user can only edit their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to booking.');
        }
        
        // Only allow editing of pending bookings
        if ($booking->status !== 'pending') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Only pending bookings can be edited.');
        }
        
        $cars = Car::where('availability_status', 'available')->get();
        
        return view('bookings.edit', compact('booking', 'cars'));
    }

    /**
     * Update the specified booking in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        // Ensure user can only update their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to booking.');
        }
        
        // Only allow updating of pending bookings
        if ($booking->status !== 'pending') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Only pending bookings can be updated.');
        }

        $validated = $request->validate([
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'pickup_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:pickup_date',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'special_requirements' => 'nullable|string|max:1000',
        ]);

        try {
            // Recalculate days and amounts
            $pickupDate = Carbon::parse($validated['pickup_date']);
            $returnDate = Carbon::parse($validated['return_date']);
            $days = $pickupDate->diffInDays($returnDate);
            
            if ($days < 1) {
                $days = 1;
            }

            $totalAmount = $booking->daily_rate * $days;
            $taxAmount = $totalAmount * 0.10;
            $finalAmount = $totalAmount + $taxAmount;

            $booking->update([
                'pickup_location' => $validated['pickup_location'],
                'dropoff_location' => $validated['dropoff_location'],
                'pickup_date' => $pickupDate,
                'return_date' => $returnDate,
                'days' => $days,
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'final_amount' => $finalAmount,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'] ?? null,
                'special_requirements' => $validated['special_requirements'] ?? null,
            ]);

            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Booking updated successfully!');

        } catch (\Exception $e) {
            Log::error('Booking update failed: ' . $e->getMessage());
            
            return back()->withErrors(['error' => 'Failed to update booking. Please try again.'])->withInput();
        }
    }

    /**
     * Remove the specified booking from storage.
     */
    public function destroy(Booking $booking)
    {
        // Ensure user can only delete their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to booking.');
        }
        
        // Only allow deleting of pending bookings
        if ($booking->status !== 'pending') {
            return redirect()->route('bookings.index')
                ->with('error', 'Only pending bookings can be deleted.');
        }

        try {
            $booking->delete();
            
            return redirect()->route('bookings.index')
                ->with('success', 'Booking deleted successfully!');
                
        } catch (\Exception $e) {
            Log::error('Booking deletion failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to delete booking. Please try again.');
        }
    }

    /**
     * Cancel a booking.
     */
    public function cancel(Booking $booking)
    {
        // Ensure user can only cancel their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to booking.');
        }
        
        if ($booking->status === 'cancelled' || $booking->status === 'completed') {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        try {
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);
            
            // Make car available again when booking is cancelled
            $booking->car->update([
                'is_available' => true
            ]);
            
            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Booking cancelled successfully! The car is now available again.');
                
        } catch (\Exception $e) {
            Log::error('Booking cancellation failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to cancel booking. Please try again.');
        }
    }

    /**
     * Process payment for a booking.
     */
    public function payment(Request $request, Booking $booking)
    {
        // Ensure user can only pay for their own bookings
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to booking.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:credit_card,debit_card,cash,bkash,nagad,rocket,upay',
            'transaction_id' => 'nullable|string|max:255',
        ]);

        // Require transaction ID for mobile banking only
        if (in_array($validated['payment_method'], ['bkash', 'nagad', 'rocket', 'upay'])) {
            $request->validate([
                'transaction_id' => 'required|string|max:255',
            ]);
        }

        try {
            $booking->update([
                'payment_status' => 'paid',
                'payment_method' => $validated['payment_method'],
                'transaction_id' => $validated['transaction_id'] ?? null,
                'status' => 'confirmed',
                'confirmed_at' => now(),
            ]);
            
            // Mark car as unavailable when booking is confirmed
            $booking->car->update([
                'is_available' => false
            ]);
            
            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Payment processed successfully! Your booking is now confirmed.');
                
        } catch (\Exception $e) {
            Log::error('Payment processing failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to process payment. Please try again.');
        }
    }

    /**
     * Generate receipt for a booking.
     */
    public function receipt(Booking $booking)
    {
        // Ensure user can only view their own booking receipts
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to booking.');
        }
        
        $booking->load('car', 'user');
        
        return view('bookings.receipt', compact('booking'));
    }

    /**
     * Get booking summary for AJAX requests.
     */
    public function getSummary(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'pickup_date' => 'required|date',
            'return_date' => 'required|date|after:pickup_date',
            'extras' => 'nullable|array',
        ]);

        try {
            $car = Car::findOrFail($validated['car_id']);
            
            $pickupDate = Carbon::parse($validated['pickup_date']);
            $returnDate = Carbon::parse($validated['return_date']);
            $days = $pickupDate->diffInDays($returnDate);
            
            if ($days < 1) {
                $days = 1;
            }

            $dailyRate = $car->price_per_day;
            $totalAmount = $dailyRate * $days;
            $taxAmount = $totalAmount * 0.10;
            
            // Calculate extras
            $extrasAmount = 0;
            $extrasDetails = [];
            
            if (!empty($validated['extras'])) {
                $extrasCost = [
                    'gps' => 5,
                    'child_seat' => 10,
                    'insurance' => 15,
                    'wifi' => 8,
                    'driver' => 50,
                ];
                
                foreach ($validated['extras'] as $extra) {
                    if (isset($extrasCost[$extra])) {
                        $cost = $extrasCost[$extra] * $days;
                        $extrasAmount += $cost;
                        $extrasDetails[$extra] = $cost;
                    }
                }
            }
            
            $finalAmount = $totalAmount + $taxAmount + $extrasAmount;

            return response()->json([
                'success' => true,
                'summary' => [
                    'days' => $days,
                    'daily_rate' => number_format($dailyRate, 2),
                    'subtotal' => number_format($totalAmount, 2),
                    'tax' => number_format($taxAmount, 2),
                    'extras' => number_format($extrasAmount, 2),
                    'extras_details' => $extrasDetails,
                    'total' => number_format($finalAmount, 2),
                    'car_name' => $car->brand . ' ' . $car->model,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate booking summary.'
            ], 500);
        }
    }
}
