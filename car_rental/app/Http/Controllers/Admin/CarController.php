<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request)
    {
        $query = Car::query();

        // Search by make or model
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('make', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by availability
        if ($request->filled('availability')) {
            $query->where('available', $request->availability === 'available');
        }

        $cars = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.cars.index', compact('cars'));
    }

    public function show(Car $car)
    {
        $car->load(['bookings.user']);
        return view('admin.cars.show', compact('car'));
    }

    public function create()
    {
        return view('admin.cars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'type' => 'required|string',
            'daily_rate' => 'required|numeric|min:0',
            'weekly_rate' => 'nullable|numeric|min:0',
            'monthly_rate' => 'nullable|numeric|min:0',
            'location' => 'required|string',
            'transmission' => 'required|in:automatic,manual',
            'fuel_type' => 'required|in:gasoline,diesel,hybrid,electric',
            'seats' => 'required|integer|min:1|max:50',
            'doors' => 'required|integer|min:1|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
            $data['image'] = '/storage/' . $imagePath;
        }

        Car::create($data);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car created successfully');
    }

    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'type' => 'required|string',
            'daily_rate' => 'required|numeric|min:0',
            'weekly_rate' => 'nullable|numeric|min:0',
            'monthly_rate' => 'nullable|numeric|min:0',
            'location' => 'required|string',
            'transmission' => 'required|in:automatic,manual',
            'fuel_type' => 'required|in:gasoline,diesel,hybrid,electric',
            'seats' => 'required|integer|min:1|max:50',
            'doors' => 'required|integer|min:1|max:10',
            'available' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($car->image && Storage::disk('public')->exists(str_replace('/storage/', '', $car->image))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $car->image));
            }

            $imagePath = $request->file('image')->store('cars', 'public');
            $data['image'] = '/storage/' . $imagePath;
        }

        $car->update($data);

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car updated successfully');
    }

    public function destroy(Car $car)
    {
        // Check if car has active bookings
        $activeBookings = $car->bookings()->whereIn('status', ['pending', 'confirmed', 'in_progress'])->count();
        
        if ($activeBookings > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete car with active bookings');
        }

        // Delete image
        if ($car->image && Storage::disk('public')->exists(str_replace('/storage/', '', $car->image))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $car->image));
        }

        $car->delete();

        return redirect()->route('admin.cars.index')
            ->with('success', 'Car deleted successfully');
    }
}