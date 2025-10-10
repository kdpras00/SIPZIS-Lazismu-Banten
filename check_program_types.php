<?php

// Include the Laravel application
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check program types
echo "Available Program Types:\n";
$types = App\Models\ProgramType::all();
foreach ($types as $type) {
    echo "ID: " . $type->id . " | Name: " . $type->name . " | Category: " . $type->category . "\n";
}
