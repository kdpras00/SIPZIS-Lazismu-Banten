<?php

require_once 'vendor/autoload.php';

// Load Laravel's bootstrap
$app = require_once 'bootstrap/app.php';

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ZakatPayment;
use Illuminate\Support\Facades\DB;

// Get the latest payment
$payment = ZakatPayment::orderBy('id', 'desc')->first();

echo "Latest payment:\n";
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
