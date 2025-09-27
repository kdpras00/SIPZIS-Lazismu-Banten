<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Muzakki;

class MuzakkiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $muzakkiData = [
            [
                'name' => 'Ahmad Muzakki',
                'email' => 'ahmad@example.com',
                'phone' => '081234567893',
                'nik' => '3171010101800001',
                'gender' => 'male',
                'address' => 'Jl. Masjid Raya No. 123',
                'city' => 'Jakarta Pusat',
                'province' => 'DKI Jakarta',
                'postal_code' => '10430',
                'occupation' => 'entrepreneur',
                'monthly_income' => 15000000.00,
                'date_of_birth' => '1980-01-01',
                'is_active' => true,
                'user_id' => 4, // Ahmad user
            ],
            [
                'name' => 'Fatimah Zakat',
                'email' => 'fatimah@example.com',
                'phone' => '081234567894',
                'nik' => '3171010202850002',
                'gender' => 'female',
                'address' => 'Jl. Kebayoran Lama No. 456',
                'city' => 'Jakarta Selatan',
                'province' => 'DKI Jakarta',
                'postal_code' => '12240',
                'occupation' => 'teacher',
                'monthly_income' => 8000000.00,
                'date_of_birth' => '1985-02-02',
                'is_active' => true,
                'user_id' => 5, // Fatimah user
            ],
            [
                'name' => 'Muhammad Dermawan',
                'email' => 'muhammad@example.com',
                'phone' => '081234567895',
                'nik' => '3171010303900003',
                'gender' => 'male',
                'address' => 'Jl. Imam Bonjol No. 789',
                'city' => 'Jakarta Utara',
                'province' => 'DKI Jakarta',
                'postal_code' => '14045',
                'occupation' => 'doctor',
                'monthly_income' => 25000000.00,
                'date_of_birth' => '1990-03-03',
                'is_active' => true,
                'user_id' => 6, // Muhammad user
            ],
            [
                'name' => 'Siti Hasanah',
                'email' => 'siti@example.com',
                'phone' => '081234567896',
                'nik' => '3171010404880004',
                'gender' => 'female',
                'address' => 'Jl. Sudirman No. 321',
                'city' => 'Jakarta Pusat',
                'province' => 'DKI Jakarta',
                'postal_code' => '10270',
                'occupation' => 'civil_servant',
                'monthly_income' => 12000000.00,
                'date_of_birth' => '1988-04-04',
                'is_active' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Abdullah Barokah',
                'email' => 'abdullah@example.com',
                'phone' => '081234567897',
                'nik' => '3171010505920005',
                'gender' => 'male',
                'address' => 'Jl. Gatot Subroto No. 654',
                'city' => 'Jakarta Selatan',
                'province' => 'DKI Jakarta',
                'postal_code' => '12930',
                'occupation' => 'trader',
                'monthly_income' => 18000000.00,
                'date_of_birth' => '1992-05-05',
                'is_active' => true,
                'user_id' => null,
            ],
        ];

        foreach ($muzakkiData as $data) {
            Muzakki::create($data);
        }
    }
}
