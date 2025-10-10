<?php

require_once 'vendor/autoload.php';

// Load Laravel application
$app = require_once 'bootstrap/app.php';

// Bootstrap the application
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ProgramType;

try {
    echo "Testing Program Types...\n";

    // Test creating a few program types
    $programTypes = ProgramType::all();

    echo "Found " . $programTypes->count() . " program types:\n";

    foreach ($programTypes as $type) {
        echo "- " . $type->name . " (" . $type->category . ")\n";
    }

    // Test querying by category
    echo "\nZakat types:\n";
    $zakatTypes = ProgramType::byCategory('zakat')->get();
    foreach ($zakatTypes as $type) {
        echo "- " . $type->name . "\n";
    }

    echo "\nInfaq types:\n";
    $infaqTypes = ProgramType::byCategory('infaq')->get();
    foreach ($infaqTypes as $type) {
        echo "- " . $type->name . "\n";
    }

    echo "\nShadaqah types:\n";
    $shadaqahTypes = ProgramType::byCategory('shadaqah')->get();
    foreach ($shadaqahTypes as $type) {
        echo "- " . $type->name . "\n";
    }

    echo "\nProgram Pilar types:\n";
    $pilarTypes = ProgramType::byCategory('program_pilar')->get();
    foreach ($pilarTypes as $type) {
        echo "- " . $type->name . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
