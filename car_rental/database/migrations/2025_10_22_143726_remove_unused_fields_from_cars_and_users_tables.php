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
        // Remove columns from cars table
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn([
                'weekly_rate',
                'monthly_rate',
                'likes_count',
                'average_rating',
                'total_bookings'
            ]);
        });

        // Remove column from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('total_bookings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore columns to cars table
        Schema::table('cars', function (Blueprint $table) {
            $table->decimal('weekly_rate', 10, 2)->nullable()->after('daily_rate');
            $table->decimal('monthly_rate', 10, 2)->nullable()->after('weekly_rate');
            $table->integer('likes_count')->default(0)->after('cancellation_policy');
            $table->decimal('average_rating', 3, 2)->default(0)->after('likes_count');
            $table->integer('total_bookings')->default(0)->after('average_rating');
        });

        // Restore column to users table
        Schema::table('users', function (Blueprint $table) {
            $table->integer('total_bookings')->default(0)->after('last_login_at');
        });
    }
};
