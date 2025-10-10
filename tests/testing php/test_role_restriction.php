<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Use the database transaction
DB::beginTransaction();

try {
    // Create users with different roles
    $adminUser = \App\Models\User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'is_active' => true,
    ]);

    $staffUser = \App\Models\User::create([
        'name' => 'Staff User',
        'email' => 'staff@example.com',
        'password' => bcrypt('password'),
        'role' => 'staff',
        'is_active' => true,
    ]);

    $muzakkiUser = \App\Models\User::create([
        'name' => 'Muzakki User',
        'email' => 'muzakki@example.com',
        'password' => bcrypt('password'),
        'role' => 'muzakki',
        'is_active' => true,
    ]);

    // Create a muzakki
    $muzakki = \App\Models\Muzakki::create([
        'name' => 'Test Muzakki',
        'email' => 'testmuzakki@example.com',
        'phone' => '08123456789',
        'address' => 'Test Address',
        'is_active' => true,
    ]);

    echo "Created users and muzakki\n";

    // Test that admin can be set as received_by
    $payment1 = \App\Models\ZakatPayment::create([
        'payment_code' => 'ZKT-2024-001',
        'muzakki_id' => $muzakki->id,
        'zakat_amount' => 100000,
        'paid_amount' => 100000,
        'payment_method' => 'cash',
        'payment_date' => now(),
        'status' => 'completed',
        'receipt_number' => 'RCP-202401-0001',
        'received_by' => $adminUser->id,
    ]);

    echo "Admin user as received_by: " . ($payment1->received_by == $adminUser->id ? "PASS" : "FAIL") . "\n";

    // Test that staff can be set as received_by
    $payment2 = \App\Models\ZakatPayment::create([
        'payment_code' => 'ZKT-2024-002',
        'muzakki_id' => $muzakki->id,
        'zakat_amount' => 150000,
        'paid_amount' => 150000,
        'payment_method' => 'cash',
        'payment_date' => now(),
        'status' => 'completed',
        'receipt_number' => 'RCP-202401-0002',
        'received_by' => $staffUser->id,
    ]);

    echo "Staff user as received_by: " . ($payment2->received_by == $staffUser->id ? "PASS" : "FAIL") . "\n";

    // Test that muzakki cannot be set as received_by (should be nullified by observer)
    $payment3 = \App\Models\ZakatPayment::create([
        'payment_code' => 'ZKT-2024-003',
        'muzakki_id' => $muzakki->id,
        'zakat_amount' => 200000,
        'paid_amount' => 200000,
        'payment_method' => 'cash',
        'payment_date' => now(),
        'status' => 'completed',
        'receipt_number' => 'RCP-202401-0003',
        'received_by' => $muzakkiUser->id,
    ]);

    echo "Muzakki user as received_by (should be null): " . ($payment3->received_by === null ? "PASS" : "FAIL") . "\n";

    echo "Test completed successfully!\n";
} catch (Exception $e) {
    echo "Test failed with error: " . $e->getMessage() . "\n";
} finally {
    // Rollback the transaction
    DB::rollBack();
}
