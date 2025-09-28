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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->string('booking_number')->unique();
            
            // Booking details
            $table->string('pickup_location');
            $table->string('dropoff_location');
            $table->dateTime('pickup_date');
            $table->dateTime('return_date');
            $table->integer('days');
            
            // Pricing
            $table->decimal('daily_rate', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2);
            
            // Customer details
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('customer_address')->nullable();
            
            // Additional information
            $table->text('special_requirements')->nullable();
            $table->json('extras')->nullable(); // Additional services like GPS, child seat, etc.
            
            // Status and workflow
            $table->enum('status', ['pending', 'confirmed', 'active', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'partial', 'refunded', 'failed'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            
            // Timestamps for different stages
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            // Admin notes
            $table->text('admin_notes')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'status']);
            $table->index(['car_id', 'status']);
            $table->index(['pickup_date', 'return_date']);
            $table->index('booking_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
