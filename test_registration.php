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
    // Test registration with minimal data
    $user = \App\Models\User::create([
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'password' => bcrypt('password'),
        'role' => 'muzakki',
        'is_active' => true,
    ]);

    // Create muzakki profile with nullable fields
    $muzakki = \App\Models\Muzakki::create([
        'name' => 'Test User',
        'email' => 'testuser@example.com',
        'phone' => null,
        'nik' => null,
        'gender' => null,
        'address' => null,
        'city' => null,
        'province' => null,
        'occupation' => null,
        'monthly_income' => null,
        'date_of_birth' => null,
        'user_id' => $user->id,
        'is_active' => true,
    ]);

    echo "Registration test successful!\n";
    echo "User ID: " . $user->id . "\n";
    echo "Muzakki ID: " . $muzakki->id . "\n";
} catch (Exception $e) {
    echo "Test failed with error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
} finally {
    // Rollback the transaction
    DB::rollBack();
}
