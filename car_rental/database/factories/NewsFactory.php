<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'industry_news',
            'electric_vehicles',
            'car_reviews',
            'maintenance_tips',
            'rental_guides',
            'technology',
            'safety'
        ];

        $title = $this->generateCarRelatedTitle();
        
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1, 10000),
            'excerpt' => $this->faker->paragraph(2),
            'content' => $this->generateContent(),
            'category' => $this->faker->randomElement($categories),
            'author_id' => User::inRandomOrder()->first()?->id ?? 1,
            'published_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'status' => $this->faker->randomElement(['published', 'published', 'published', 'draft']), // 75% published
            'is_featured' => $this->faker->boolean(20), // 20% featured
            'views_count' => $this->faker->numberBetween(0, 10000),
            'likes_count' => $this->faker->numberBetween(0, 500),
            'comments_count' => $this->faker->numberBetween(0, 100),
            'meta_title' => $title,
            'meta_description' => $this->faker->sentence(15),
            'meta_keywords' => implode(', ', $this->faker->words(5)),
            'external_source' => $this->faker->optional(0.3)->randomElement(['Auto News', 'Car Magazine', 'EV Today', 'Motor Trend']),
            'external_url' => $this->faker->optional(0.3)->url(),
            'featured_image' => 'images/news/pic-blog-' . $this->faker->numberBetween(1, 6) . '.jpg',
        ];
    }

    /**
     * Generate car-related news titles
     *
     * @return string
     */
    private function generateCarRelatedTitle(): string
    {
        $templates = [
            'The Future of {carType}: What to Expect in {year}',
            'Top {number} {carType} Models for {season}',
            '{brand} Announces New {carType} with Revolutionary Features',
            'Electric Vehicles: How {brand} is Leading the Charge',
            'Car Rental Tips: Getting the Best Deal on {carType}',
            'Maintenance Guide: Keeping Your {carType} in Top Shape',
            'Safety First: New {feature} Technology in Modern Cars',
            'Comparing {brand} vs {brand2}: Which is Better?',
            'The Rise of {trend} in the Automotive Industry',
            'How to Choose the Perfect {carType} for Your Needs',
            '{brand} Unveils Game-Changing {feature}',
            'Road Test: {year} {brand} {model} Review',
            'Electric vs Hybrid: Making the Right Choice',
            'Car Rental Insurance: Everything You Need to Know',
            'Best Family Cars for {year}: Top Picks',
        ];

        $carTypes = ['SUV', 'Sedan', 'Electric Vehicle', 'Hybrid', 'Sports Car', 'Luxury Car', 'Compact Car', 'Crossover'];
        $brands = ['Tesla', 'BMW', 'Mercedes', 'Toyota', 'Ford', 'Honda', 'Audi', 'Volkswagen', 'Nissan', 'Chevrolet'];
        $features = ['Autonomous Driving', 'Battery Technology', 'Safety System', 'Infotainment', 'Performance Enhancement'];
        $trends = ['Electrification', 'Autonomous Driving', 'Connectivity', 'Sustainability', 'Shared Mobility'];
        $seasons = ['Spring', 'Summer', 'Fall', 'Winter', '2025', '2026'];

        $template = $this->faker->randomElement($templates);
        
        return str_replace(
            ['{carType}', '{brand}', '{brand2}', '{year}', '{number}', '{season}', '{feature}', '{trend}', '{model}'],
            [
                $this->faker->randomElement($carTypes),
                $this->faker->randomElement($brands),
                $this->faker->randomElement($brands),
                $this->faker->numberBetween(2024, 2026),
                $this->faker->numberBetween(5, 15),
                $this->faker->randomElement($seasons),
                $this->faker->randomElement($features),
                $this->faker->randomElement($trends),
                $this->faker->word()
            ],
            $template
        );
    }

    /**
     * Generate realistic article content
     *
     * @return string
     */
    private function generateContent(): string
    {
        $paragraphs = $this->faker->numberBetween(5, 12);
        $content = '';
        
        for ($i = 0; $i < $paragraphs; $i++) {
            $content .= '<p>' . $this->faker->paragraph($this->faker->numberBetween(4, 8)) . '</p>';
            
            // Add headings occasionally
            if ($i > 0 && $i % 3 === 0 && $i < $paragraphs - 1) {
                $content .= '<h3>' . $this->faker->sentence(4) . '</h3>';
            }
            
            // Add a list occasionally
            if ($i === intval($paragraphs / 2)) {
                $content .= '<ul>';
                for ($j = 0; $j < $this->faker->numberBetween(3, 5); $j++) {
                    $content .= '<li>' . $this->faker->sentence() . '</li>';
                }
                $content .= '</ul>';
            }
        }
        
        return $content;
    }

    /**
     * Indicate that the news article is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    /**
     * Indicate that the news article is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the news article is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    /**
     * Create an external news article
     */
    public function external(): static
    {
        return $this->state(fn (array $attributes) => [
            'external_source' => $this->faker->randomElement(['Auto News', 'Car Magazine', 'EV Today', 'Motor Trend', 'Automotive Weekly']),
            'external_url' => $this->faker->url(),
        ]);
    }

    /**
     * Create a specific category article
     */
    public function category(string $category): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => $category,
        ]);
    }
}
