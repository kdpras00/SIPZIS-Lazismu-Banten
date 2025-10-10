<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel to load environment variables
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Try to use the Gemini facade with the correct model
try {
    $result = Gemini\Laravel\Facades\Gemini::gemini15Flash()->generateContent('Hello, what is this system for?');
    echo "Response: " . $result->text() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Error Code: " . $e->getCode() . "\n";
    echo "Error Type: " . get_class($e) . "\n";
}
