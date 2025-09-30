<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting database seeding...');

        // Seed users first (required for news authors)
        $this->call([
            UserSeeder::class,
        ]);

        // Seed cars data
        $this->call([
            CarSeeder::class,
        ]);

        // Seed news articles (requires users for authors)
        $this->call([
            NewsSeeder::class,
        ]);

        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('📊 Summary:');
        $this->command->info('   - Users: ' . \App\Models\User::count());
        $this->command->info('   - Cars: ' . \App\Models\Car::count());
        $this->command->info('   - News Articles: ' . \App\Models\News::count());
    }
}
