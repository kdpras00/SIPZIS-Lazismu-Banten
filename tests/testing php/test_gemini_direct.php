<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel to load environment variables
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Try to use the Gemini client directly
try {
    $client = Gemini\Laravel\Facades\Gemini::getFacadeRoot();
    echo "Client class: " . get_class($client) . "\n";

    // Try to call the correct method
    $model = $client->geminiProFlash1_5();
    echo "Model class: " . get_class($model) . "\n";

    // Try to generate content
    $result = $model->generateContent('Hello, what is this system for?');
    echo "Response: " . $result->text() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Error Code: " . $e->getCode() . "\n";
    echo "Error File: " . $e->getFile() . "\n";
    echo "Error Line: " . $e->getLine() . "\n";
}
