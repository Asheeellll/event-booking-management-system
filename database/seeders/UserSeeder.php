<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * USER SEEDER
 * -----------
 * Creates 1 Admin + 3 regular Indian users.
 *
 * LOGIN CREDENTIALS:
 * ┌──────────────────┬──────────────────────────┬──────────────┬───────┐
 * │ Name             │ Email                    │ Password     │ Role  │
 * ├──────────────────┼──────────────────────────┼──────────────┼───────┤
 * │ Admin User       │ admin@eventbook.in       │ password     │ admin │
 * │ Arjun Sharma     │ arjun@example.com        │ password     │ user  │
 * │ Priya Nair       │ priya@example.com        │ password     │ user  │
 * │ Rohit Verma      │ rohit@example.com        │ password     │ user  │
 * └──────────────────┴──────────────────────────┴──────────────┴───────┘
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@eventbook.in',
            'phone'    => '+91 98000 00001',
            'role'     => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Regular users
        $users = [
            [
                'name'     => 'Arjun Sharma',
                'email'    => 'arjun@example.com',
                'phone'    => '+91 98100 11111',
                'role'     => 'user',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'Priya Nair',
                'email'    => 'priya@example.com',
                'phone'    => '+91 98200 22222',
                'role'     => 'user',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'Rohit Verma',
                'email'    => 'rohit@example.com',
                'phone'    => '+91 98300 33333',
                'role'     => 'user',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('✅ 1 Admin + 3 Users seeded (Indian).');
    }
}
