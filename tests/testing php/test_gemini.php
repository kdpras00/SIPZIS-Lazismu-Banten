<?php
require_once 'vendor/autoload.php';

use Gemini\Client;

// Get the API key from the .env file
$apiKey = getenv('GEMINI_API_KEY') ?: $_ENV['GEMINI_API_KEY'] ?? null;

if (!$apiKey) {
    echo "API key not found in environment variables\n";
    exit(1);
}

echo "API Key: " . substr($apiKey, 0, 5) . "..." . substr($apiKey, -5) . "\n";

try {
    $client = new Client($apiKey);
    $response = $client->geminiPro()->generateContent('Hello, what is this system for?');
    echo "Response: " . $response->text() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Error Code: " . $e->getCode() . "\n";
}
