<?php

require_once 'bootstrap/app.php';

use App\Models\Notification;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Notification System Test Results ===\n\n";

// Count total notifications
$total = Notification::count();
echo "Total notifications in system: " . $total . "\n";

// Count test notifications
$testCount = Notification::where('message', 'like', '%Test System:%')
    ->orWhere('message', 'like', '%Test notifikasi untuk semua pengguna%')
    ->orWhere('message', 'like', '%Pengumuman penting untuk semua pengguna sistem zakat%')
    ->count();

echo "Test notifications: " . $testCount . "\n";

// Show latest notifications
echo "\nLatest 5 notifications:\n";
$notifications = Notification::latest()->limit(5)->get();
foreach ($notifications as $notification) {
    echo "- [" . $notification->type . "] " . $notification->title . ": " . $notification->message . "\n";
    echo "  To: " . ($notification->user ? $notification->user->name : 'N/A') . " (" . ($notification->user ? $notification->user->email : 'N/A') . ")\n";
    echo "  Created: " . $notification->created_at->diffForHumans() . "\n\n";
}

echo "=== Test Complete ===\n";
