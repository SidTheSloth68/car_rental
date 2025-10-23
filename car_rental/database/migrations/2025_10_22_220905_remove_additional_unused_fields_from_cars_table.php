<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Recreate table without mileage, color, engine_size, horsepower, gallery, is_featured
        DB::statement('CREATE TABLE cars_new (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            make VARCHAR NOT NULL,
            model VARCHAR NOT NULL,
            year INTEGER NOT NULL,
            type VARCHAR NOT NULL,
            fuel_type VARCHAR NOT NULL,
            transmission VARCHAR NOT NULL,
            seats INTEGER NOT NULL,
            doors INTEGER NOT NULL,
            luggage_capacity VARCHAR,
            daily_rate DECIMAL(10,2) NOT NULL,
            image VARCHAR,
            features TEXT,
            description TEXT,
            is_available BOOLEAN DEFAULT 1,
            created_at DATETIME,
            updated_at DATETIME,
            deleted_at DATETIME
        )');
        
        DB::statement('INSERT INTO cars_new 
            (id, make, model, year, type, fuel_type, transmission, seats, doors, 
             luggage_capacity, daily_rate, image, features, description, is_available,
             created_at, updated_at, deleted_at)
            SELECT id, make, model, year, type, fuel_type, transmission, seats, doors, 
                   luggage_capacity, daily_rate, image, features, description, is_available,
                   created_at, updated_at, deleted_at
            FROM cars');
        
        DB::statement('DROP TABLE cars');
        DB::statement('ALTER TABLE cars_new RENAME TO cars');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->integer('mileage')->nullable()->after('daily_rate');
            $table->string('color')->nullable()->after('mileage');
            $table->decimal('engine_size', 3, 1)->nullable()->after('color');
            $table->integer('horsepower')->nullable()->after('engine_size');
            $table->json('gallery')->nullable()->after('image');
            $table->boolean('is_featured')->default(false)->after('is_available');
        });
    }
};
