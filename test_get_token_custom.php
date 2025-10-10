<?php
require_once 'vendor/autoload.php';

use Illuminate\Http\Request;
use App\Http\Controllers\ZakatPaymentController;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test getTokenCustom method to ensure it doesn't overwrite program data
echo "Testing getTokenCustom method...\n";

// Get the latest payment
$latestPayment = App\Models\ZakatPayment::latest()->first();
if (!$latestPayment) {
    echo "No payment found. Please run test_guest_store.php first.\n";
    exit(1);
}

echo "Using payment: {$latestPayment->payment_code}\n";
echo "Before update - Program Category: {$latestPayment->program_category}, Program Type ID: {$latestPayment->program_type_id}\n";

// Create a mock request for getTokenCustom
$request = new Illuminate\Http\Request();
$request->setMethod('POST');
$request->request->add([
    'method' => 'gopay'
]);

// Create controller instance and call getTokenCustom
$controller = new ZakatPaymentController();
$response = $controller->getTokenCustom($request, $latestPayment->payment_code);

echo "Response status: " . $response->getStatusCode() . "\n";

// Refresh the payment data
$latestPayment->refresh();
echo "After update - Program Category: {$latestPayment->program_category}, Program Type ID: {$latestPayment->program_type_id}\n";

echo "Test completed!\n";
