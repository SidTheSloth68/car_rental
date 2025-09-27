<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Get featured cars from database
        $featuredCars = Car::featured()
            ->available()
            ->take(6)
            ->get()
            ->map(function ($car) {
                return [
                    'id' => $car->id,
                    'name' => $car->full_name,
                    'image' => $car->image,
                    'price' => $car->daily_rate,
                    'likes' => $car->likes_count,
                    'seats' => $car->seats,
                    'luggage' => $car->luggage_capacity,
                    'doors' => $car->doors,
                    'fuel' => ucfirst($car->fuel_type),
                    'type' => ucwords(str_replace('_', ' ', $car->type)),
                    'rating' => $car->average_rating
                ];
            });

        // Sample news data
        $latestNews = [
            [
                'title' => '5 Tips for Your First Car Rental',
                'image' => 'pic-blog-1.jpg',
                'category' => 'Tips',
                'date' => '25 Jan 2022',
                'excerpt' => 'Essential tips to make your first car rental experience smooth and enjoyable.'
            ],
            [
                'title' => 'Best Cars for Road Trips',
                'image' => 'pic-blog-2.jpg',
                'category' => 'Travel',
                'date' => '20 Jan 2022',
                'excerpt' => 'Discover the perfect vehicles for your next adventure on the road.'
            ],
            [
                'title' => 'Electric vs Hybrid: Which to Choose?',
                'image' => 'pic-blog-3.jpg',
                'category' => 'Guide',
                'date' => '15 Jan 2022',
                'excerpt' => 'Compare electric and hybrid vehicles to make the best choice for your needs.'
            ]
        ];

        // Sample testimonials data
        $testimonials = [
            [
                'name' => 'Jason Statham',
                'title' => 'Excellent Service',
                'quote' => 'I have been using Caravel for my car rental needs for over 5 years now. I have never had any problems and their customer service is excellent.',
                'image' => '1.jpg'
            ],
            [
                'name' => 'Sarah Johnson',
                'title' => 'Great Experience',
                'quote' => 'Amazing selection of vehicles and very professional staff. The booking process was smooth and hassle-free.',
                'image' => '2.jpg'
            ],
            [
                'name' => 'Mike Chen',
                'title' => 'Highly Recommended',
                'quote' => 'Fantastic service and competitive prices. The car was in perfect condition and exactly what I needed for my business trip.',
                'image' => '3.jpg'
            ]
        ];

        // Sample FAQ data
        $faqs = collect([
            [
                'question' => 'What is the minimum age requirement for renting a car?',
                'answer' => 'The minimum age for renting a car is typically 21 years old. However, additional fees may apply for drivers under 25.'
            ],
            [
                'question' => 'Do I need a credit card to rent a car?',
                'answer' => 'Yes, a valid credit card in the main driver\'s name is required for all car rentals for security deposit purposes.'
            ],
            [
                'question' => 'What documents do I need to rent a car?',
                'answer' => 'You need a valid driver\'s license, credit card, and a form of identification such as a passport or national ID.'
            ],
            [
                'question' => 'Can I cancel my reservation?',
                'answer' => 'Yes, you can cancel your reservation. Cancellation policies vary depending on the rental package and timing.'
            ],
            [
                'question' => 'Is insurance included in the rental price?',
                'answer' => 'Basic insurance is included, but you can upgrade to comprehensive coverage for additional protection.'
            ],
            [
                'question' => 'Can I return the car to a different location?',
                'answer' => 'Yes, we offer one-way rentals. Additional fees may apply depending on the drop-off location.'
            ]
        ]);
        
        $data = [
            'pageTitle' => 'Home - Caravel Car Rental',
            'pageDescription' => 'Welcome to Caravel - Premium car rental service with luxury and economy vehicles',
            'metaKeywords' => 'car rental, luxury cars, economy cars, vehicle rental, caravel',
            'featuredCars' => $featuredCars,
            'latestNews' => $latestNews,
            'testimonials' => $testimonials,
            'faqs' => $faqs
        ];

        return view('home', $data);
    }

    /**
     * Show the car search results.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function search(Request $request)
    {
        // Handle car search functionality
        // This will be expanded in later commits
        
        return redirect()->route('home')->with('message', 'Search functionality will be implemented soon!');
    }

    /**
     * Handle car search requests (placeholder implementation)
     */
    public function searchCars(Request $request)
    {
        // Validate the search form inputs
        $request->validate([
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'pickup_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:pickup_date',
            'car_type' => 'nullable|string|in:economy,compact,standard,suv,luxury,convertible',
            'price_range' => 'nullable|string|in:0-50,50-100,100-200,200+',
        ]);

        // For now, redirect back with a success message
        // Car search functionality will be implemented in future commits
        return redirect()->back()->with('success', 'Car search functionality will be implemented in upcoming commits. Your search criteria have been saved.');
    }
}