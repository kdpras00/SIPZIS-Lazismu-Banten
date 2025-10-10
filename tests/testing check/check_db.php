<?php
require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Use Laravel's database connection
try {
    $count = DB::table('program_types')->count();
    echo "Program Types Count: " . $count . "\n";

    if ($count > 0) {
        $types = DB::table('program_types')->get();
        foreach ($types as $type) {
            echo "ID: " . $type->id . " | Name: " . $type->name . " | Category: " . $type->category . "\n";
        }
    }

    echo "\n";

    $programCount = DB::table('programs')->count();
    echo "Programs Count: " . $programCount . "\n";

    if ($programCount > 0) {
        $programs = DB::table('programs')->get();
        foreach ($programs as $program) {
            echo "ID: " . $program->id . " | Category: " . $program->category . "\n";
        }
    } else {
        echo "No programs found in the database.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
