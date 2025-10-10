<?php

require_once 'vendor/autoload.php';

// Load Laravel's bootstrap
$app = require_once 'bootstrap/app.php';

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ZakatPayment;

try {
    // Load the specific payment
    $payment = ZakatPayment::where('payment_code', 'ZKT-2025-002')->first();
    
    if (!$payment) {
        echo "Payment not found!\n";
        exit;
    }
    
    echo "Payment Code: " . $payment->payment_code . "\n";
    echo "Snap Token: " . ($payment->snap_token ?? 'NULL') . "\n";
    echo "Status: " . $payment->status . "\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}