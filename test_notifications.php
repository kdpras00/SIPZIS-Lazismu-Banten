<?php

require_once 'bootstrap/app.php';

use App\Models\Muzakki;
use App\Models\Notification;

// Get the first muzakki
$muzakki = Muzakki::first();

if ($muzakki) {
    echo "Muzakki: " . $muzakki->name . "\n";
    echo "Total notifications: " . $muzakki->notifications()->count() . "\n";
    echo "Unread notifications: " . $muzakki->notifications()->unread()->count() . "\n";

    // Get latest notifications
    $notifications = $muzakki->notifications()->latest()->limit(3)->get();
    echo "Latest notifications:\n";
    foreach ($notifications as $notification) {
        echo "- " . $notification->title . ": " . $notification->message . "\n";
    }
} else {
    echo "No muzakki found\n";
}
