<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';

// Create a kernel instance
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Try to get a payment and test its relationships
try {
    $payment = \App\Models\ZakatPayment::first();

    if (!$payment) {
        echo "No payments found\n";
        exit;
    }

    echo "Payment ID: " . $payment->id . "\n";
    echo "Payment code: " . $payment->payment_code . "\n";
    echo "Received by ID: " . ($payment->received_by ?? 'null') . "\n";

    // Try to load the relationships
    $payment->load(['muzakki', 'receivedBy']);

    echo "Muzakki loaded: " . ($payment->muzakki ? 'yes' : 'no') . "\n";
    echo "Received by loaded: " . ($payment->receivedBy ? 'yes' : 'no') . "\n";

    // Try to render the views
    try {
        $editView = view('payments.edit', compact('payment'))->render();
        echo "Edit view rendered successfully\n";
    } catch (Exception $e) {
        echo "Error rendering edit view: " . $e->getMessage() . "\n";
    }

    try {
        $receiptView = view('payments.receipt', compact('payment'))->render();
        echo "Receipt view rendered successfully\n";
    } catch (Exception $e) {
        echo "Error rendering receipt view: " . $e->getMessage() . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
