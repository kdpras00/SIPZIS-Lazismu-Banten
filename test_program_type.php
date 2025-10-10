<?php

require_once 'vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;

// Create a service container
$container = new Container();

// Create a database capsule
$capsule = new Capsule($container);
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'sistem_zakat',
    'username'  => 'root',
    'password' => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods
$capsule->setAsGlobal();

// Setup the Eloquent ORM
$capsule->bootEloquent();

// Test the fix
echo "Testing program type and category fix...\n";

// Get a sample payment
$payment = \App\Models\ZakatPayment::first();

if ($payment) {
    echo "Sample payment found:\n";
    echo "- Payment Code: " . $payment->payment_code . "\n";
    echo "- Program Category: " . ($payment->program_category ?: 'Not set') . "\n";
    echo "- Program Type ID: " . ($payment->program_type_id ?: 'Not set') . "\n";

    if ($payment->programType) {
        echo "- Program Type Name: " . $payment->programType->name . "\n";
        echo "- Program Type Category: " . $payment->programType->category . "\n";
    } else {
        echo "- No program type associated\n";
    }
} else {
    echo "No payments found in the database.\n";
}

echo "Test completed.\n";
