<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel to load environment variables
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Try to get the API key through Laravel's config system
$apiKey = config('services.gemini.api_key');

if (!$apiKey) {
    echo "API key not found in Laravel config\n";
    exit(1);
}

echo "API Key exists in config: " . (strlen($apiKey) > 0 ? "Yes" : "No") . "\n";
echo "API Key length: " . strlen($apiKey) . "\n";

// Try to use the Gemini facade
try {
    $result = Gemini\Laravel\Facades\Gemini::geminiPro()->generateContent('Hello, what is this system for?');
    echo "Response: " . $result->text() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Error Code: " . $e->getCode() . "\n";
}
