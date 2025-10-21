<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CarTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    #[Test]
    public function guests_can_view_car_listing_page()
    {
        Car::factory()->count(5)->create();

        $response = $this->get('/cars');

        $response->assertStatus(200);
        $response->assertViewIs('cars.index');
        $response->assertViewHas('cars');
    }

    #[Test]
    public function guests_can_view_individual_car_details()
    {
        $car = Car::factory()->create([
            'make' => 'Toyota',
            'model' => 'Camry',
            'year' => 2023,
            'daily_rate' => 50.00,
            'is_available' => true
        ]);

        $response = $this->get("/cars/{$car->id}");

        $response->assertStatus(200);
        $response->assertViewIs('cars.show');
        $response->assertViewHas('car');
        $response->assertSee('Toyota');
        $response->assertSee('Camry');
        $response->assertSee('2023');
        $response->assertSee('$50');
    }

    #[Test]
    public function guests_can_search_cars_by_criteria()
    {
        Car::factory()->create([
            'make' => 'Toyota',
            'model' => 'Camry',
            'year' => 2023,
            'daily_rate' => 50.00,
            'is_available' => true
        ]);

        Car::factory()->create([
            'make' => 'Honda',
            'model' => 'Civic',
            'year' => 2022,
            'daily_rate' => 45.00,
            'is_available' => true
        ]);

        $response = $this->get('/cars?search=Toyota');

        $response->assertStatus(200);
        $response->assertSee('Toyota');
        $response->assertDontSee('Honda');
    }

    #[Test]
    public function admin_can_view_car_management_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($admin)->get('/admin/cars');

        $response->assertStatus(200);
        $response->assertViewIs('admin.cars.index');
    }

    #[Test]
    public function admin_can_create_new_car()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $carData = [
            'make' => 'BMW',
            'model' => 'X5',
            'year' => 2023,
            'type' => 'suv',
            'daily_rate' => 120.00,
            'location' => 'Los Angeles',
            'fuel_type' => 'petrol',
            'transmission' => 'automatic',
            'seats' => 5,
            'doors' => 4,
            'description' => 'Luxury SUV with premium features',
            'features' => 'GPS, Bluetooth, Leather Seats',
            'is_available' => true
        ];

        $response = $this->actingAs($admin)->post('/admin/cars', $carData);

        $response->assertRedirect('/admin/cars');
        $this->assertDatabaseHas('cars', [
            'make' => 'BMW',
            'model' => 'X5',
            'year' => 2023,
            'daily_rate' => 120.00
        ]);
    }

    #[Test]
    public function admin_can_update_car_details()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $car = Car::factory()->create([
            'make' => 'Toyota',
            'model' => 'Camry',
            'daily_rate' => 50.00
        ]);

        $updateData = [
            'make' => 'Toyota',
            'model' => 'Camry Hybrid',
            'year' => $car->year,
            'type' => $car->type,
            'location' => $car->location,
            'daily_rate' => 55.00,
            'fuel_type' => $car->fuel_type,
            'transmission' => $car->transmission,
            'seats' => $car->seats,
            'doors' => $car->doors,
            'description' => $car->description,
            'features' => $car->features,
            'is_available' => $car->is_available
        ];

        $response = $this->actingAs($admin)->put("/admin/cars/{$car->id}", $updateData);

        $response->assertRedirect('/admin/cars');
        $this->assertDatabaseHas('cars', [
            'id' => $car->id,
            'model' => 'Camry Hybrid',
            'daily_rate' => 55.00
        ]);
    }

    #[Test]
    public function admin_can_delete_car()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $car = Car::factory()->create();

        $response = $this->actingAs($admin)->delete("/admin/cars/{$car->id}");

        $response->assertRedirect('/admin/cars');
        $this->assertSoftDeleted('cars', ['id' => $car->id]);
    }

    #[Test]
    public function regular_users_cannot_access_car_management()
    {
        $user = User::factory()->create(['role' => 'customer']);
        
        $response = $this->actingAs($user)->get('/admin/cars');

        $response->assertStatus(403);
    }

    #[Test]
    public function guests_cannot_access_car_management()
    {
        $response = $this->get('/admin/cars');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function car_creation_requires_valid_data()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/cars', []);

        $response->assertSessionHasErrors([
            'make', 'model', 'year', 'daily_rate', 'fuel_type', 'transmission'
        ]);
    }

    #[Test]
    public function car_price_must_be_positive_number()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $carData = Car::factory()->make(['daily_rate' => -10])->toArray();

        $response = $this->actingAs($admin)->post('/admin/cars', $carData);

        $response->assertSessionHasErrors('daily_rate');
    }

    #[Test]
    public function only_available_cars_are_shown_to_guests()
    {
        Car::factory()->create([
            'make' => 'Available Car',
            'is_available' => true
        ]);

        Car::factory()->create([
            'make' => 'Unavailable Car',
            'is_available' => false
        ]);

        $response = $this->get('/cars');

        $response->assertSee('Available Car');
        $response->assertDontSee('Unavailable Car');
    }

    #[Test]
    public function cars_can_be_filtered_by_price_range()
    {
        Car::factory()->create([
            'make' => 'Expensive Car',
            'daily_rate' => 200.00,
            'is_available' => true
        ]);

        Car::factory()->create([
            'make' => 'Cheap Car',
            'daily_rate' => 30.00,
            'is_available' => true
        ]);

        $response = $this->get('/cars?min_price=50&max_price=250');

        $response->assertSee('Expensive Car');
        $response->assertDontSee('Cheap Car');
    }

    #[Test]
    public function api_returns_cars_in_json_format()
    {
        Car::factory()->count(3)->create(['is_available' => true]);

        $response = $this->getJson('/api/cars');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'cars' => [
                    '*' => [
                        'id',
                        'make',
                        'model',
                        'year',
                        'daily_rate',
                        'image'
                    ]
                ],
                'pagination' => [
                    'current_page',
                    'per_page',
                    'total'
                ]
            ]
        ]);
    }
}
