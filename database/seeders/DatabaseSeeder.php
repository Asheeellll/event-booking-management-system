<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * DATABASE SEEDER (Master)
 * -------------------------
 * This is the main seeder that runs all other seeders in the correct order.
 *
 * ORDER MATTERS — follow this sequence because of foreign key dependencies:
 *   1. CategorySeeder  → No dependencies
 *   2. UserSeeder      → No dependencies
 *   3. EventSeeder     → Needs categories and users to exist first
 *   4. BookingSeeder   → Needs users and events to exist first
 *
 * HOW TO RUN:
 *   php artisan db:seed
 *
 * HOW TO FRESH MIGRATE + SEED (reset everything):
 *   php artisan migrate:fresh --seed
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Starting database seeding...');
        $this->command->newLine();

        // Step 1: Seed categories first (events depend on them)
        $this->call(CategorySeeder::class);

        // Step 2: Seed users (events and bookings depend on users)
        $this->call(UserSeeder::class);

        // Step 3: Seed events (needs category_id and user_id)
        $this->call(EventSeeder::class);

        // Step 4: Seed bookings last (needs user_id and event_id)
        $this->call(BookingSeeder::class);

        $this->command->newLine();
        $this->command->info('🎉 All seeders completed successfully!');
        $this->command->info('');
        $this->command->info('📋 Test Login Credentials:');
        $this->command->info('   Admin : admin@eventbook.in  / password');
        $this->command->info('   User 1: arjun@example.com  / password');
        $this->command->info('   User 2: priya@example.com  / password');
        $this->command->info('   User 3: rohit@example.com  / password');
    }
}
