<?php
require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Check if the column exists
$columns = DB::select('SHOW COLUMNS FROM zakat_payments LIKE "midtrans_payment_method"');
if (count($columns) > 0) {
    echo "Column 'midtrans_payment_method' exists in zakat_payments table\n";
} else {
    echo "Column 'midtrans_payment_method' does NOT exist in zakat_payments table\n";
}

// List all columns in the table
$allColumns = DB::select('SHOW COLUMNS FROM zakat_payments');
echo "All columns in zakat_payments table:\n";
foreach ($allColumns as $column) {
    echo "- " . $column->Field . " (" . $column->Type . ")\n";
}

// Simple script to check if specific columns exist in the zakat_payments table
$host = '127.0.0.1';
$dbname = 'sipz';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Check if specific columns exist
    $columnsToCheck = [
        'midtrans_order_id',
        'program_category',
        'program_type_id',
        'midtrans_payment_method',
        'payment_reference'
    ];

    echo "Checking if columns exist in zakat_payments table:\n";
    echo "==================================================\n";

    foreach ($columnsToCheck as $column) {
        $stmt = $pdo->prepare("SHOW COLUMNS FROM zakat_payments LIKE ?");
        $stmt->execute([$column]);
        $result = $stmt->fetch();

        if ($result) {
            echo "✓ $column: EXISTS\n";
            echo "  Type: " . $result['Type'] . "\n";
            echo "  Null: " . $result['Null'] . "\n";
            echo "  Default: " . ($result['Default'] ?? 'NULL') . "\n";
        } else {
            echo "✗ $column: DOES NOT EXIST\n";
        }
        echo "\n";
    }

    // Check a sample record to see what data is actually stored
    echo "Checking sample record data:\n";
    echo "==========================\n";

    $stmt = $pdo->query("SELECT id, payment_code, midtrans_order_id, program_category, program_type_id, midtrans_payment_method, payment_reference, status FROM zakat_payments LIMIT 1");
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($record) {
        foreach ($record as $key => $value) {
            echo "$key: " . ($value ?? 'NULL') . "\n";
        }
    } else {
        echo "No records found in zakat_payments table\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
