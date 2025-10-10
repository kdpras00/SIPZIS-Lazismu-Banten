<?php

require_once 'vendor/autoload.php';

// Load Laravel application
$app = require_once 'bootstrap/app.php';

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\ZakatPaymentController;
use Illuminate\Support\Facades\Route;

try {
    echo "Testing guest donation...\n";

    // Create a mock request
    $request = Request::create('/donasi/store', 'POST', [
        'program_category' => 'pendidikan',
        'paid_amount' => '100000',
        'payment_method' => 'gopay',
        'donor_name' => 'Test Donor',
        'donor_email' => 'test@example.com',
        'donor_phone' => '08123456789',
        'notes' => 'Test donation'
    ]);

    // Add CSRF token
    $request->setLaravelSession(app('session.store'));
    $request->session()->put('_token', 'test_csrf_token');
    $request->headers->set('X-CSRF-TOKEN', 'test_csrf_token');

    // Create controller instance
    $controller = new ZakatPaymentController();

    // Call the guestStore method
    $response = $controller->guestStore($request);

    echo "Response: " . print_r($response, true) . "\n";

    if ($response instanceof \Illuminate\Http\JsonResponse) {
        $data = $response->getData(true);
        echo "Response data: " . print_r($data, true) . "\n";

        if (isset($data['success']) && $data['success']) {
            echo "✓ Guest donation test PASSED\n";
        } else {
            echo "✗ Guest donation test FAILED\n";
            echo "Error: " . ($data['message'] ?? 'Unknown error') . "\n";
        }
    } else {
        echo "✗ Unexpected response type\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
