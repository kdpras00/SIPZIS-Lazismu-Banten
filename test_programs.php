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

    // Test our new queries
    echo "Testing new queries:\n";

    // Test zakat programs
    $stmt = $pdo->query("SELECT * FROM programs WHERE category LIKE 'zakat-%' AND status = 'active'");
    $zakatCount = $stmt->rowCount();
    echo "Zakat programs: " . $zakatCount . "\n";

    // Test infaq programs
    $stmt = $pdo->query("SELECT * FROM programs WHERE category LIKE 'infaq-%' AND status = 'active'");
    $infaqCount = $stmt->rowCount();
    echo "Infaq programs: " . $infaqCount . "\n";

    // Test shadaqah programs
    $stmt = $pdo->query("SELECT * FROM programs WHERE category LIKE 'shadaqah-%' AND status = 'active'");
    $shadaqahCount = $stmt->rowCount();
    echo "Shadaqah programs: " . $shadaqahCount . "\n";

    // Test pilar programs
    $stmt = $pdo->query("SELECT * FROM programs WHERE category IN ('pendidikan', 'kesehatan', 'ekonomi', 'sosial-dakwah', 'kemanusiaan', 'lingkungan') AND status = 'active'");
    $pilarCount = $stmt->rowCount();
    echo "Pilar programs: " . $pilarCount . "\n";

    echo "\nTotal programs found: " . ($zakatCount + $infaqCount + $shadaqahCount + $pilarCount) . "\n";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
