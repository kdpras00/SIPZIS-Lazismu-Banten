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

    // List all programs by category
    echo "=== ZAKAT PROGRAMS ===\n";
    $stmt = $pdo->query("SELECT name, category FROM programs WHERE category LIKE 'zakat-%' AND status = 'active'");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- " . $row['name'] . " (" . $row['category'] . ")\n";
    }

    echo "\n=== INFAQ PROGRAMS ===\n";
    $stmt = $pdo->query("SELECT name, category FROM programs WHERE category LIKE 'infaq-%' AND status = 'active'");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- " . $row['name'] . " (" . $row['category'] . ")\n";
    }

    echo "\n=== SHADAQAH PROGRAMS ===\n";
    $stmt = $pdo->query("SELECT name, category FROM programs WHERE category LIKE 'shadaqah-%' AND status = 'active'");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- " . $row['name'] . " (" . $row['category'] . ")\n";
    }

    echo "\n=== PILAR PROGRAMS ===\n";
    $stmt = $pdo->query("SELECT name, category FROM programs WHERE category IN ('pendidikan', 'kesehatan', 'ekonomi', 'sosial-dakwah', 'kemanusiaan', 'lingkungan') AND status = 'active'");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- " . $row['name'] . " (" . $row['category'] . ")\n";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
