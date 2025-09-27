<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();

            // Basic car information
            $table->string('make');
            $table->string('model');
            $table->year('year');
            $table->enum('type', [
                'economy', 'compact', 'standard', 'intermediate', 'full_size', 
                'premium', 'luxury', 'suv', 'minivan', 'convertible', 
                'sports_car', 'truck', 'van', 'exotic'
            ]);

            // Technical specifications
            $table->enum('fuel_type', ['petrol', 'diesel', 'hybrid', 'electric', 'lpg']);
            $table->enum('transmission', ['manual', 'automatic', 'cvt']);
            $table->tinyInteger('seats')->unsigned();
            $table->tinyInteger('doors')->unsigned();
            $table->string('luggage_capacity')->nullable();
            $table->integer('mileage')->unsigned()->nullable();
            $table->string('color')->nullable();
            $table->string('license_plate')->unique()->nullable();
            $table->string('vin')->unique()->nullable();
            $table->decimal('engine_size', 3, 1)->nullable();
            $table->integer('horsepower')->unsigned()->nullable();

            // Pricing
            $table->decimal('daily_rate', 8, 2);
            $table->decimal('weekly_rate', 8, 2)->nullable();
            $table->decimal('monthly_rate', 8, 2)->nullable();
            $table->decimal('deposit_amount', 8, 2)->default(0);

            // Media and content
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('features')->nullable();
            $table->text('description')->nullable();

            // Availability and location
            $table->boolean('is_available')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('location')->nullable();
            $table->json('pickup_locations')->nullable();

            // Rental policies
            $table->boolean('insurance_included')->default(false);
            $table->tinyInteger('minimum_age')->unsigned()->default(21);
            $table->text('cancellation_policy')->nullable();

            // Statistics
            $table->integer('total_bookings')->unsigned()->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('likes_count')->unsigned()->default(0);

            // Timestamps and soft deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index(['make', 'model']);
            $table->index(['type', 'is_available']);
            $table->index(['daily_rate', 'is_available']);
            $table->index('is_featured');
            $table->index('location');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
