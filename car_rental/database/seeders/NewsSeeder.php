<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\User;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a random user for author assignment
        $authors = User::where('role', 'admin')->get();
        if ($authors->isEmpty()) {
            $authors = User::take(3)->get();
        }

        $newsArticles = [
            [
                'title' => 'Top 10 Electric Cars for Rental in 2024',
                'slug' => 'top-10-electric-cars-rental-2024',
                'excerpt' => 'Discover the best electric vehicles available for rental this year. From Tesla to BMW, find the perfect eco-friendly ride for your next trip.',
                'content' => '<p>The electric vehicle revolution is here, and car rental companies are embracing the change. With increasing environmental awareness and technological advancements, electric cars have become more popular than ever for rentals.</p>

                <h3>1. Tesla Model 3</h3>
                <p>The Tesla Model 3 continues to be the most popular electric rental car. With its impressive range of up to 358 miles and cutting-edge autopilot features, it\'s perfect for both business and leisure travelers.</p>

                <h3>2. BMW iX</h3>
                <p>BMW\'s flagship electric SUV offers luxury and performance. With a range of up to 324 miles and premium interior, it\'s ideal for family trips and special occasions.</p>

                <h3>3. Audi e-tron GT</h3>
                <p>For those seeking performance and style, the Audi e-tron GT delivers with 469 horsepower and stunning design. Perfect for making a statement on your next rental.</p>

                <p>When choosing an electric rental car, consider factors like range, charging infrastructure, and your specific travel needs. Most modern electric vehicles offer sufficient range for daily use and road trips.</p>',
                'featured_image' => 'news/electric-cars-2024.jpg',
                'images' => json_encode([
                    'news/tesla-model3-rental.jpg',
                    'news/bmw-ix-interior.jpg',
                    'news/audi-etron-gt-charging.jpg'
                ]),
                'category' => 'Electric Vehicles',
                'tags' => json_encode(['electric cars', 'rental', 'Tesla', 'BMW', 'Audi', 'eco-friendly']),
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'author_id' => $authors->random()->id,
                'views_count' => 1250,
                'likes_count' => 89,
                'comments_count' => 23,
                'meta_title' => 'Best Electric Cars for Rental 2024 | Rentaly Guide',
                'meta_description' => 'Discover the top 10 electric cars available for rental in 2024. Compare Tesla, BMW, Audi and more eco-friendly vehicles.',
                'reading_time' => 8,
                'is_featured' => true,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'title' => 'How to Choose the Perfect Car for Your Road Trip',
                'slug' => 'choose-perfect-car-road-trip',
                'excerpt' => 'Planning a road trip? Learn how to select the ideal rental car based on your destination, group size, and travel preferences.',
                'content' => '<p>Choosing the right car for your road trip can make or break your adventure. Whether you\'re planning a cross-country journey or a weekend getaway, the vehicle you select should match your specific needs and enhance your travel experience.</p>

                <h3>Consider Your Group Size</h3>
                <p>The number of passengers and amount of luggage you\'ll have are crucial factors. For solo travelers or couples, a compact or economy car might suffice. Families or groups of friends should consider SUVs or minivans for comfort and storage space.</p>

                <h3>Think About Your Route</h3>
                <p>Mountain roads require different vehicles than highway cruising. If you\'re tackling challenging terrain, consider an SUV with all-wheel drive. For long highway stretches, prioritize comfort features and fuel efficiency.</p>

                <h3>Fuel Efficiency Matters</h3>
                <p>With gas prices fluctuating, fuel efficiency can significantly impact your travel budget. Hybrid vehicles offer excellent mileage, while smaller engines typically consume less fuel.</p>

                <h3>Comfort Features</h3>
                <p>Long drives demand comfort. Look for cars with good lumbar support, climate control, cruise control, and entertainment systems. These features can make hours on the road much more enjoyable.</p>

                <p>Remember to book your rental car well in advance, especially during peak travel seasons. Compare prices from multiple providers and read the fine print regarding insurance and mileage limits.</p>',
                'featured_image' => 'news/road-trip-car-selection.jpg',
                'images' => json_encode([
                    'news/family-suv-roadtrip.jpg',
                    'news/compact-car-highway.jpg',
                    'news/luggage-space-comparison.jpg'
                ]),
                'category' => 'Travel Tips',
                'tags' => json_encode(['road trip', 'car selection', 'travel tips', 'rental guide', 'SUV', 'compact cars']),
                'status' => 'published',
                'published_at' => now()->subDays(12),
                'author_id' => $authors->random()->id,
                'views_count' => 890,
                'likes_count' => 67,
                'comments_count' => 15,
                'meta_title' => 'Road Trip Car Selection Guide | Rentaly Tips',
                'meta_description' => 'Learn how to choose the perfect rental car for your road trip. Expert tips on vehicle selection based on group size and destination.',
                'reading_time' => 6,
                'is_featured' => false,
                'created_at' => now()->subDays(12),
                'updated_at' => now()->subDays(12),
            ],
            [
                'title' => 'Luxury Car Rentals: Experience Premium Driving',
                'slug' => 'luxury-car-rentals-premium-driving',
                'excerpt' => 'Elevate your travel experience with luxury car rentals. From Mercedes-Benz to BMW, discover premium vehicles for special occasions.',
                'content' => '<p>Sometimes, ordinary just won\'t do. Whether you\'re attending a business meeting, celebrating a special occasion, or simply want to treat yourself, luxury car rentals offer an unparalleled driving experience.</p>

                <h3>Mercedes-Benz S-Class</h3>
                <p>The epitome of luxury sedans, the S-Class offers executive-level comfort with cutting-edge technology. Perfect for business travelers who want to make a lasting impression.</p>

                <h3>BMW 7 Series</h3>
                <p>Combining performance with luxury, the BMW 7 Series delivers an engaging driving experience without sacrificing comfort. Ideal for those who enjoy being behind the wheel.</p>

                <h3>Audi A8</h3>
                <p>With its understated elegance and advanced technology, the A8 represents refined luxury. The quattro all-wheel drive system provides confidence in any weather condition.</p>

                <h3>When to Choose Luxury</h3>
                <p>Luxury rentals are perfect for:</p>
                <ul>
                <li>Important business meetings</li>
                <li>Anniversary celebrations</li>
                <li>Airport transfers for VIP clients</li>
                <li>Special date nights</li>
                <li>Wedding transportation</li>
                </ul>

                <p>While luxury cars come at a premium, the experience they provide often justifies the cost. Many rental companies offer package deals for multi-day rentals or special events.</p>',
                'featured_image' => 'news/luxury-car-interior.jpg',
                'images' => json_encode([
                    'news/mercedes-s-class-exterior.jpg',
                    'news/bmw-7-series-dashboard.jpg',
                    'news/audi-a8-rear-seats.jpg'
                ]),
                'category' => 'Luxury Vehicles',
                'tags' => json_encode(['luxury cars', 'Mercedes-Benz', 'BMW', 'Audi', 'premium rental', 'business travel']),
                'status' => 'published',
                'published_at' => now()->subDays(8),
                'author_id' => $authors->random()->id,
                'views_count' => 1560,
                'likes_count' => 124,
                'comments_count' => 31,
                'meta_title' => 'Luxury Car Rentals Guide | Premium Vehicle Experience',
                'meta_description' => 'Discover luxury car rental options. Mercedes-Benz, BMW, Audi and more premium vehicles for special occasions and business travel.',
                'reading_time' => 7,
                'is_featured' => true,
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8),
            ],
            [
                'title' => 'Car Rental Insurance: What You Need to Know',
                'slug' => 'car-rental-insurance-guide',
                'excerpt' => 'Navigate the complex world of car rental insurance. Learn about different coverage options and how to protect yourself while renting.',
                'content' => '<p>Car rental insurance can be confusing, but understanding your options is crucial for protecting yourself and your finances. Here\'s everything you need to know about rental car insurance coverage.</p>

                <h3>Types of Coverage</h3>
                <h4>Collision Damage Waiver (CDW)</h4>
                <p>CDW is not technically insurance but a waiver that releases you from financial responsibility if the rental car is damaged or stolen. This is often the most important coverage to consider.</p>

                <h4>Liability Insurance</h4>
                <p>This covers damage to other vehicles and property, as well as injuries to other people. Most rental companies provide minimum required coverage, but it may not be sufficient.</p>

                <h4>Personal Accident Insurance (PAI)</h4>
                <p>PAI covers medical expenses for you and your passengers in case of an accident. Check if your health insurance already provides this coverage.</p>

                <h3>Do You Need Rental Insurance?</h3>
                <p>Before purchasing rental insurance, check:</p>
                <ul>
                <li>Your personal auto insurance policy</li>
                <li>Credit card benefits</li>
                <li>Travel insurance coverage</li>
                <li>Employer policies for business travel</li>
                </ul>

                <h3>Tips for Saving Money</h3>
                <p>While insurance is important, you don\'t want to pay for duplicate coverage. Review your existing policies and only purchase what you need. Some credit cards offer excellent rental car coverage as a free benefit.</p>

                <p>Remember to document any existing damage before driving off the lot and understand the rental company\'s policies regarding claims and deductibles.</p>',
                'featured_image' => 'news/car-insurance-documents.jpg',
                'images' => json_encode([
                    'news/insurance-checklist.jpg',
                    'news/car-damage-inspection.jpg',
                    'news/rental-agreement-signing.jpg'
                ]),
                'category' => 'Insurance & Legal',
                'tags' => json_encode(['car insurance', 'rental insurance', 'CDW', 'liability', 'travel protection', 'legal tips']),
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'author_id' => $authors->random()->id,
                'views_count' => 2100,
                'likes_count' => 156,
                'comments_count' => 42,
                'meta_title' => 'Car Rental Insurance Guide | Coverage Options Explained',
                'meta_description' => 'Complete guide to car rental insurance. Learn about CDW, liability, and personal accident insurance to protect yourself while renting.',
                'reading_time' => 9,
                'is_featured' => false,
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15),
            ],
            [
                'title' => 'Sustainable Travel: Eco-Friendly Car Rental Options',
                'slug' => 'sustainable-travel-eco-friendly-rentals',
                'excerpt' => 'Reduce your carbon footprint with eco-friendly car rental options. Explore hybrid, electric, and fuel-efficient vehicles for sustainable travel.',
                'content' => '<p>As environmental consciousness grows, more travelers are seeking sustainable transportation options. Car rental companies are responding with a wider selection of eco-friendly vehicles that don\'t compromise on performance or comfort.</p>

                <h3>Electric Vehicles (EVs)</h3>
                <p>Pure electric vehicles produce zero direct emissions and are incredibly quiet. They\'re perfect for city driving and increasingly viable for longer trips as charging infrastructure expands.</p>

                <h4>Popular EV Rentals:</h4>
                <ul>
                <li>Tesla Model 3 and Model Y</li>
                <li>Nissan Leaf</li>
                <li>Chevrolet Bolt</li>
                <li>BMW i3</li>
                </ul>

                <h3>Hybrid Vehicles</h3>
                <p>Hybrids combine electric motors with traditional engines, offering excellent fuel efficiency without range anxiety. They\'re ideal for travelers who want to reduce their environmental impact without worrying about charging.</p>

                <h4>Top Hybrid Rentals:</h4>
                <ul>
                <li>Toyota Prius</li>
                <li>Honda Insight</li>
                <li>Toyota Camry Hybrid</li>
                <li>Lexus ES Hybrid</li>
                </ul>

                <h3>Fuel-Efficient Conventional Cars</h3>
                <p>Even traditional gasoline vehicles have become much more efficient. Compact cars and those with smaller engines can significantly reduce fuel consumption compared to larger vehicles.</p>

                <h3>Planning Your Eco-Friendly Trip</h3>
                <p>When renting an eco-friendly vehicle:</p>
                <ul>
                <li>Research charging stations for EVs</li>
                <li>Plan efficient routes to minimize driving</li>
                <li>Consider public transportation for some segments</li>
                <li>Choose accommodations with green certifications</li>
                </ul>

                <p>Sustainable travel isn\'t just about the car you choose—it\'s about making conscious decisions throughout your journey to minimize environmental impact while still enjoying your trip.</p>',
                'featured_image' => 'news/electric-car-charging.jpg',
                'images' => json_encode([
                    'news/hybrid-car-dashboard.jpg',
                    'news/ev-charging-station.jpg',
                    'news/fuel-efficiency-comparison.jpg'
                ]),
                'category' => 'Sustainability',
                'tags' => json_encode(['electric cars', 'hybrid vehicles', 'sustainable travel', 'eco-friendly', 'green travel', 'environment']),
                'status' => 'published',
                'published_at' => now()->subDays(20),
                'author_id' => $authors->random()->id,
                'views_count' => 1750,
                'likes_count' => 198,
                'comments_count' => 56,
                'meta_title' => 'Eco-Friendly Car Rentals | Sustainable Travel Guide',
                'meta_description' => 'Discover eco-friendly car rental options including electric and hybrid vehicles. Make your travel more sustainable with green transportation choices.',
                'reading_time' => 10,
                'is_featured' => true,
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(20),
            ],
            [
                'title' => 'Business Travel: Maximizing Efficiency with Car Rentals',
                'slug' => 'business-travel-car-rental-efficiency',
                'excerpt' => 'Streamline your business travel with smart car rental strategies. Learn about corporate programs and efficiency tips for business travelers.',
                'content' => '<p>For business travelers, time is money. The right car rental strategy can significantly improve your productivity and travel experience while helping your company manage costs effectively.</p>

                <h3>Corporate Rental Programs</h3>
                <p>Most major rental companies offer corporate programs with benefits like:</p>
                <ul>
                <li>Negotiated rates and discounts</li>
                <li>Expedited pickup and return</li>
                <li>Guaranteed car classes</li>
                <li>Simplified billing and reporting</li>
                <li>24/7 customer support</li>
                </ul>

                <h3>Choosing the Right Vehicle</h3>
                <p>For business travel, consider:</p>
                <ul>
                <li><strong>Sedans:</strong> Professional appearance for client meetings</li>
                <li><strong>Compact cars:</strong> Easy parking in urban areas</li>
                <li><strong>SUVs:</strong> Space for samples or equipment</li>
                <li><strong>Luxury vehicles:</strong> When image matters</li>
                </ul>

                <h3>Technology and Connectivity</h3>
                <p>Modern business travelers need vehicles equipped with:</p>
                <ul>
                <li>Bluetooth connectivity</li>
                <li>USB charging ports</li>
                <li>GPS navigation</li>
                <li>Wi-Fi hotspots (if available)</li>
                <li>Hands-free calling capabilities</li>
                </ul>

                <h3>Time-Saving Tips</h3>
                <ul>
                <li>Join rental loyalty programs for faster service</li>
                <li>Use mobile apps for reservations and modifications</li>
                <li>Choose airport locations for convenience</li>
                <li>Keep preferred rental profiles updated</li>
                <li>Consider one-way rentals for multi-city trips</li>
                </ul>

                <h3>Expense Management</h3>
                <p>Many rental companies integrate with expense management systems, making it easier to track and report business travel costs. Take advantage of detailed receipts and billing summaries for accurate expense reporting.</p>',
                'featured_image' => 'news/business-traveler-airport.jpg',
                'images' => json_encode([
                    'news/luxury-sedan-business.jpg',
                    'news/mobile-rental-app.jpg',
                    'news/car-connectivity-features.jpg'
                ]),
                'category' => 'Business Travel',
                'tags' => json_encode(['business travel', 'corporate rental', 'efficiency', 'productivity', 'expense management', 'professional']),
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'author_id' => $authors->random()->id,
                'views_count' => 980,
                'likes_count' => 72,
                'comments_count' => 18,
                'meta_title' => 'Business Travel Car Rental Guide | Corporate Efficiency Tips',
                'meta_description' => 'Maximize business travel efficiency with smart car rental strategies. Corporate programs, vehicle selection, and time-saving tips.',
                'reading_time' => 7,
                'is_featured' => false,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ]
        ];

        foreach ($newsArticles as $articleData) {
            News::create($articleData);
        }

        // Create additional news articles
        $additionalArticles = [
            'Summer Road Trip Destinations 2024',
            'Car Maintenance Tips for Rental Customers',
            'Understanding Fuel Policies in Car Rentals',
            'Technology Features in Modern Rental Cars',
            'International Car Rental: What to Expect',
            'Family Car Rental: Safety and Comfort Tips',
            'Luxury vs Economy: Choosing Your Rental Category',
            'Airport Car Rental: Streamlining Your Process',
            'One-Way Rentals: Flexibility for Your Journey'
        ];

        foreach ($additionalArticles as $index => $title) {
            $slug = strtolower(str_replace([' ', ':'], ['-', ''], $title));
            
            News::create([
                'title' => $title,
                'slug' => $slug,
                'excerpt' => 'Expert insights and tips for ' . strtolower($title) . '. Get the most out of your car rental experience.',
                'content' => '<p>This is a placeholder article about ' . strtolower($title) . '. The content would be expanded with detailed information, tips, and expert advice.</p>',
                'featured_image' => 'news/placeholder-' . ($index + 1) . '.jpg',
                'category' => ['Travel Tips', 'Car Guides', 'Industry News'][rand(0, 2)],
                'tags' => json_encode(['car rental', 'travel', 'tips']),
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 30)),
                'author_id' => $authors->random()->id,
                'views_count' => rand(100, 1000),
                'likes_count' => rand(10, 100),
                'comments_count' => rand(0, 25),
                'meta_title' => $title . ' | Rentaly Blog',
                'meta_description' => 'Learn about ' . strtolower($title) . ' with expert tips and insights from Rentaly.',
                'reading_time' => rand(3, 8),
                'is_featured' => false,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        $this->command->info('News seeder completed successfully. Created ' . News::count() . ' articles.');
    }
}