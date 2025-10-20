<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Jalankan command expire campaigns setiap hari pukul 01:00 (1 pagi)
        $schedule->command('campaigns:update-statuses')
            ->dailyAt('01:00')
            ->withoutOverlapping()
            ->onSuccess(function () {
                // Optional: kirim notifikasi jika ada campaign yang expired
                Log::info('Campaign expiration job completed successfully');
            })
            ->onFailure(function () {
                Log::error('Campaign expiration job failed');
            });

        // Atau gunakan ini untuk menjalankan setiap jam:
        // $schedule->command('campaigns:update-statuses')->hourly();

        // Atau gunakan ini untuk menjalankan setiap 30 menit:
        // $schedule->command('campaigns:update-statuses')->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
