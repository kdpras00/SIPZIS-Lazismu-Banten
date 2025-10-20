<?php
require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

use App\Models\ZakatPayment;
use App\Models\Program;

// Check if there are any completed payments
$completedPayments = ZakatPayment::completed()->count();
echo 'Completed payments: ' . $completedPayments . PHP_EOL;

// Check a specific program
$program = Program::first();
if ($program) {
    echo 'Program: ' . $program->name . PHP_EOL;
    echo 'Target amount: ' . $program->target_amount . PHP_EOL;
    echo 'Total collected: ' . $program->total_collected . PHP_EOL;
    echo 'Progress percentage: ' . $program->progress_percentage . PHP_EOL;
    echo 'Formatted total collected: ' . $program->formatted_total_collected . PHP_EOL;
    echo 'Formatted total target: ' . $program->formatted_total_target . PHP_EOL;
} else {
    echo 'No programs found' . PHP_EOL;
}
