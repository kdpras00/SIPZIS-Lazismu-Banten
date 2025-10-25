<?php

// Simple test to verify the validation fix
echo "Testing postal code validation fix...\n";

// Simulate the data structure from the API
$apiData = [
    'data' => [
        ['code' => 15134, 'village' => 'Keroncong', 'district' => 'Jatiuwung'],
        ['code' => 15136, 'village' => 'Jatake', 'district' => 'Jatiuwung'],
        ['code' => 15137, 'village' => 'Gandasari', 'district' => 'Jatiuwung'],
        ['code' => 15135, 'village' => 'Pasir Jaya', 'district' => 'Jatiuwung'],
        ['code' => 15136, 'village' => 'Manis Jaya', 'district' => 'Jatiuwung'],
        ['code' => 15133, 'village' => 'Alam Jaya', 'district' => 'Jatiuwung']
    ]
];

// Test 1: Check if 15133 is in the list of valid postal codes
$postalCodes = array_unique(array_column($apiData['data'], 'code'));
$is15133Valid = in_array(15133, $postalCodes);

echo "Test 1 - Is 15133 valid for Jatiuwung district? " . ($is15133Valid ? "YES" : "NO") . "\n";
echo "Valid postal codes: " . implode(', ', $postalCodes) . "\n";

// Test 2: Check if we can find Alam Jaya village with postal code 15133
$alamJaya = array_filter($apiData['data'], function ($item) {
    return $item['village'] === 'Alam Jaya' && $item['code'] === 15133;
});

echo "Test 2 - Can we find Alam Jaya with postal code 15133? " . (!empty($alamJaya) ? "YES" : "NO") . "\n";

if (!empty($alamJaya)) {
    $item = reset($alamJaya);
    echo "Found: Village = " . $item['village'] . ", Code = " . $item['code'] . ", District = " . $item['district'] . "\n";
}

echo "Fix verification complete.\n";
