<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';

// Create a kernel instance
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Try to instantiate the controller and check if methods exist
try {
    $controller = new \App\Http\Controllers\ZakatPaymentController();

    // Check if the edit method exists
    if (method_exists($controller, 'edit')) {
        echo "Edit method exists\n";
    } else {
        echo "Edit method does not exist\n";
    }

    // Check if the receipt method exists
    if (method_exists($controller, 'receipt')) {
        echo "Receipt method exists\n";
    } else {
        echo "Receipt method does not exist\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
