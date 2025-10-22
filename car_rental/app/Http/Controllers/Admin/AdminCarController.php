<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCarController extends Controller
{
    /**
     * Display a listing of the cars.
     */
    public function index(Request $request)
    {
        $query = Car::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('make', 'like', '%' . $search . '%')
                  ->orWhere('model', 'like', '%' . $search . '%')
                  ->orWhere('year', 'like', '%' . $search . '%')
                  ->orWhere('license_plate', 'like', '%' . $search . '%');
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by availability
        if ($request->filled('available')) {
            $query->where('is_available', $request->available);
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        switch ($sort) {
            case 'make':
                $query->orderBy('make')->orderBy('model');
                break;
            case 'daily_rate':
                $query->orderBy('daily_rate', 'asc');
                break;
            case 'daily_rate_desc':
                $query->orderBy('daily_rate', 'desc');
                break;
            case 'year':
                $query->orderBy('year', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $cars = $query->paginate(15);
        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new car.
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Store a newly created car in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'type' => 'required|in:economy,compact,standard,intermediate,full_size,premium,luxury,suv,minivan,convertible,sports_car,truck,van,exotic',
            'fuel_type' => 'required|in:petrol,diesel,hybrid,electric,lpg',
            'transmission' => 'required|in:manual,automatic,cvt',
            'seats' => 'required|integer|min:1|max:50',
            'doors' => 'required|integer|min:1|max:10',
            'luggage_capacity' => 'nullable|string|max:255',
            'daily_rate' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|string',
            'description' => 'nullable|string',
            'is_available' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/cars'), $imageName);
            $validated['image'] = $imageName;
        }

        // Convert features from comma-separated string to array
        if (isset($validated['features'])) {
            $validated['features'] = array_map('trim', explode(',', $validated['features']));
        }

        // Set defaults
        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');

        Car::create($validated);

        return redirect()->route('admin.cars.index')->with('success', 'Car added successfully!');
    }

    /**
     * Display the specified car.
     */
    public function show(Car $car)
    {
        return response()->json($car);
    }

    /**
     * Show the form for editing the specified car.
     */
    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Update the specified car in storage.
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'type' => 'required|in:economy,compact,standard,intermediate,full_size,premium,luxury,suv,minivan,convertible,sports_car,truck,van,exotic',
            'fuel_type' => 'required|in:petrol,diesel,hybrid,electric,lpg',
            'transmission' => 'required|in:manual,automatic,cvt',
            'seats' => 'required|integer|min:1|max:50',
            'doors' => 'required|integer|min:1|max:10',
            'luggage_capacity' => 'nullable|string|max:255',
            'daily_rate' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|string',
            'description' => 'nullable|string',
            'is_available' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($car->image && file_exists(public_path('images/cars/' . $car->image))) {
                unlink(public_path('images/cars/' . $car->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/cars'), $imageName);
            $validated['image'] = $imageName;
        }

        // Convert features from comma-separated string to array
        if (isset($validated['features'])) {
            $validated['features'] = array_map('trim', explode(',', $validated['features']));
        }

        // Set boolean values
        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');

        $car->update($validated);

        return redirect()->route('admin.cars.index')->with('success', 'Car updated successfully!');
    }

    /**
     * Remove the specified car from storage.
     */
    public function destroy(Car $car)
    {
        // Delete image if exists
        if ($car->image && file_exists(public_path('images/cars/' . $car->image))) {
            unlink(public_path('images/cars/' . $car->image));
        }

        $car->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Car deleted successfully!'
            ]);
        }

        return redirect()->route('admin.cars.index')->with('success', 'Car deleted successfully!');
    }

    /**
     * Toggle car availability status.
     */
    public function toggleAvailability(Car $car)
    {
        $car->is_available = !$car->is_available;
        $car->save();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Car availability updated successfully!',
                'is_available' => $car->is_available
            ]);
        }

        return redirect()->back()->with('success', 'Car availability updated successfully!');
    }
}
