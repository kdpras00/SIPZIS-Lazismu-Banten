<?php

require_once 'vendor/autoload.php';

// Load Laravel application
$app = require_once 'bootstrap/app.php';

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Use the DB facade to check the table structure
use Illuminate\Support\Facades\DB;

try {
    // Get the column names from the zakat_payments table
    $columns = DB::select('SHOW COLUMNS FROM zakat_payments');

    echo "Columns in zakat_payments table:\n";
    foreach ($columns as $column) {
        echo "- " . $column->Field . " (" . $column->Type . ")\n";
    }

    // Check specifically for midtrans_payment_method column
    $hasMidtransColumn = false;
    foreach ($columns as $column) {
        if ($column->Field === 'midtrans_payment_method') {
            $hasMidtransColumn = true;
            break;
        }
    }

    echo "\n";
    if ($hasMidtransColumn) {
        echo "✓ midtrans_payment_method column exists\n";
    } else {
        echo "✗ midtrans_payment_method column does NOT exist\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
