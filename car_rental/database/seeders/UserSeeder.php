<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin users
        $adminUsers = [
            [
                'name' => 'John Administrator',
                'email' => 'admin@rentaly.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '+1-555-0101',
                'address' => '123 Admin Street, City Center, NY 10001',
                'date_of_birth' => '1985-03-15',
                'license_number' => 'ADM123456789',
                'license_expiry' => '2026-03-15',
                'profile_photo' => 'profiles/admin-john.jpg',
                'bio' => 'Experienced car rental industry administrator with over 10 years of management experience.',
                'preferences' => json_encode([
                    'notifications' => true,
                    'newsletter' => true,
                    'sms_alerts' => true,
                    'language' => 'en',
                    'currency' => 'USD'
                ]),
                'emergency_contact_name' => 'Jane Administrator',
                'emergency_contact_phone' => '+1-555-0102',
                'is_active' => true,
                'last_login_at' => now()->subHours(2),
                'created_at' => now()->subMonths(12),
                'updated_at' => now()->subHours(2),
            ],
            [
                'name' => 'Sarah Manager',
                'email' => 'manager@rentaly.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '+1-555-0201',
                'address' => '456 Management Ave, Business District, NY 10002',
                'date_of_birth' => '1988-07-22',
                'license_number' => 'MGR987654321',
                'license_expiry' => '2025-07-22',
                'profile_photo' => 'profiles/manager-sarah.jpg',
                'bio' => 'Operations manager specializing in fleet management and customer service excellence.',
                'preferences' => json_encode([
                    'notifications' => true,
                    'newsletter' => true,
                    'sms_alerts' => false,
                    'language' => 'en',
                    'currency' => 'USD'
                ]),
                'emergency_contact_name' => 'Michael Manager',
                'emergency_contact_phone' => '+1-555-0202',
                'is_active' => true,
                'last_login_at' => now()->subHours(5),
                'created_at' => now()->subMonths(8),
                'updated_at' => now()->subHours(5),
            ]
        ];

        foreach ($adminUsers as $adminData) {
            User::create($adminData);
        }

        // Create regular customers
        $customers = [
            [
                'name' => 'Michael Johnson',
                'email' => 'michael.johnson@email.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '+1-555-1001',
                'address' => '789 Customer Lane, Residential Area, NY 10003',
                'date_of_birth' => '1990-05-10',
                'license_number' => 'CUS123456789',
                'license_expiry' => '2025-05-10',
                'profile_photo' => 'profiles/customer-michael.jpg',
                'bio' => 'Frequent business traveler who enjoys driving luxury vehicles during business trips.',
                'preferences' => json_encode([
                    'notifications' => true,
                    'newsletter' => true,
                    'sms_alerts' => true,
                    'language' => 'en',
                    'currency' => 'USD',
                    'preferred_car_type' => 'luxury',
                    'preferred_pickup_location' => 'airport'
                ]),
                'emergency_contact_name' => 'Emma Johnson',
                'emergency_contact_phone' => '+1-555-1002',
                'is_active' => true,
                'last_login_at' => now()->subDays(1),
                'total_bookings' => 15,
                'loyalty_points' => 1200,
                'preferred_payment_method' => 'credit_card',
                'created_at' => now()->subMonths(6),
                'updated_at' => now()->subDays(1),
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@email.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'user',
                'phone' => '+1-555-2001',
                'address' => '321 Family Street, Suburb Heights, NY 10004',
                'date_of_birth' => '1987-11-18',
                'license_number' => 'FAM987654321',
                'license_expiry' => '2026-11-18',
                'profile_photo' => 'profiles/customer-emily.jpg',
                'bio' => 'Working mother who needs reliable vehicles for family trips and daily errands.',
                'preferences' => json_encode([
                    'notifications' => true,
                    'newsletter' => false,
                    'sms_alerts' => true,
                    'language' => 'en',
                    'currency' => 'USD',
                    'preferred_car_type' => 'suv',
                    'preferred_pickup_location' => 'city_center'
                ]),
                'emergency_contact_name' => 'David Davis',
                'emergency_contact_phone' => '+1-555-2002',
                'is_active' => true,
                'last_login_at' => now()->subDays(3),
                'total_bookings' => 8,
                'loyalty_points' => 640,
                'preferred_payment_method' => 'debit_card',
                'created_at' => now()->subMonths(4),
                'updated_at' => now()->subDays(3),
            ],
            [
                'name' => 'Robert Wilson',
                'email' => 'robert.wilson@email.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '+1-555-3001',
                'address' => '654 Adventure Road, Mountain View, NY 10005',
                'date_of_birth' => '1992-02-28',
                'license_number' => 'ADV555444333',
                'license_expiry' => '2025-02-28',
                'profile_photo' => 'profiles/customer-robert.jpg',
                'bio' => 'Outdoor enthusiast who loves weekend road trips and exploring new destinations.',
                'preferences' => json_encode([
                    'notifications' => false,
                    'newsletter' => true,
                    'sms_alerts' => false,
                    'language' => 'en',
                    'currency' => 'USD',
                    'preferred_car_type' => 'suv',
                    'preferred_pickup_location' => 'various'
                ]),
                'emergency_contact_name' => 'Lisa Wilson',
                'emergency_contact_phone' => '+1-555-3002',
                'is_active' => true,
                'last_login_at' => now()->subWeek(),
                'total_bookings' => 22,
                'loyalty_points' => 1850,
                'preferred_payment_method' => 'credit_card',
                'created_at' => now()->subMonths(10),
                'updated_at' => now()->subWeek(),
            ],
            [
                'name' => 'Jessica Brown',
                'email' => 'jessica.brown@email.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '+1-555-4001',
                'address' => '987 College Street, University District, NY 10006',
                'date_of_birth' => '1995-08-12',
                'license_number' => 'STU777888999',
                'license_expiry' => '2027-08-12',
                'profile_photo' => 'profiles/customer-jessica.jpg',
                'bio' => 'Graduate student who occasionally needs a car for internships and job interviews.',
                'preferences' => json_encode([
                    'notifications' => true,
                    'newsletter' => true,
                    'sms_alerts' => true,
                    'language' => 'en',
                    'currency' => 'USD',
                    'preferred_car_type' => 'economy',
                    'preferred_pickup_location' => 'campus'
                ]),
                'emergency_contact_name' => 'Mark Brown',
                'emergency_contact_phone' => '+1-555-4002',
                'is_active' => true,
                'last_login_at' => now()->subDays(5),
                'total_bookings' => 3,
                'loyalty_points' => 180,
                'preferred_payment_method' => 'debit_card',
                'created_at' => now()->subMonths(2),
                'updated_at' => now()->subDays(5),
            ],
            [
                'name' => 'Christopher Taylor',
                'email' => 'chris.taylor@email.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '+1-555-5001',
                'address' => '147 Tech Boulevard, Innovation Park, NY 10007',
                'date_of_birth' => '1984-12-03',
                'license_number' => 'TEC111222333',
                'license_expiry' => '2025-12-03',
                'profile_photo' => 'profiles/customer-christopher.jpg',
                'bio' => 'Tech entrepreneur who values efficiency and sustainability in transportation choices.',
                'preferences' => json_encode([
                    'notifications' => true,
                    'newsletter' => true,
                    'sms_alerts' => false,
                    'language' => 'en',
                    'currency' => 'USD',
                    'preferred_car_type' => 'electric',
                    'preferred_pickup_location' => 'downtown'
                ]),
                'emergency_contact_name' => 'Amanda Taylor',
                'emergency_contact_phone' => '+1-555-5002',
                'is_active' => true,
                'last_login_at' => now()->subHours(8),
                'total_bookings' => 12,
                'loyalty_points' => 960,
                'preferred_payment_method' => 'digital_wallet',
                'created_at' => now()->subMonths(7),
                'updated_at' => now()->subHours(8),
            ],
            [
                'name' => 'Amanda Garcia',
                'email' => 'amanda.garcia@email.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => 'customer',
                'phone' => '+1-555-6001',
                'address' => '258 Healthcare Drive, Medical Center, NY 10008',
                'date_of_birth' => '1989-04-20',
                'license_number' => 'MED444555666',
                'license_expiry' => '2026-04-20',
                'profile_photo' => 'profiles/customer-amanda.jpg',
                'bio' => 'Healthcare professional who needs reliable transportation for conferences and medical missions.',
                'preferences' => json_encode([
                    'notifications' => true,
                    'newsletter' => false,
                    'sms_alerts' => true,
                    'language' => 'en',
                    'currency' => 'USD',
                    'preferred_car_type' => 'sedan',
                    'preferred_pickup_location' => 'airport'
                ]),
                'emergency_contact_name' => 'Carlos Garcia',
                'emergency_contact_phone' => '+1-555-6002',
                'is_active' => true,
                'last_login_at' => now()->subDays(2),
                'total_bookings' => 18,
                'loyalty_points' => 1440,
                'preferred_payment_method' => 'credit_card',
                'created_at' => now()->subMonths(9),
                'updated_at' => now()->subDays(2),
            ]
        ];

        foreach ($customers as $customerData) {
            User::create($customerData);
        }

        // Create some users with factory if available
        if (class_exists(\Database\Factories\UserFactory::class)) {
            // Create additional random users
            User::factory(25)->create([
                'role' => 'customer',
                'email_verified_at' => now(),
                'is_active' => true,
            ]);

            // Create a few more admin users
            User::factory(3)->create([
                'role' => 'admin',
                'email_verified_at' => now(),
                'is_active' => true,
            ]);
        }

        $this->command->info('User seeder completed successfully. Created ' . User::count() . ' users.');
        $this->command->info('Admin users: ' . User::where('role', 'admin')->count());
        $this->command->info('Customer users: ' . User::where('role', 'customer')->count());
    }
}