<?php

require_once 'vendor/autoload.php';

// Load Laravel's bootstrap
$app = require_once 'bootstrap/app.php';

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Config;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap;

// Test Midtrans configuration
echo "Testing Midtrans Configuration...\n";
echo "================================\n";

$serverKey = config('midtrans.server_key');
$clientKey = config('midtrans.client_key');
$isProduction = config('midtrans.is_production');

echo "Server Key: " . ($serverKey ? substr($serverKey, 0, 10) . '...' : 'NOT SET') . "\n";
echo "Client Key: " . ($clientKey ? substr($clientKey, 0, 10) . '...' : 'NOT SET') . "\n";
echo "Is Production: " . ($isProduction ? 'true' : 'false') . "\n";

// Test Midtrans connection
echo "\nTesting Midtrans Connection...\n";
echo "=============================\n";

try {
    // Set Midtrans configuration
    MidtransConfig::$serverKey = $serverKey;
    MidtransConfig::$isProduction = $isProduction;
    MidtransConfig::$isSanitized = true;
    MidtransConfig::$is3ds = true;

    // Test parameters
    $params = [
        'transaction_details' => [
            'order_id' => 'TEST-' . time(),
            'gross_amount' => 10000,
        ],
        'customer_details' => [
            'first_name' => 'Test',
            'email' => 'test@example.com',
        ],
    ];

    // Try to get Snap token
    $snapToken = Snap::getSnapToken($params);
    echo "SUCCESS: Snap Token Generated\n";
    echo "Token: " . substr($snapToken, 0, 20) . "...\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
