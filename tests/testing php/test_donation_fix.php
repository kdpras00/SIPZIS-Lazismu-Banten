<?php
require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test creating a guest payment with program type
echo "Testing guest donation with program type...\n";

// Get a sample program type
$programType = App\Models\ProgramType::first();

if (!$programType) {
    echo "No program types found. Please run the seeder.\n";
    exit(1);
}

echo "Using program type: ID={$programType->id}, Name={$programType->name}, Category={$programType->category}\n";

// Map program type category to program category
$categoryMap = [
    'zakat' => 'zakat-fitrah',  // Default to zakat-fitrah for zakat types
    'infaq' => 'infaq-masjid',  // Default to infaq-masjid for infaq types
    'shadaqah' => 'shadaqah-rutin',  // Default to shadaqah-rutin for shadaqah types
    'program_pilar' => 'pendidikan'  // Default to pendidikan for program pilar types
];

$programCategory = $categoryMap[$programType->category] ?? 'umum';

echo "Mapped program category: {$programCategory}\n";

// Create a test muzakki
$muzakki = App\Models\Muzakki::firstOrCreate(
    ['email' => 'test@example.com'],
    [
        'name' => 'Test Donor',
        'phone' => '08123456789',
        'is_active' => true,
    ]
);

echo "Using muzakki: ID={$muzakki->id}, Name={$muzakki->name}\n";

// Create a payment with program type
$payment = App\Models\ZakatPayment::create([
    'payment_code' => App\Models\ZakatPayment::generatePaymentCode(),
    'muzakki_id' => $muzakki->id,
    'program_type_id' => $programType->id,
    'program_category' => $programCategory,
    'paid_amount' => 50000,
    'payment_date' => now(),
    'status' => 'pending',
    'is_guest_payment' => true,
    'receipt_number' => App\Models\ZakatPayment::generateReceiptNumber(),
]);

echo "Payment created successfully:\n";
echo "  Payment Code: {$payment->payment_code}\n";
echo "  Program Category: {$payment->program_category}\n";
echo "  Program Type ID: {$payment->program_type_id}\n";
echo "  Program Type Name: " . ($payment->programType ? $payment->programType->name : 'N/A') . "\n";

echo "Test completed successfully!\n";
