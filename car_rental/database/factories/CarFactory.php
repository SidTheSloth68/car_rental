<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Car;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $makes = [
            'Toyota' => ['Camry', 'Corolla', 'RAV4', 'Highlander', 'Prius'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot', 'Insight'],
            'Ford' => ['Focus', 'Fusion', 'Escape', 'Explorer', 'Mustang'],
            'Chevrolet' => ['Cruze', 'Malibu', 'Equinox', 'Tahoe', 'Camaro'],
            'Nissan' => ['Sentra', 'Altima', 'Rogue', 'Pathfinder', 'Maxima'],
            'BMW' => ['3 Series', '5 Series', 'X3', 'X5', 'i3'],
            'Mercedes-Benz' => ['C-Class', 'E-Class', 'GLC', 'GLE', 'A-Class'],
            'Audi' => ['A3', 'A4', 'Q3', 'Q5', 'e-tron'],
            'Volkswagen' => ['Jetta', 'Passat', 'Tiguan', 'Atlas', 'ID.4'],
            'Hyundai' => ['Elantra', 'Sonata', 'Tucson', 'Santa Fe', 'Ioniq'],
            'Kia' => ['Forte', 'Optima', 'Sportage', 'Sorento', 'Niro'],
            'Mazda' => ['Mazda3', 'Mazda6', 'CX-5', 'CX-9', 'MX-5'],
            'Tesla' => ['Model 3', 'Model Y', 'Model S', 'Model X'],
            'Jeep' => ['Compass', 'Cherokee', 'Grand Cherokee', 'Wrangler', 'Renegade'],
            'Subaru' => ['Impreza', 'Legacy', 'Outback', 'Forester', 'Ascent']
        ];

        $make = $this->faker->randomElement(array_keys($makes));
        $model = $this->faker->randomElement($makes[$make]);

        $carTypes = ['sedan', 'suv', 'hatchback', 'coupe', 'convertible', 'wagon', 'pickup', 'minivan'];
        $fuelTypes = ['petrol', 'diesel', 'hybrid', 'electric', 'plug-in-hybrid'];
        $transmissions = ['automatic', 'manual', 'cvt'];
        $colors = ['black', 'white', 'silver', 'gray', 'red', 'blue', 'green', 'yellow', 'brown', 'orange'];
        $locations = ['downtown', 'airport', 'city_center', 'suburban', 'north_branch', 'south_branch'];

        $year = $this->faker->numberBetween(2018, 2024);
        $mileage = $this->faker->numberBetween(5000, 80000);
        $seats = $this->faker->randomElement([2, 4, 5, 7, 8]);
        $doors = $seats <= 2 ? 2 : ($seats <= 5 ? 4 : 4);

        // Calculate base price based on car type and year
        $basePrice = match($this->faker->randomElement($carTypes)) {
            'sedan' => $this->faker->numberBetween(45, 85),
            'suv' => $this->faker->numberBetween(65, 140),
            'hatchback' => $this->faker->numberBetween(35, 65),
            'coupe' => $this->faker->numberBetween(75, 150),
            'convertible' => $this->faker->numberBetween(95, 200),
            'wagon' => $this->faker->numberBetween(55, 95),
            'pickup' => $this->faker->numberBetween(85, 160),
            'minivan' => $this->faker->numberBetween(75, 125),
            default => $this->faker->numberBetween(50, 100)
        };

        // Adjust price for luxury brands
        if (in_array($make, ['BMW', 'Mercedes-Benz', 'Audi', 'Tesla'])) {
            $basePrice *= 1.5;
        }

        // Adjust price for newer cars
        if ($year >= 2022) {
            $basePrice *= 1.2;
        }

        $engineSizes = ['1.0L', '1.2L', '1.4L', '1.5L', '1.6L', '2.0L', '2.4L', '2.5L', '3.0L', '3.5L', '4.0L', '5.0L', 'Electric'];
        $horsepower = $this->faker->numberBetween(120, 500);

        // Generate features array
        $allFeatures = [
            'Air Conditioning',
            'GPS Navigation',
            'Bluetooth',
            'USB Charging Ports',
            'Heated Seats',
            'Leather Seats',
            'Sunroof',
            'Backup Camera',
            'Parking Sensors',
            'Cruise Control',
            'Lane Departure Warning',
            'Blind Spot Monitoring',
            'Automatic Emergency Braking',
            'Adaptive Cruise Control',
            'Apple CarPlay',
            'Android Auto',
            'Wireless Charging',
            'Premium Sound System',
            'All-Wheel Drive',
            'Keyless Entry',
            'Remote Start',
            'Heated Steering Wheel',
            'Memory Seats',
            'Power Liftgate',
            'Roof Rails',
            'Tow Package',
            'Sport Mode',
            'Eco Mode',
            'Ambient Lighting',
            'Dual-Zone Climate Control'
        ];

        $features = $this->faker->randomElements($allFeatures, $this->faker->numberBetween(5, 12));

        // Generate image names
        $imageCount = $this->faker->numberBetween(3, 6);
        $images = [];
        for ($i = 1; $i <= $imageCount; $i++) {
            $images[] = 'cars/' . strtolower(str_replace([' ', '-'], ['_', '_'], $make . '_' . $model)) . '_' . $i . '.jpg';
        }

        return [
            'make' => $make,
            'model' => $model,
            'year' => $year,
            'type' => $this->faker->randomElement($carTypes),
            'fuel_type' => $this->faker->randomElement($fuelTypes),
            'transmission' => $this->faker->randomElement($transmissions),
            'seats' => $seats,
            'doors' => $doors,
            'luggage_capacity' => $this->faker->randomElement(['1 bag', '2 bags', '3 bags', '4 bags', '5+ bags']),
            'daily_rate' => round($basePrice, 2),
            'weekly_rate' => round($basePrice * 6, 2), // 6x daily rate (1 day discount)
            'monthly_rate' => round($basePrice * 24, 2), // 24x daily rate (6 days discount)
            'color' => $this->faker->randomElement($colors),
            'mileage' => $mileage,
            'engine_size' => $this->faker->randomElement($engineSizes),
            'horsepower' => $horsepower,
            'features' => $features,
            'description' => $this->generateCarDescription($make, $model, $year, $features),
            'image' => $images[0] ?? 'cars/default.jpg',
            'images' => json_encode($images),
            'is_available' => $this->faker->boolean(85), // 85% chance of being available
            'is_featured' => $this->faker->boolean(20), // 20% chance of being featured
            'location' => $this->faker->randomElement($locations),
            'rating' => $this->faker->randomFloat(1, 3.5, 5.0),
            'reviews_count' => $this->faker->numberBetween(0, 150),
            'likes_count' => $this->faker->numberBetween(0, 200),
            'average_rating' => $this->faker->randomFloat(1, 3.0, 5.0),
            'total_bookings' => $this->faker->numberBetween(0, 500),
            'license_plate' => $this->generateLicensePlate(),
            'vin' => $this->generateVIN($make),
            'insurance_policy' => 'POL-' . strtoupper(substr($make, 0, 3)) . '-' . $this->faker->randomNumber(6),
            'maintenance_date' => $this->faker->dateTimeBetween('-3 months', '+2 months'),
            'last_service_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'next_service_date' => $this->faker->dateTimeBetween('now', '+3 months'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Generate a car description based on make, model, year, and features.
     */
    private function generateCarDescription(string $make, string $model, int $year, array $features): string
    {
        $descriptions = [
            "The {$year} {$make} {$model} combines style, comfort, and performance in one exceptional package.",
            "Experience the perfect blend of luxury and efficiency with this {$year} {$make} {$model}.",
            "This {$year} {$make} {$model} offers outstanding reliability and advanced technology features.",
            "Enjoy a premium driving experience with the {$year} {$make} {$model}, perfect for any occasion.",
            "The {$year} {$make} {$model} delivers exceptional value with modern amenities and dependable performance."
        ];

        $baseDescription = $this->faker->randomElement($descriptions);
        
        if (count($features) > 5) {
            $featuredFeatures = array_slice($features, 0, 3);
            $featureText = " Key features include " . implode(', ', $featuredFeatures) . " and much more.";
            $baseDescription .= $featureText;
        }

        return $baseDescription;
    }

    /**
     * Generate a realistic license plate.
     */
    private function generateLicensePlate(): string
    {
        $formats = [
            'ABC-1234',
            '123-XYZ',
            'AB-1234C',
            '1ABC234',
            'ABC1234'
        ];

        $format = $this->faker->randomElement($formats);
        
        return preg_replace_callback('/[A-Z]/', function($matches) {
            return $this->faker->randomLetter();
        }, preg_replace_callback('/\d/', function($matches) {
            return $this->faker->randomDigit();
        }, $format));
    }

    /**
     * Generate a Vehicle Identification Number (VIN).
     */
    private function generateVIN(string $make): string
    {
        // Simplified VIN generation for demo purposes
        $manufacturerCodes = [
            'Toyota' => '4T1',
            'Honda' => '2HK',
            'Ford' => '1FA',
            'Chevrolet' => '1GC',
            'Nissan' => '1N4',
            'BMW' => 'WBA',
            'Mercedes-Benz' => 'W1K',
            'Audi' => 'WAU',
            'Volkswagen' => '3VW',
            'Tesla' => '5YJ',
        ];

        $code = $manufacturerCodes[$make] ?? '1XX';
        $random = strtoupper($this->faker->bothify('##?####?#########'));
        
        return $code . substr($random, 3);
    }

    /**
     * Indicate that the car is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => true,
        ]);
    }

    /**
     * Indicate that the car is not available.
     */
    public function unavailable(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => false,
        ]);
    }

    /**
     * Indicate that the car is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Create a luxury car.
     */
    public function luxury(): static
    {
        return $this->state(function (array $attributes) {
            $luxuryMakes = ['BMW', 'Mercedes-Benz', 'Audi', 'Tesla'];
            $make = $this->faker->randomElement($luxuryMakes);
            
            $luxuryModels = [
                'BMW' => ['7 Series', '5 Series', 'X7', 'X5', 'i8'],
                'Mercedes-Benz' => ['S-Class', 'E-Class', 'GLS', 'GLE', 'AMG GT'],
                'Audi' => ['A8', 'A6', 'Q8', 'Q7', 'R8'],
                'Tesla' => ['Model S', 'Model X', 'Model Y Performance']
            ];

            return [
                'make' => $make,
                'model' => $this->faker->randomElement($luxuryModels[$make]),
                'type' => $this->faker->randomElement(['sedan', 'suv', 'coupe']),
                'daily_rate' => $this->faker->numberBetween(150, 350),
                'weekly_rate' => $this->faker->numberBetween(900, 2100),
                'monthly_rate' => $this->faker->numberBetween(3600, 8400),
                'features' => [
                    'Premium Leather Seats',
                    'Panoramic Sunroof',
                    'Advanced Driver Assistance',
                    'Premium Sound System',
                    'Wireless Charging',
                    'Heated and Cooled Seats',
                    'Ambient Lighting',
                    'GPS Navigation',
                    'Bluetooth',
                    'All-Wheel Drive'
                ],
                'is_featured' => true,
            ];
        });
    }

    /**
     * Create an economy car.
     */
    public function economy(): static
    {
        return $this->state(function (array $attributes) {
            $economyMakes = ['Toyota', 'Honda', 'Nissan', 'Hyundai', 'Kia'];
            $make = $this->faker->randomElement($economyMakes);
            
            $economyModels = [
                'Toyota' => ['Corolla', 'Yaris', 'Camry'],
                'Honda' => ['Civic', 'Accord', 'Fit'],
                'Nissan' => ['Sentra', 'Versa', 'Altima'],
                'Hyundai' => ['Elantra', 'Accent', 'Sonata'],
                'Kia' => ['Forte', 'Rio', 'Optima']
            ];

            return [
                'make' => $make,
                'model' => $this->faker->randomElement($economyModels[$make]),
                'type' => $this->faker->randomElement(['sedan', 'hatchback']),
                'daily_rate' => $this->faker->numberBetween(35, 65),
                'weekly_rate' => $this->faker->numberBetween(210, 390),
                'monthly_rate' => $this->faker->numberBetween(840, 1560),
                'features' => [
                    'Air Conditioning',
                    'GPS Navigation',
                    'Bluetooth',
                    'USB Charging Ports',
                    'Backup Camera',
                    'Cruise Control'
                ],
            ];
        });
    }

    /**
     * Create an electric car.
     */
    public function electric(): static
    {
        return $this->state(function (array $attributes) {
            $electricMakes = ['Tesla', 'BMW', 'Audi', 'Volkswagen', 'Nissan'];
            $make = $this->faker->randomElement($electricMakes);
            
            $electricModels = [
                'Tesla' => ['Model 3', 'Model Y', 'Model S', 'Model X'],
                'BMW' => ['i3', 'i4', 'iX'],
                'Audi' => ['e-tron', 'e-tron GT', 'Q4 e-tron'],
                'Volkswagen' => ['ID.4', 'ID.3', 'e-Golf'],
                'Nissan' => ['Leaf', 'Ariya']
            ];

            return [
                'make' => $make,
                'model' => $this->faker->randomElement($electricModels[$make]),
                'fuel_type' => 'electric',
                'transmission' => 'single-speed',
                'engine_size' => 'Electric',
                'daily_rate' => $this->faker->numberBetween(75, 200),
                'weekly_rate' => $this->faker->numberBetween(450, 1200),
                'monthly_rate' => $this->faker->numberBetween(1800, 4800),
                'features' => [
                    'Electric Powertrain',
                    'Regenerative Braking',
                    'Fast Charging Capability',
                    'GPS Navigation',
                    'Bluetooth',
                    'Climate Control',
                    'Mobile App Integration',
                    'Over-the-Air Updates'
                ],
            ];
        });
    }
}