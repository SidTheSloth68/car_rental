<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SimpleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin users
        $adminUsers = [
            [
                'name' => 'Admin User',
                'email' => 'admin@rentaly.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '+1-555-0101',
                'address' => '123 Admin Street, City Center, NY 10001',
                'is_active' => true,
                'loyalty_points' => 0,
            ],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@rentaly.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '+1-555-0102',
                'address' => '456 Admin Avenue, Business District, NY 10002',
                'is_active' => true,
                'loyalty_points' => 0,
            ]
        ];

        foreach ($adminUsers as $adminData) {
            User::firstOrCreate(
                ['email' => $adminData['email']],
                $adminData
            );
        }

        // Create regular users
        $regularUsers = [
            [
                'name' => 'John Doe',
                'email' => 'user@rentaly.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '+1-555-1001',
                'address' => '789 User Lane, Residential Area, NY 10003',
                'is_active' => true,
                'loyalty_points' => 100,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@email.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '+1-555-1002',
                'address' => '321 Customer Street, Suburb Heights, NY 10004',
                'is_active' => true,
                'loyalty_points' => 250,
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michael.johnson@email.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '+1-555-1003',
                'address' => '654 Family Avenue, Downtown, NY 10005',
                'is_active' => true,
                'loyalty_points' => 75,
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah.wilson@email.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '+1-555-1004',
                'address' => '987 Business Boulevard, Corporate District, NY 10006',
                'is_active' => true,
                'loyalty_points' => 500,
            ],
            [
                'name' => 'Robert Brown',
                'email' => 'robert.brown@email.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '+1-555-1005',
                'address' => '147 Traveler Road, Airport District, NY 10007',
                'is_active' => true,
                'loyalty_points' => 180,
            ]
        ];

        foreach ($regularUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Create additional random users using factory
        User::factory(20)->create();

        $this->command->info('✅ Users created successfully!');
        $this->command->info('📊 Total Admin users: ' . User::where('role', 'admin')->count());
        $this->command->info('📊 Total Regular users: ' . User::where('role', 'user')->count());
        $this->command->info('📊 Total users: ' . User::count());
    }
}