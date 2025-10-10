<?php
require_once 'vendor/autoload.php';

use Gemini\Client;
use GeminiAPI\GenerativeModel;
use GuzzleHttp\Client as GuzzleClient;
use GeminiAPI\Transporters\HttpTransporter;

// Get the API key from config
$apiKey = getenv('GEMINI_API_KEY') ?: 'AIzaSyCmSlRCCPgC1ph4vuco9hwLsTaDtnBPcSA';

try {
    // Create a transporter
    $transporter = new HttpTransporter($apiKey, new GuzzleClient());
    
    // Create a client
    $client = new Client($transporter);
    
    // Try to use gemini-pro model
    $model = $client->geminiPro();
    
    // Create a simple prompt
    $prompt = 'Hello, what is this system for?';
    
    // Generate content
    $result = $model->generateContent($prompt);
    
    echo "Response: " . $result->text() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Error Code: " . $e->getCode() . "\n";
    echo "Error File: " . $e->getFile() . "\n";
    echo "Error Line: " . $e->getLine() . "\n";
}