<?php
// Test script to verify payment method fix

require_once 'vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;

// Create a service container
$container = new Container();

// Create a new app instance
$app = new \Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

// Bootstrap the application
$app->bootstrapWith([
    \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
    \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
    \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
    \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
    \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
    \Illuminate\Foundation\Bootstrap\BootProviders::class,
]);

// Load the configuration
$app->loadEnvironmentFrom('.env');

// Initialize the database connection
$capsule = new Capsule($app);
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
]);

$capsule->setEventDispatcher(new Dispatcher($app));
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Test the payment method mapping functions
echo "Testing payment method mapping functions...\n";

// Include the controller file to access the mapping functions
require_once 'app/Http/Controllers/ZakatPaymentController.php';

// Create a mock controller instance
$controller = new \App\Http\Controllers\ZakatPaymentController();

// Test frontend to internal mapping
echo "\nTesting frontend to internal mapping:\n";
$frontendMethods = ['bca_va', 'bni_va', 'gopay', 'dana', 'shopeepay', 'qris'];
foreach ($frontendMethods as $method) {
    $internal = $controller->mapFrontendToInternalMethod($method);
    echo "Frontend: $method -> Internal: $internal\n";
}

// Test Midtrans to internal mapping
echo "\nTesting Midtrans to internal mapping:\n";
$midtransMethods = ['gopay', 'dana', 'bca_va', 'bni_va', 'bank_transfer'];
foreach ($midtransMethods as $method) {
    $internal = $controller->mapMidtransToInternalMethod($method);
    echo "Midtrans: $method -> Internal: $internal\n";
}

// Test internal to user mapping
echo "\nTesting internal to user mapping:\n";
$internalMethods = ['midtrans-gopay', 'midtrans-bank-bca', 'midtrans-bank-bni', 'midtrans-dana'];
foreach ($internalMethods as $method) {
    $user = $controller->mapInternalToUserMethod($method);
    echo "Internal: $method -> User: $user\n";
}

echo "\nTest completed.\n";