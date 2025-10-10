<?php

// Simple script to check table structure
$host = '127.0.0.1';
$dbname = 'sipz';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $stmt = $pdo->query("DESCRIBE zakat_payments");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Zakat Payments Table Structure:\n";
    echo "================================\n";
    
    foreach ($columns as $column) {
        echo "Field: " . $column['Field'] . "\n";
        echo "Type: " . $column['Type'] . "\n";
        echo "Null: " . $column['Null'] . "\n";
        echo "Key: " . $column['Key'] . "\n";
        echo "Default: " . $column['Default'] . "\n";
        echo "Extra: " . $column['Extra'] . "\n";
        echo "------------------------\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}