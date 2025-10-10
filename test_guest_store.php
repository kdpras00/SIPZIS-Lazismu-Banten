<?php
require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Http\Request;
use App\Http\Controllers\ZakatPaymentController;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Create a mock request to test guestStore method
echo "Testing guestStore method with program_type_id...\n";

// Create a test muzakki
$muzakki = App\Models\Muzakki::firstOrCreate(
    ['email' => 'test2@example.com'],
    [
        'name' => 'Test Donor 2',
        'phone' => '08123456790',
        'is_active' => true,
    ]
);

echo "Using muzakki: ID={$muzakki->id}, Name={$muzakki->name}\n";

// Get a sample program type
$programType = App\Models\ProgramType::first();
echo "Using program type: ID={$programType->id}, Name={$programType->name}, Category={$programType->category}\n";

// Create a mock request with program_type_id
$request = new Illuminate\Http\Request();
$request->setMethod('POST');
$request->request->add([
    'program_type_id' => $programType->id,
    'paid_amount' => 75000,
    'donor_name' => 'Test Donor 2',
    'donor_email' => 'test2@example.com',
    'donor_phone' => '08123456790'
]);

// Create controller instance and call guestStore
$controller = new ZakatPaymentController();
$response = $controller->guestStore($request);

echo "Response: " . print_r($response, true) . "\n";

// Check if payment was created correctly
$latestPayment = App\Models\ZakatPayment::latest()->first();
if ($latestPayment) {
    echo "Latest payment created:\n";
    echo "  Payment Code: {$latestPayment->payment_code}\n";
    echo "  Program Category: {$latestPayment->program_category}\n";
    echo "  Program Type ID: {$latestPayment->program_type_id}\n";
    echo "  Program Type Name: " . ($latestPayment->programType ? $latestPayment->programType->name : 'N/A') . "\n";
    echo "  Paid Amount: {$latestPayment->paid_amount}\n";
} else {
    echo "No payment found.\n";
}

echo "Test completed!\n";
