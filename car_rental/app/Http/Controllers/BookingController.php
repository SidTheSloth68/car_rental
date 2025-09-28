<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'create', 'quickBooking']);
    }

    /**
     * Display a listing of the user's bookings.
     */
    public function index()
    {
        $user = Auth::user();
        
        $bookings = Booking::with(['car'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(Request $request)
    {
        $carId = $request->get('car_id');
        $car = null;
        
        if ($carId) {
            $car = Car::findOrFail($carId);
        }

        // Get pre-filled form data from session or request
        $formData = [
            'pickup_location' => $request->get('pickup_location', ''),
            'dropoff_location' => $request->get('dropoff_location', ''),
            'pickup_date' => $request->get('pickup_date', ''),
            'return_date' => $request->get('return_date', ''),
        ];

        return view('bookings.create', compact('car', 'formData'));
    }

    /**
     * Show the quick booking form.
     */
    public function quickBooking()
    {
        $cars = Car::available()
                   ->select('id', 'make', 'model', 'year', 'daily_rate', 'image')
                   ->orderBy('make')
                   ->orderBy('model')
                   ->get();

        return view('bookings.quick', compact('cars'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'sometimes|exists:cars,id',
            'car_type' => 'sometimes|string|in:economy,compact,standard,intermediate,full_size,premium,luxury,suv,minivan,convertible,sports_car,truck,van,exotic',
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
            'notes' => 'nullable|string|max:1000',
            'terms' => 'required|accepted',
        ]);

        try {
            DB::beginTransaction();

            // Handle both specific car booking and car type booking
            $car = null;
            $carId = null;
            
            if ($request->has('car_id') && $request->car_id) {
                // Specific car selected
                $car = Car::findOrFail($request->car_id);
                $carId = $car->id;
            } elseif ($request->has('car_type')) {
                // Car type selected - find available car of that type
                $car = Car::available()
                    ->where('type', $request->car_type)
                    ->first();
                    
                if (!$car) {
                    return back()->withInput()
                        ->with('error', 'No available cars of the selected type for your dates.');
                }
                $carId = $car->id;
            } else {
                return back()->withInput()
                    ->with('error', 'Please select a car or car type.');
            }
            
            // Calculate booking details
            $pickupDate = Carbon::parse($request->pickup_date . ' ' . $request->pickup_time);
            $returnDate = Carbon::parse($request->return_date . ' ' . $request->return_time);
            $days = max(1, $pickupDate->diffInDays($returnDate));
            
            $dailyRate = $car->daily_rate ?? 100; // Default rate if not set
            $totalAmount = $dailyRate * $days;
            $taxAmount = $totalAmount * 0.10; // 10% tax
            $discountAmount = 0; // No discount for now
            $finalAmount = $totalAmount + $taxAmount - $discountAmount;

            // Create booking
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'car_id' => $carId,
                'booking_number' => Booking::generateBookingNumber(),
                'pickup_location' => $request->pickup_location,
                'dropoff_location' => $request->dropoff_location,
                'pickup_date' => $pickupDate,
                'return_date' => $returnDate,
                'days' => $days,
                'daily_rate' => $dailyRate,
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'final_amount' => $finalAmount,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'license_number' => $request->license_number,
                'notes' => $request->notes,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Booking created successfully! Your booking number is ' . $booking->booking_number);

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->withInput()
                ->with('error', 'There was an error creating your booking. Please try again.');
        }
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        // Load relationships
        $booking->load(['car', 'user']);
        
        // Check if user can view this booking
        if (Auth::check() && Auth::id() !== $booking->user_id) {
            abort(403, 'Unauthorized access to booking details.');
        }

        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking)
    {
        // Check if user owns this booking
        if (Auth::id() !== $booking->user_id) {
            abort(403, 'Unauthorized access to booking.');
        }

        // Only allow editing of pending bookings
        if ($booking->status !== 'pending') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Only pending bookings can be edited.');
        }

        $booking->load(['car']);
        
        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified booking in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        // Check if user owns this booking
        if (Auth::id() !== $booking->user_id) {
            abort(403, 'Unauthorized access to booking.');
        }

        // Only allow updating of pending bookings
        if ($booking->status !== 'pending') {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'Only pending bookings can be updated.');
        }

        $request->validate([
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'pickup_date' => 'required|date|after:today',
            'return_date' => 'required|date|after:pickup_date',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string',
            'special_requirements' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Recalculate booking details
            $pickupDate = Carbon::parse($request->pickup_date);
            $returnDate = Carbon::parse($request->return_date);
            $days = max(1, $pickupDate->diffInDays($returnDate));
            
            $totalAmount = $booking->daily_rate * $days;
            $taxAmount = $totalAmount * 0.10; // 10% tax
            $finalAmount = $totalAmount + $taxAmount - $booking->discount_amount;

            // Update booking
            $booking->update([
                'pickup_location' => $request->pickup_location,
                'dropoff_location' => $request->dropoff_location,
                'pickup_date' => $pickupDate,
                'return_date' => $returnDate,
                'days' => $days,
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'final_amount' => $finalAmount,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'special_requirements' => $request->special_requirements,
            ]);

            DB::commit();

            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Booking updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            
            return back()->withInput()
                ->with('error', 'There was an error updating your booking. Please try again.');
        }
    }

    /**
     * Cancel the specified booking.
     */
    public function cancel(Booking $booking)
    {
        // Check if user owns this booking
        if (Auth::id() !== $booking->user_id) {
            abort(403, 'Unauthorized access to booking.');
        }

        // Only allow cancellation of pending or confirmed bookings
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'This booking cannot be cancelled.');
        }

        try {
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

            return redirect()->route('bookings.show', $booking)
                ->with('success', 'Booking has been cancelled successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'There was an error cancelling your booking. Please try again.');
        }
    }

    /**
     * Get booking summary for AJAX requests.
     */
    public function getSummary(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'pickup_date' => 'required|date',
            'return_date' => 'required|date|after:pickup_date',
        ]);

        $car = Car::findOrFail($request->car_id);
        $pickupDate = Carbon::parse($request->pickup_date);
        $returnDate = Carbon::parse($request->return_date);
        $days = max(1, $pickupDate->diffInDays($returnDate));
        
        $dailyRate = $car->daily_rate ?? 100;
        $totalAmount = $dailyRate * $days;
        $taxAmount = $totalAmount * 0.10;
        $finalAmount = $totalAmount + $taxAmount;

        return response()->json([
            'days' => $days,
            'daily_rate' => number_format($dailyRate, 2),
            'total_amount' => number_format($totalAmount, 2),
            'tax_amount' => number_format($taxAmount, 2),
            'final_amount' => number_format($finalAmount, 2),
        ]);
    }
}
