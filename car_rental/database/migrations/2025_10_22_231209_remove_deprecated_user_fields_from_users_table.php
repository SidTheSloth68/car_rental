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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'date_of_birth',
                'license_expiry',
                'bio',
                'preferences',
                'emergency_contact_name',
                'emergency_contact_phone',
                'is_active',
                'last_login_at',
                'loyalty_points',
                'preferred_payment_method',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable();
            $table->date('license_expiry')->nullable();
            $table->text('bio')->nullable();
            $table->json('preferences')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            $table->integer('loyalty_points')->default(0);
            $table->enum('preferred_payment_method', ['credit_card', 'debit_card', 'digital_wallet', 'bank_transfer'])->nullable();
        });
    }
};
