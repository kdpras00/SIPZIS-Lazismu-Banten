<?php

// Include the Laravel application
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test the fix
echo "Testing program type and category fix...\n";

// Get a sample payment
$payment = \App\Models\ZakatPayment::first();

if ($payment) {
    echo "Sample payment found:\n";
    echo "- Payment Code: " . $payment->payment_code . "\n";
    echo "- Program Category: " . ($payment->program_category ?: 'Not set') . "\n";
    echo "- Program Type ID: " . ($payment->program_type_id ?: 'Not set') . "\n";

    if ($payment->programType) {
        echo "- Program Type Name: " . $payment->programType->name . "\n";
        echo "- Program Type Category: " . $payment->programType->category . "\n";
    } else {
        echo "- No program type associated\n";
    }
} else {
    echo "No payments found in the database.\n";
}

echo "Test completed.\n";
