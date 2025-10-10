<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel to load environment variables
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\ChatbotController;

// Create a mock request
$request = new Request();
$request->setMethod('POST');
$request->request->add(['message' => 'Hello, what is this system for?']);

// Instantiate the controller
$controller = new ChatbotController();

try {
    // Call the chat method
    $response = $controller->chat($request);

    // Get the response data
    $data = $response->getData(true);

    echo "Success: " . ($data['success'] ? 'Yes' : 'No') . "\n";
    echo "Message: " . $data['message'] . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Error Code: " . $e->getCode() . "\n";
}
