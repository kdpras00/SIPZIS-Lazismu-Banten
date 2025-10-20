<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\UpdateCampaignStatuses;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Register the campaign status update command
Artisan::command('campaigns:update-statuses', function () {
    $this->call(UpdateCampaignStatuses::class);
})->purpose('Automatically update campaign statuses when they reach their end date');

// Schedule the command to run daily
// This would typically be done in a service provider or kernel file
// For now, we'll just register the command here
