<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel to load environment variables
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check what methods are available
try {
    $reflection = new ReflectionClass('Gemini\Laravel\Facades\Gemini');
    echo "Available methods in Gemini facade:\n";
    foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
        if ($method->class === 'Gemini\Laravel\Facades\Gemini') {
            echo "- " . $method->getName() . "\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Try to get the underlying client
try {
    $client = Gemini\Laravel\Facades\Gemini::getFacadeRoot();
    echo "\nClient class: " . get_class($client) . "\n";

    // Check if it has a method to get available models
    if (method_exists($client, 'listModels')) {
        echo "Client has listModels method\n";
        $models = $client->listModels();
        echo "Available models:\n";
        foreach ($models as $model) {
            echo "- " . $model->name . "\n";
        }
    } else {
        echo "Client does not have listModels method\n";
    }
} catch (Exception $e) {
    echo "Error getting client: " . $e->getMessage() . "\n";
}
