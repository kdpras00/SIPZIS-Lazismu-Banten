<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Midtrans Configuration:\n";
echo "Server Key: " . (config('midtrans.server_key') ? 'Configured' : 'Not configured') . "\n";
echo "Client Key: " . (config('midtrans.client_key') ? 'Configured' : 'Not configured') . "\n";
echo "Is Production: " . (config('midtrans.is_production') ? 'Yes' : 'No') . "\n";
