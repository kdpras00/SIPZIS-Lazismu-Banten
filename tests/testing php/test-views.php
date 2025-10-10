<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';

// Create a kernel instance
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Try to render the views
try {
    // Get a payment record
    $payment = \App\Models\ZakatPayment::first();

    if (!$payment) {
        echo "No payments found in database\n";
        exit;
    }

    // Load relationships
    $payment->load(['muzakki', 'receivedBy']);

    // Test if we can render the edit view
    $editView = view('payments.edit', compact('payment'))->render();
    echo "Edit view rendered successfully\n";

    // Test if we can render the receipt view
    $receiptView = view('payments.receipt', compact('payment'))->render();
    echo "Receipt view rendered successfully\n";

    echo "Both views rendered successfully!\n";
} catch (Exception $e) {
    echo "Error rendering views: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
