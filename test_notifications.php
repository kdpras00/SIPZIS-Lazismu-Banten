<?php

require_once 'vendor/autoload.php';

use App\Models\Notification;
use App\Models\Muzakki;
use App\Models\ZakatPayment;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test creating different types of notifications
echo "Testing notification system...\n";

// Get a muzakki for testing
$muzakki = Muzakki::first();
if (!$muzakki) {
    echo "No muzakki found for testing\n";
    exit(1);
}

echo "Using muzakki: {$muzakki->name}\n";

// Get a payment for testing
$payment = ZakatPayment::first();
if (!$payment) {
    echo "No payment found for testing\n";
    exit(1);
}

echo "Using payment: {$payment->payment_code}\n";

// Test creating a payment notification
echo "Creating payment notification...\n";
$paymentNotification = Notification::createPaymentNotification($muzakki, $payment, 'completed');
echo "Created payment notification: {$paymentNotification->title}\n";

// Test creating an account notification
echo "Creating account notification...\n";
$accountNotification = Notification::createAccountNotification($muzakki->user, 'password');
echo "Created account notification: {$accountNotification->title}\n";

// Test creating a reminder notification
echo "Creating reminder notification...\n";
$reminderNotification = Notification::createReminderNotification($muzakki, 'zakat');
echo "Created reminder notification: {$reminderNotification->title}\n";

// Test creating a message notification
echo "Creating message notification...\n";
$messageNotification = Notification::createMessageNotification($muzakki->user, 'Terima kasih atas partisipasi Anda');
echo "Created message notification: {$messageNotification->title}\n";

// Test retrieving notifications
echo "Retrieving notifications for muzakki...\n";
$notifications = $muzakki->notifications()->latest()->limit(5)->get();
echo "Found {$notifications->count()} notifications:\n";

foreach ($notifications as $notification) {
    echo "- {$notification->title}: {$notification->message}\n";
}

echo "Notification system test completed successfully!\n";
