<?php

require_once 'vendor/autoload.php';

// Load Laravel's bootstrap
$app = require_once 'bootstrap/app.php';

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Midtrans\Config;
use Midtrans\Snap;

try {
    // Set Midtrans configuration
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = config('midtrans.is_sanitized');
    Config::$is3ds = config('midtrans.is_3ds');

    echo "Midtrans Configuration:\n";
    echo "Server Key: " . (Config::$serverKey ? 'SET' : 'NOT SET') . "\n";
    echo "Is Production: " . (Config::$isProduction ? 'true' : 'false') . "\n";
    echo "Is Sanitized: " . (Config::$isSanitized ? 'true' : 'false') . "\n";
    echo "Is 3DS: " . (Config::$is3ds ? 'true' : 'false') . "\n";

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

    echo "\nAttempting to generate Snap Token...\n";

    // Try to generate a snap token
    $snapToken = Snap::getSnapToken($params);

    echo "SUCCESS! Snap Token: " . $snapToken . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
