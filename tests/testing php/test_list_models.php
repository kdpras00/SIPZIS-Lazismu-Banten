<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel to load environment variables
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Try to use the Gemini client directly
try {
    $client = Gemini\Laravel\Facades\Gemini::getFacadeRoot();
    echo "Client class: " . get_class($client) . "\n";

    // List available models
    $models = $client->listModels();
    echo "Available models:\n";
    foreach ($models->models as $model) {
        echo "- " . $model->name . " (display name: " . ($model->displayName ?? 'N/A') . ")\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Error Code: " . $e->getCode() . "\n";
    echo "Error File: " . $e->getFile() . "\n";
    echo "Error Line: " . $e->getLine() . "\n";
}
