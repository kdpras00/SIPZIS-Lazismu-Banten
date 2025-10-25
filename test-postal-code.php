<?php

// Simple test script for postal code validation
$data = [
    'district' => 'Jatiuwung',
    'village' => 'Alam Jaya'
];

$options = [
    'http' => [
        'header'  => "Content-Type: application/json\r\n" .
            "X-CSRF-TOKEN: \r\n",
        'method'  => 'POST',
        'content' => json_encode($data)
    ]
];

$context  = stream_context_create($options);
$result = file_get_contents('http://127.0.0.1:8000/regions/validate-postal-code', false, $context);

echo $result;
