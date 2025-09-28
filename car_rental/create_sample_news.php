<?php

use App\Models\News;
use App\Models\User;

// Create a user if none exists
$user = User::first();
if (!$user) {
    $user = User::create([
        'name' => 'Admin',
        'email' => 'admin@caravel.com',
        'password' => bcrypt('password')
    ]);
}

// Create sample news articles
$articles = [
    [
        'title' => 'Best Travel Tips for 2025',
        'slug' => 'best-travel-tips-2025',
        'content' => '<p>Planning your travels for 2025? Here are the essential tips that will make your journey memorable and hassle-free. From booking the perfect rental car to discovering hidden gems, we\'ve got you covered.</p><p>Start by researching your destination thoroughly and book your accommodations and car rentals well in advance to get the best deals.</p>',
        'excerpt' => 'Discover the best travel tips for your next adventure in 2025.',
        'category' => 'travel',
        'author_id' => $user->id,
        'is_published' => true,
        'is_featured' => true,
        'published_at' => now()->subDays(2)
    ],
    [
        'title' => 'The Future of Car Rental Industry',
        'slug' => 'future-car-rental-industry',
        'content' => '<p>The car rental industry is evolving rapidly with new technologies and changing customer expectations. Electric vehicles, mobile apps, and contactless rentals are shaping the future.</p><p>Companies are investing heavily in sustainable practices and digital transformation to meet the demands of modern travelers.</p>',
        'excerpt' => 'Explore how technology is transforming the car rental industry.',
        'category' => 'industry',
        'author_id' => $user->id,
        'is_published' => true,
        'published_at' => now()->subDays(5)
    ],
    [
        'title' => 'Top 10 Road Trip Destinations',
        'slug' => 'top-10-road-trip-destinations',
        'content' => '<p>Embark on an unforgettable journey to these amazing road trip destinations. From scenic coastal drives to mountain adventures, these routes offer breathtaking views and memorable experiences.</p><p>Each destination offers unique attractions, local cuisine, and cultural experiences that will enrich your travel memories.</p>',
        'excerpt' => 'Discover the most scenic and exciting road trip destinations.',
        'category' => 'destinations',
        'author_id' => $user->id,
        'is_published' => true,
        'is_featured' => true,
        'published_at' => now()->subDays(7)
    ],
    [
        'title' => 'Budget Travel Guide 2025',
        'slug' => 'budget-travel-guide-2025',
        'content' => '<p>Traveling on a budget doesn\'t mean compromising on experiences. Learn how to find affordable car rentals, accommodation, and activities while still enjoying amazing adventures.</p><p>With proper planning and smart choices, you can explore the world without breaking the bank.</p>',
        'excerpt' => 'Learn how to travel more while spending less with our budget guide.',
        'category' => 'guides',
        'author_id' => $user->id,
        'is_published' => true,
        'published_at' => now()->subDays(10)
    ],
    [
        'title' => 'Car Rental Safety Tips',
        'slug' => 'car-rental-safety-tips',
        'content' => '<p>Safety should always be your top priority when renting a car. Follow these essential tips to ensure a safe and worry-free rental experience.</p><p>From inspecting the vehicle to understanding insurance coverage, these guidelines will help protect you throughout your journey.</p>',
        'excerpt' => 'Essential safety tips for a worry-free car rental experience.',
        'category' => 'car-rental',
        'author_id' => $user->id,
        'is_published' => true,
        'published_at' => now()->subDays(12)
    ],
    [
        'title' => 'Luxury Car Rental Experience',
        'slug' => 'luxury-car-rental-experience',
        'content' => '<p>Elevate your travel experience with luxury car rentals. Discover premium vehicles that offer comfort, style, and advanced features for an unforgettable journey.</p><p>Whether it\'s for a special occasion or business trip, luxury rentals provide the perfect combination of performance and elegance.</p>',
        'excerpt' => 'Experience luxury and comfort with premium car rental options.',
        'category' => 'reviews',
        'author_id' => $user->id,
        'is_published' => true,
        'published_at' => now()->subDays(15)
    ]
];

foreach ($articles as $articleData) {
    News::updateOrCreate(
        ['slug' => $articleData['slug']],
        $articleData
    );
}

echo "Sample news articles created successfully!\n";
echo "Created " . count($articles) . " articles.\n";