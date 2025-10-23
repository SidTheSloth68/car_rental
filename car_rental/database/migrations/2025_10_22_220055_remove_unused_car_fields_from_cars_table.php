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
        // For SQLite, dropping columns with indexes requires table recreation
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
            mileage INTEGER,
            color VARCHAR,
            engine_size DECIMAL(3,1),
            horsepower INTEGER,
            image VARCHAR,
            gallery TEXT,
            features TEXT,
            description TEXT,
            is_available BOOLEAN DEFAULT 1,
            is_featured BOOLEAN DEFAULT 0,
            created_at DATETIME,
            updated_at DATETIME,
            deleted_at DATETIME
        )');
        
        DB::statement('INSERT INTO cars_new 
            (id, make, model, year, type, fuel_type, transmission, seats, doors, 
             luggage_capacity, daily_rate, mileage, color, engine_size, horsepower,
             image, gallery, features, description, is_available, is_featured,
             created_at, updated_at, deleted_at)
            SELECT id, make, model, year, type, fuel_type, transmission, seats, doors, 
                   luggage_capacity, daily_rate, mileage, color, engine_size, horsepower,
                   image, gallery, features, description, is_available, is_featured,
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
            $table->string('license_plate')->nullable()->after('color');
            $table->string('vin')->nullable()->after('license_plate');
            $table->string('location')->nullable()->after('is_featured');
            $table->json('pickup_locations')->nullable()->after('location');
            $table->boolean('insurance_included')->default(false)->after('pickup_locations');
            $table->integer('minimum_age')->default(21)->after('insurance_included');
            $table->decimal('deposit_amount', 10, 2)->nullable()->after('minimum_age');
            $table->text('cancellation_policy')->nullable()->after('deposit_amount');
        });
    }
};
