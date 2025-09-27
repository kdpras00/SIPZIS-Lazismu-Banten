<?php

require_once 'vendor/autoload.php';

// Load Laravel's bootstrap
require_once 'bootstrap/app.php';

// Bootstrap the application
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test Midtrans configuration
$config = config('midtrans');

echo "Midtrans Configuration Test\n";
echo "==========================\n";
echo "Server Key: " . (isset($config['server_key']) && $config['server_key'] ? substr($config['server_key'], 0, 10) . '...' : 'NOT SET') . "\n";
echo "Client Key: " . (isset($config['client_key']) && $config['client_key'] ? substr($config['client_key'], 0, 10) . '...' : 'NOT SET') . "\n";
echo "Is Production: " . (isset($config['is_production']) ? ($config['is_production'] ? 'true' : 'false') : 'NOT SET') . "\n";
echo "Is Sanitized: " . (isset($config['is_sanitized']) ? ($config['is_sanitized'] ? 'true' : 'false') : 'NOT SET') . "\n";
echo "Is 3DS: " . (isset($config['is_3ds']) ? ($config['is_3ds'] ? 'true' : 'false') : 'NOT SET') . "\n";

// Check if required keys are set
if (empty($config['server_key']) || empty($config['client_key'])) {
    echo "\nERROR: Midtrans keys are not properly configured!\n";
    exit(1);
}

echo "\nConfiguration looks good!\n";