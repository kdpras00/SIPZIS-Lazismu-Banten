<?php

namespace Database\Seeders;

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
        // Create Admin User
        User::create([
            'name' => 'Administrator Zakat',
            'email' => 'admin@zakat.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'phone' => '081234567890',
            'email_verified_at' => now(),
        ]);

        // Create Staff Users
        User::create([
            'name' => 'Staff Zakat 1',
            'email' => 'staff1@zakat.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'is_active' => true,
            'phone' => '081234567891',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Staff Zakat 2',
            'email' => 'staff2@zakat.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'is_active' => true,
            'phone' => '081234567892',
            'email_verified_at' => now(),
        ]);

        // Create Sample Muzakki Users
        User::create([
            'name' => 'Ahmad Muzakki',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password'),
            'role' => 'muzakki',
            'is_active' => true,
            'phone' => '081234567893',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Fatimah Zakat',
            'email' => 'fatimah@example.com',
            'password' => Hash::make('password'),
            'role' => 'muzakki',
            'is_active' => true,
            'phone' => '081234567894',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Muhammad Dermawan',
            'email' => 'muhammad@example.com',
            'password' => Hash::make('password'),
            'role' => 'muzakki',
            'is_active' => true,
            'phone' => '081234567895',
            'email_verified_at' => now(),
        ]);
    }
}
