<?php

require_once 'vendor/autoload.php';

// Load Laravel's bootstrap
$app = require_once 'bootstrap/app.php';

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ZakatPayment;

// Test if we can access the payment data
try {
    // Get a sample payment
    $payment = ZakatPayment::first();

    if ($payment) {
        echo "Payment Data Test:\n";
        echo "==================\n";
        echo "ID: " . $payment->id . "\n";
        echo "Payment Code: " . $payment->payment_code . "\n";
        echo "Midtrans Order ID: " . ($payment->midtrans_order_id ?? 'NULL') . "\n";
        echo "Program Category: " . ($payment->program_category ?? 'NULL') . "\n";
        echo "Program Type ID: " . ($payment->program_type_id ?? 'NULL') . "\n";
        echo "Midtrans Payment Method: " . ($payment->midtrans_payment_method ?? 'NULL') . "\n";
        echo "Payment Reference: " . ($payment->payment_reference ?? 'NULL') . "\n";
        echo "Status: " . $payment->status . "\n";

        // Test loading relationships
        echo "\nRelationships:\n";
        echo "==============\n";
        echo "Muzakki: " . ($payment->muzakki ? $payment->muzakki->name : 'Not loaded') . "\n";
        echo "Program Type: " . ($payment->programType ? $payment->programType->name : 'Not loaded') . "\n";
    } else {
        echo "No payments found in the database.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
