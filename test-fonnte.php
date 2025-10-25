<?php

require_once 'vendor/autoload.php';

use Illuminate\Http\Client\Factory;

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Create HTTP client
$http = new Factory();

// Test Fonnte API
$response = $http->withHeaders([
    'Authorization' => $_ENV['FONNTE_API_KEY'],
])->post('https://api.fonnte.com/send', [
    'target' => '6281234567890',
    'message' => 'Test message from SIPZIS',
]);

echo "Status: " . $response->status() . "\n";
echo "Body: " . $response->body() . "\n";
