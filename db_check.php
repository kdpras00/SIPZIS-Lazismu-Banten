<?php
// Database configuration from .env
$host = '127.0.0.1';
$dbname = 'sipz';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check campaigns and their payments
    $stmt = $pdo->query("SELECT c.id, c.title, c.program_category, COUNT(zp.id) as payment_count, SUM(zp.paid_amount) as total_collected 
                         FROM campaigns c 
                         LEFT JOIN zakat_payments zp ON zp.program_category = c.program_category AND zp.status = 'completed'
                         GROUP BY c.id, c.title, c.program_category
                         ORDER BY c.program_category");

    echo "Campaigns and their payments:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "  Campaign: " . $row['title'] . " (Category: " . $row['program_category'] . ") - " . $row['payment_count'] . " payments, Total: " . $row['total_collected'] . "\n";
    }

    echo "\n";

    // Check if there are any payments that don't match any program or campaign category
    $stmt = $pdo->query("SELECT zp.id, zp.payment_code, zp.program_category, zp.paid_amount 
                         FROM zakat_payments zp 
                         WHERE zp.status = 'completed' 
                         AND zp.program_category NOT IN (SELECT DISTINCT category FROM programs) 
                         AND zp.program_category NOT IN (SELECT DISTINCT program_category FROM campaigns)
                         AND zp.program_category IS NOT NULL 
                         AND zp.program_category != ''");

    echo "Payments with unmatched categories:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "  Payment: " . $row['payment_code'] . " (Category: " . $row['program_category'] . ") - Amount: " . $row['paid_amount'] . "\n";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
