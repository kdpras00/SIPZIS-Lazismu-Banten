<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get the first Muzakki record
$muzakki = App\Models\Muzakki::first();

if ($muzakki) {
    echo "Phone: " . $muzakki->phone . "\n";
    echo "Phone Verified: " . ($muzakki->phone_verified ? 'true' : 'false') . "\n";
} else {
    echo "No Muzakki records found.\n";
}
