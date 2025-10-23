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

        return view('cars.index', compact('cars'));
    }

    /**
     * Display the specified car
     */
    public function show(Car $car): View
    {
        // Get related cars (same type or make)
        $relatedCars = Car::where('id', '!=', $car->id)
                          ->where(function($query) use ($car) {
                              $query->where('type', $car->type)
                                    ->orWhere('make', $car->make);
                          })
                          ->available()
                          ->limit(4)
                          ->get();

        return view('cars.show', compact('car', 'relatedCars'));
    }
}