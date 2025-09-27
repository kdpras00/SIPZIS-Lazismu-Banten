<?php

// Read .env file
$envContent = file_get_contents('.env');

// Parse the environment variables
$envVars = [];
$lines = explode("\n", $envContent);
foreach ($lines as $line) {
    if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
        list($key, $value) = explode('=', $line, 2);
        $envVars[trim($key)] = trim($value);
    }
}

echo "Midtrans Configuration Check\n";
echo "==========================\n";

// Check Midtrans configuration
$serverKey = $envVars['MIDTRANS_SERVER_KEY'] ?? '';
$clientKey = $envVars['MIDTRANS_CLIENT_KEY'] ?? '';
$isProduction = $envVars['MIDTRANS_IS_PRODUCTION'] ?? 'false';
$isSanitized = $envVars['MIDTRANS_IS_SANITIZED'] ?? 'true';
$is3ds = $envVars['MIDTRANS_IS_3DS'] ?? 'true';

echo "Server Key: " . ($serverKey ? substr($serverKey, 0, 10) . '...' : 'NOT SET') . "\n";
echo "Client Key: " . ($clientKey ? substr($clientKey, 0, 10) . '...' : 'NOT SET') . "\n";
echo "Is Production: " . $isProduction . "\n";
echo "Is Sanitized: " . $isSanitized . "\n";
echo "Is 3DS: " . $is3ds . "\n";

// Validate the keys
if (empty($serverKey) || empty($clientKey)) {
    echo "\nERROR: Midtrans keys are not properly configured in .env file!\n";
    exit(1);
}

echo "\nConfiguration looks good!\n";
echo "Server Key Length: " . strlen($serverKey) . " characters\n";
echo "Client Key Length: " . strlen($clientKey) . " characters\n";