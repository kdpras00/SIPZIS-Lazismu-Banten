<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;

class ClearTestNotifications extends Command
{
    protected $signature = 'test:clear-notifications {--all : Clear all notifications, not just test ones}';
    protected $description = 'Clear test notifications';

    public function handle()
    {
        if ($this->option('all')) {
            $count = Notification::count();
            Notification::truncate();
            $this->info("Cleared all {$count} notifications!");
        } else {
            // Only clear notifications with "Test System" sender
            $count = Notification::where('message', 'like', '%Test System:%')
                ->orWhere('message', 'like', '%Test notifikasi untuk semua pengguna%')
                ->count();

            Notification::where('message', 'like', '%Test System:%')
                ->orWhere('message', 'like', '%Test notifikasi untuk semua pengguna%')
                ->delete();

            $this->info("Cleared {$count} test notifications!");
        }

        return 0;
    }
}
