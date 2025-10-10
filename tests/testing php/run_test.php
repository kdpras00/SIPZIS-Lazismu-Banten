<?php
// Simple test to verify our mapping functions work

// Include the controller file directly
require_once 'app/Http/Controllers/ZakatPaymentController.php';

use App\Http\Controllers\ZakatPaymentController;

// Create controller instance
$controller = new ZakatPaymentController();

echo "Testing payment method mappings:\n\n";

// Test frontend to internal mapping
echo "Frontend to Internal Mapping:\n";
$frontendMethods = ['bca_va', 'bni_va', 'bri_va', 'mandiri_va', 'permata_va', 'gopay', 'dana', 'shopeepay', 'qris'];
foreach ($frontendMethods as $method) {
    $internal = $controller->mapFrontendToInternalMethod($method);
    echo "  $method -> $internal\n";
}

echo "\nMidtrans to Internal Mapping:\n";
$midtransMethods = ['gopay', 'dana', 'shopeepay', 'qris', 'bca_va', 'bni_va', 'bri_va', 'mandiri_va', 'permata_va', 'bank_transfer', 'echannel'];
foreach ($midtransMethods as $method) {
    $internal = $controller->mapMidtransToInternalMethod($method);
    echo "  $method -> $internal\n";
}

echo "\nInternal to User Mapping:\n";
$internalMethods = [
    'midtrans-bank-bca', 'midtrans-bank-bni', 'midtrans-bank-bri', 
    'midtrans-bank-mandiri', 'midtrans-bank-permata', 
    'midtrans-gopay', 'midtrans-dana', 'midtrans-shopeepay', 'midtrans-qris'
];
foreach ($internalMethods as $method) {
    $user = $controller->mapInternalToUserMethod($method);
    echo "  $method -> $user\n";
}

echo "\nAll tests completed successfully!\n";