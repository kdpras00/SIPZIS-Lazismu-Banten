<?php

require_once 'vendor/autoload.php';

use Illuminate\Contracts\Console\Kernel;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Notification;

echo "Total notifications: " . Notification::count() . "\n";

$notifications = Notification::latest()->limit(5)->get();
foreach ($notifications as $notification) {
    echo "- " . $notification->title . ": " . $notification->message . "\n";
}
