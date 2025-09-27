<?php

require_once 'vendor/autoload.php';

use Midtrans\Config;
use Midtrans\Snap;

// Load environment variables
$env = parse_ini_file('.env');

// Set Midtrans configuration
Config::$serverKey = $env['MIDTRANS_SERVER_KEY'] ?? '';
Config::$isProduction = filter_var($env['MIDTRANS_IS_PRODUCTION'] ?? false, FILTER_VALIDATE_BOOLEAN);
Config::$isSanitized = filter_var($env['MIDTRANS_IS_SANITIZED'] ?? true, FILTER_VALIDATE_BOOLEAN);
Config::$is3ds = filter_var($env['MIDTRANS_IS_3DS'] ?? true, FILTER_VALIDATE_BOOLEAN);

echo "Midtrans Configuration Test\n";
echo "==========================\n";
echo "Server Key: " . (Config::$serverKey ? substr(Config::$serverKey, 0, 10) . '...' : 'NOT SET') . "\n";
echo "Is Production: " . (Config::$isProduction ? 'true' : 'false') . "\n";
echo "Is Sanitized: " . (Config::$isSanitized ? 'true' : 'false') . "\n";
echo "Is 3DS: " . (Config::$is3ds ? 'true' : 'false') . "\n";

if (empty(Config::$serverKey)) {
    echo "ERROR: Server key is not set!\n";
    exit(1);
}

try {
    $params = [
        'transaction_details' => [
            'order_id' => 'TEST-' . time(),
            'gross_amount' => 10000,
        ],
        'customer_details' => [
            'first_name' => 'Test',
            'email' => 'test@example.com',
            'phone' => '08123456789',
        ],
    ];
    
    echo "\nAttempting to get Snap token...\n";
    $snapToken = Snap::getSnapToken($params);
    echo "SUCCESS: Snap token generated\n";
    echo "Token: " . substr($snapToken, 0, 20) . "...\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n";
}