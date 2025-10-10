<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel to load environment variables
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Check what methods are available in the Gemini\Client class
try {
    $client = new Gemini\Client(config('gemini.api_key'));
    $reflection = new ReflectionClass($client);
    echo "Available methods in Gemini\Client:\n";
    foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
        if ($method->class === 'Gemini\Client') {
            echo "- " . $method->getName() . "\n";
        }
    }

    echo "\nAvailable models:\n";
    // Try to access the models property
    $models = $client->models();
    $modelReflection = new ReflectionClass($models);
    foreach ($modelReflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
        echo "- " . $method->getName() . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
