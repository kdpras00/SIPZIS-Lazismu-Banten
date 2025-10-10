<?php

require_once 'vendor/autoload.php';

// Load Laravel's bootstrap
require_once 'bootstrap/app.php';

// Create the application
$app = require_once 'bootstrap/app.php';

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get database connection
$db = DB::connection();

// Get table structure
try {
    $columns = $db->select("SHOW COLUMNS FROM zakat_payments");
    
    echo "Zakat Payments Table Structure:\n";
    echo "================================\n";
    
    foreach ($columns as $column) {
        echo "Field: " . $column->Field . "\n";
        echo "Type: " . $column->Type . "\n";
        echo "Null: " . $column->Null . "\n";
        echo "Key: " . $column->Key . "\n";
        echo "Default: " . $column->Default . "\n";
        echo "Extra: " . $column->Extra . "\n";
        echo "------------------------\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}