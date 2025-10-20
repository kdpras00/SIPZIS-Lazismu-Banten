<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class CampaignServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Schedule the campaign status update command to run daily
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('campaigns:update-statuses')->daily();
        });
    }
}
