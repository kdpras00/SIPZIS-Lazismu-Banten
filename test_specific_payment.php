<?php

require_once 'vendor/autoload.php';

// Load Laravel application
$app = require_once 'bootstrap/app.php';

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Use the DB facade to test an insert
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

try {
    echo "Testing payment creation...\n";

    // Try to insert a test record similar to what the guestStore method does
    $result = DB::table('zakat_payments')->insert([
        'payment_code' => 'ZKT-TEST-001',
        'muzakki_id' => 1,
        'zakat_type_id' => null,
        'zakat_amount' => null,
        'paid_amount' => 100000,
        'payment_method' => 'gopay',
        'midtrans_payment_method' => 'midtrans-gopay',
        'payment_date' => date('Y-m-d H:i:s'),
        'status' => 'pending',
        'program_category' => 'umum',
        'notes' => 'Test payment',
        'is_guest_payment' => true,
        'receipt_number' => 'RCP-TEST-0001',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    echo "Insert successful: " . ($result ? 'true' : 'false') . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

use Midtrans\Config;
use Midtrans\Snap;
use App\Models\ZakatPayment;

try {
    // Load the specific payment
    $payment = ZakatPayment::where('payment_code', 'ZKT-2025-002')->first();

    if (!$payment) {
        echo "Payment not found!\n";
        exit;
    }

    // Load muzakki relationship
    $payment->load('muzakki');

    echo "Payment Details:\n";
    echo "Payment Code: " . $payment->payment_code . "\n";
    echo "Paid Amount: " . $payment->paid_amount . "\n";
    echo "Payment Method: " . $payment->payment_method . "\n";
    echo "Is Guest Payment: " . ($payment->is_guest_payment ? 'Yes' : 'No') . "\n";

    if ($payment->muzakki) {
        echo "Muzakki Name: " . $payment->muzakki->name . "\n";
        echo "Muzakki Email: " . $payment->muzakki->email . "\n";
    } else {
        echo "Muzakki not found!\n";
    }

    // Set Midtrans configuration
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = config('midtrans.is_sanitized');
    Config::$is3ds = config('midtrans.is_3ds');

    // Test with a specific method that's known to work
    $method = 'gopay';

    echo "\nAttempting to generate Snap Token with method: " . $method . "\n";

    // Parameter dasar
    $params = [
        'transaction_details' => [
            'order_id' => $payment->payment_code,
            'gross_amount' => (int) $payment->paid_amount,
        ],
        'customer_details' => [
            'first_name' => $payment->muzakki->name ?? 'Anonymous',
            'email' => $payment->muzakki->email ?? 'anonymous@example.com',
        ],
    ];

    // Mapping metode ke Midtrans channel dan enabled_payments
    switch (strtolower($method)) {
        case 'bca_va':
            $params['payment_type'] = 'bank_transfer';
            $params['bank_transfer'] = ['bank' => 'bca'];
            $params['enabled_payments'] = ['bca_va'];
            break;
        case 'bni_va':
            $params['payment_type'] = 'bank_transfer';
            $params['bank_transfer'] = ['bank' => 'bni'];
            $params['enabled_payments'] = ['bni_va'];
            break;
        case 'bri_va':
            $params['payment_type'] = 'bank_transfer';
            $params['bank_transfer'] = ['bank' => 'bri'];
            $params['enabled_payments'] = ['bri_va'];
            break;
        case 'mandiri_va':
            $params['payment_type'] = 'echannel';
            $params['enabled_payments'] = ['mandiri_va'];
            break;
        case 'permata_va':
            $params['payment_type'] = 'bank_transfer';
            $params['bank_transfer'] = ['bank' => 'permata'];
            $params['enabled_payments'] = ['permata_va'];
            break;
        case 'gopay':
            $params['payment_type'] = 'gopay';
            $params['enabled_payments'] = ['gopay'];
            break;
        case 'dana':
            $params['payment_type'] = 'dana';
            $params['enabled_payments'] = ['dana'];
            break;
        case 'shopeepay':
            $params['payment_type'] = 'shopeepay';
            $params['enabled_payments'] = ['shopeepay'];
            break;
        case 'qris':
            $params['payment_type'] = 'qris';
            $params['enabled_payments'] = ['qris'];
            break;
        default:
            echo "Invalid payment method: " . $method . "\n";
            exit;
    }

    echo "Parameters:\n";
    print_r($params);

    // Try to generate a snap token
    $snapToken = Snap::getSnapToken($params);

    echo "SUCCESS! Snap Token: " . $snapToken . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
