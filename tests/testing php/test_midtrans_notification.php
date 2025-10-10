<?php

require_once 'vendor/autoload.php';

use Illuminate\Http\Request;

// Create a mock request to test our notification handler
$controller = new App\Http\Controllers\ZakatPaymentController();

// Mock a notification request
$request = Request::create('/midtrans/notification', 'POST', [
    'transaction_status' => 'settlement',
    'order_id' => 'ZKT-2025-001-1234567890-abcdef',
    'transaction_id' => 'txn_1234567890',
    'payment_type' => 'bank_transfer'
]);

// Handle the notification
$response = $controller->handleNotification($request);

echo "Response: " . $response->getContent();
