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
        // For SQLite, we need to drop indexes first
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['car_id', 'status']);
        });
        
        // Update existing bookings to new status system
        DB::statement("UPDATE bookings SET status = 'active' WHERE status IN ('pending', 'confirmed')");
        DB::statement("UPDATE bookings SET status = 'done' WHERE status IN ('completed', 'cancelled')");
        
        // Modify the status column to only have 2 statuses
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status', ['active', 'done'])->default('active')->after('extras');
            // Recreate indexes
            $table->index(['user_id', 'status']);
            $table->index(['car_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('bookings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'confirmed', 'active', 'completed', 'cancelled'])->default('pending')->after('extras');
        });
    }
};
