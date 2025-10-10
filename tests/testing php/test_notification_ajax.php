<?php

require_once 'vendor/autoload.php';

use Illuminate\Contracts\Console\Kernel;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Notification;
use App\Models\Muzakki;
use Illuminate\Support\Facades\Auth;

// Simulate an authenticated user
// In a real scenario, this would be handled by the web middleware
echo "Testing notification AJAX endpoint...\n";

// Get the first muzakki
$muzakki = Muzakki::first();
if (!$muzakki) {
    echo "No muzakki found\n";
    exit(1);
}

echo "Using muzakki: " . $muzakki->name . "\n";

// Get notifications for this muzakki
$notifications = $muzakki->notifications()->latest()->limit(5)->get();

echo "Found " . $notifications->count() . " notifications\n";

foreach ($notifications as $notification) {
    echo "- " . $notification->title . ": " . $notification->message . "\n";
}

// Test the view rendering
try {
    $html = view('muzakki.partials.notifications-popup', compact('notifications'))->render();
    echo "View rendered successfully\n";
    echo "HTML length: " . strlen($html) . " characters\n";
} catch (Exception $e) {
    echo "Error rendering view: " . $e->getMessage() . "\n";
}
