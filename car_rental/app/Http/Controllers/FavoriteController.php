<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Add a car to user's favorites.
     */
    public function store(Car $car)
    {
        try {
            // Check if already favorited
            if (Auth::user()->hasFavorited($car->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Car is already in your favorites.'
                ], 400);
            }

            // Add to favorites
            Auth::user()->favorites()->attach($car->id);

            return response()->json([
                'success' => true,
                'message' => 'Car added to favorites successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add car to favorites.'
            ], 500);
        }
    }

    /**
     * Remove a car from user's favorites.
     */
    public function destroy(Car $car)
    {
        try {
            // Check if favorited
            if (!Auth::user()->hasFavorited($car->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Car is not in your favorites.'
                ], 400);
            }

            // Remove from favorites
            Auth::user()->favorites()->detach($car->id);

            return response()->json([
                'success' => true,
                'message' => 'Car removed from favorites successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove car from favorites.'
            ], 500);
        }
    }

    /**
     * Display user's favorite cars.
     */
    public function index()
    {
        $favorites = Auth::user()->favorites()
            ->where('is_available', true)
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }
}
