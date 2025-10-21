<?php

function parseEnv($path)
{
    $env = [];
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            // Remove quotes if present
            $value = trim($value, '"\'');
            $env[$key] = $value;
        }
    }
    return $env;
}

// Load .env file
$env = parseEnv('.env');

// Database connection
try {
    $pdo = new PDO(
        "mysql:host={$env['DB_HOST']};dbname={$env['DB_DATABASE']};charset=utf8",
        $env['DB_USERNAME'],
        $env['DB_PASSWORD']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the migration record already exists
    $stmt = $pdo->prepare("SELECT * FROM migrations WHERE migration = '2025_10_15_151458_create_sessions_table'");
    $stmt->execute();
    $result = $stmt->fetch();

    if ($result) {
        echo "Migration record already exists.\n";
    } else {
        // Get the next batch number
        $stmt = $pdo->prepare("SELECT MAX(batch) as max_batch FROM migrations");
        $stmt->execute();
        $row = $stmt->fetch();
        $maxBatch = $row['max_batch'] ?? 0;
        $nextBatch = $maxBatch + 1;

        // Insert the migration record
        $stmt = $pdo->prepare("INSERT INTO migrations (migration, batch) VALUES ('2025_10_15_151458_create_sessions_table', ?)");
        $stmt->execute([$nextBatch]);

        echo "Migration record inserted with batch {$nextBatch}.\n";
    }

    echo "Migration status fixed successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
