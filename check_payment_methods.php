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
    // Get the column info for payment_method
    $columnInfo = DB::select("SHOW COLUMNS FROM zakat_payments WHERE Field = 'payment_method'")[0];

    echo "Payment method column info:\n";
    print_r($columnInfo);

    // Extract enum values
    if (preg_match('/enum\((.*)\)/', $columnInfo->Type, $matches)) {
        $enumValues = explode(',', $matches[1]);
        // Remove quotes
        $enumValues = array_map(function ($value) {
            return trim($value, "'");
        }, $enumValues);

        echo "\nEnum values for payment_method:\n";
        foreach ($enumValues as $value) {
            echo "- " . $value . "\n";
        }

        echo "\n";
        if (in_array('midtrans', $enumValues)) {
            echo "✓ 'midtrans' is a valid payment method\n";
        } else {
            echo "✗ 'midtrans' is NOT a valid payment method\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
