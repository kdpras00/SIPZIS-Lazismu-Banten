<?php

// Simple test to verify the route exists
echo "Testing Midtrans notification route...\n";

// Using cURL to test the route
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://localhost/SistemZakat2/midtrans/notification");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'transaction_status' => 'settlement',
    'order_id' => 'ZKT-2025-001',
    'transaction_id' => 'txn_1234567890'
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

echo "HTTP Code: " . $httpCode . "\n";
echo "Response: " . $response . "\n";
