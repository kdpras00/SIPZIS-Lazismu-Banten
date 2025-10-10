<?php
require_once 'vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database configuration
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_DATABASE'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to check programs
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM programs");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "Number of programs in database: " . $result['count'] . "\n";

    if ($result['count'] > 0) {
        echo "Programs found:\n";
        $stmt = $pdo->query("SELECT * FROM programs LIMIT 10");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- " . $row['name'] . " (" . $row['category'] . ")\n";
        }
    } else {
        echo "No programs found in database.\n";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
