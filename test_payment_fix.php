<?php

require_once 'vendor/autoload.php';

// Load Laravel's bootstrap
$app = require_once 'bootstrap/app.php';

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ZakatPayment;
use App\Models\Muzakki;
use App\Models\ProgramType;
use Illuminate\Support\Facades\DB;

try {
    // Create a test muzakki
    $muzakki = Muzakki::firstOrCreate(
        ['email' => 'test@example.com'],
        [
            'name' => 'Test Donor',
            'phone' => '08123456789',
            'is_active' => true,
        ]
    );

    // Check if there's at least one program type, create one if not
    $programType = ProgramType::first();
    if (!$programType) {
        $programType = ProgramType::create([
            'name' => 'Test Program Type',
            'slug' => 'test-program-type',
            'category' => 'zakat',
            'description' => 'Test program type for testing purposes',
            'is_active' => true,
        ]);
    }

    // Create a test payment with program category and program type ID
    $payment = ZakatPayment::create([
        'payment_code' => ZakatPayment::generatePaymentCode(),
        'muzakki_id' => $muzakki->id,
        'program_category' => 'zakat',
        'program_type_id' => $programType->id,
        'paid_amount' => 100000,
        'payment_date' => now(),
        'status' => 'pending',
        'is_guest_payment' => true,
        'receipt_number' => ZakatPayment::generateReceiptNumber(),
    ]);

    echo "Test payment created successfully!\n";
    echo "Payment Code: " . $payment->payment_code . "\n";
    echo "Program Category: " . ($payment->program_category ?? 'NULL') . "\n";
    echo "Program Type ID: " . ($payment->program_type_id ?? 'NULL') . "\n";
    echo "Wealth Amount: " . ($payment->wealth_amount ?? 'NULL') . "\n";
    echo "Hijri Year: " . ($payment->hijri_year ?? 'NULL') . "\n";

    // Check if the columns we removed are actually gone
    $columns = DB::getSchemaBuilder()->getColumnListing('zakat_payments');
    echo "\nChecking if wealth_amount and hijri_year columns are removed:\n";
    echo "wealth_amount column exists: " . (in_array('wealth_amount', $columns) ? 'YES' : 'NO') . "\n";
    echo "hijri_year column exists: " . (in_array('hijri_year', $columns) ? 'YES' : 'NO') . "\n";

    echo "\nTest completed successfully!\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
