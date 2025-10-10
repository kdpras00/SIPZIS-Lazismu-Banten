<?php

require_once 'vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Database\Capsule\Manager as Capsule;

// Create a service container
$container = new Container();

// Create a database capsule
$capsule = new Capsule($container);
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'sipz',
    'username'  => 'root',
    'password' => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setEventDispatcher(new Dispatcher($container));
$capsule->setAsGlobal();
$capsule->bootEloquent();

try {
    // Test the ekonomi program
    $program = \App\Models\Program::where('category', 'ekonomi')->first();

    if (!$program) {
        echo "No ekonomi program found\n";
        exit;
    }

    echo "Program: " . $program->name . "\n";
    echo "Category: " . $program->category . "\n";
    echo "Target Amount: " . $program->target_amount . "\n";
    echo "Total Target: " . $program->total_target . "\n";
    echo "Total Collected: " . $program->total_collected . "\n";
    echo "Progress Percentage: " . $program->progress_percentage . "%\n";

    // Check campaigns
    $campaigns = $program->campaigns;
    echo "Campaigns count: " . $campaigns->count() . "\n";

    foreach ($campaigns as $campaign) {
        echo "  Campaign: " . $campaign->title . "\n";
        echo "  Campaign Payments: " . $campaign->zakatPayments()->completed()->count() . "\n";
        echo "  Campaign Payment Sum: " . $campaign->zakatPayments()->completed()->sum('paid_amount') . "\n";
    }

    // Check direct payments to the program category
    echo "Direct payments to ekonomi category: " . \App\Models\ZakatPayment::completed()->byProgramCategory('ekonomi')->count() . "\n";
    echo "Direct payment sum for ekonomi: " . \App\Models\ZakatPayment::completed()->byProgramCategory('ekonomi')->sum('paid_amount') . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
