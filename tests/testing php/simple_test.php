<?php
// Simple test to verify our mapping functions work

// Include the controller file directly
require_once 'app/Http/Controllers/ZakatPaymentController.php';

// Create a simple test
echo "Testing payment method mapping functions...\n";

// Create an instance of the controller
$controller = new App\Http\Controllers\ZakatPaymentController();

// Test the mapping functions
echo "Testing mapFrontendToInternalMethod:\n";
$result = $controller->mapFrontendToInternalMethod('bca_va');
echo "bca_va -> " . ($result ?: 'NULL') . "\n";

echo "Testing mapMidtransToInternalMethod:\n";
$result = $controller->mapMidtransToInternalMethod('gopay');
echo "gopay -> " . ($result ?: 'NULL') . "\n";

echo "Testing mapInternalToUserMethod:\n";
$result = $controller->mapInternalToUserMethod('midtrans-gopay');
echo "midtrans-gopay -> " . ($result ?: 'NULL') . "\n";

echo "All tests completed!\n";