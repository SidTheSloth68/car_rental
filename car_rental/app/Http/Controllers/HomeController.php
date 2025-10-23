<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Services\NewsApiService;

class HomeController extends Controller
{
    protected $newsApiService;

    public function __construct(NewsApiService $newsApiService)
    {
        $this->newsApiService = $newsApiService;
    }

    /**
     * Display the homepage.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
       
        $featuredCars = Car::available()
            ->orderBy('created_at', 'desc')
            ->distinct()
            ->take(6)
            ->get()
            ->unique('id')
            ->map(function ($car) {
                return [
                    'id' => $car->id,
                    'name' => $car->full_name,
                    'image' => $car->image,
                    'price' => $car->daily_rate,
                    'likes' => 0, // Removed field
                    'seats' => $car->seats,
                    'luggage' => $car->luggage_capacity,
                    'doors' => $car->doors,
                    'fuel' => ucfirst($car->fuel_type),
                    'type' => ucwords(str_replace('_', ' ', $car->type)),
                    'rating' => 5, 
                    'is_available' => $car->is_available
                ];
            });

     
        $apiResponse = $this->newsApiService->fetchCarNews(3, 1);
        $articles = collect($apiResponse['articles'] ?? []);
        
      
        $latestNews = $articles->take(3)->map(function($article) {
            $transformed = $this->newsApiService->transformArticle($article);
            return [
                'title' => $transformed['title'],
                'slug' => $transformed['slug'],
                'image' => $transformed['image'],
                'category' => $transformed['category'],
                'date' => $transformed['date'],
                'excerpt' => $transformed['excerpt'],
                'external_url' => $transformed['external_url']
            ];
        });

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
}