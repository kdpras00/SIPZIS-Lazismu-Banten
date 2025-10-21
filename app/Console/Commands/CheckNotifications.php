<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;
use App\Models\User;

class CheckNotifications extends Command
{
    protected $signature = 'test:check-notifications';
    protected $description = 'Check current notifications in the system';

    public function handle()
    {
        $this->info("=== Notification System Test Results ===\n");

        // Count total notifications
        $total = Notification::count();
        $this->info("Total notifications in system: " . $total);

        // Count test notifications
        $testCount = Notification::where('message', 'like', '%Test System:%')
            ->orWhere('message', 'like', '%Test notifikasi untuk semua pengguna%')
            ->orWhere('message', 'like', '%Pengumuman penting untuk semua pengguna sistem zakat%')
            ->count();

        $this->info("Test notifications: " . $testCount);

        // Show latest notifications
        $this->info("\nLatest 5 notifications:");
        $notifications = Notification::latest()->limit(5)->get();
        foreach ($notifications as $notification) {
            $this->line("- [" . $notification->type . "] " . $notification->title . ": " . $notification->message);
            $user = $notification->user;
            $this->line("  To: " . ($user ? $user->name : 'N/A') . " (" . ($user ? $user->email : 'N/A') . ")");
            $this->line("  Created: " . $notification->created_at->diffForHumans() . "\n");
        }

        $this->info("=== Test Complete ===");

        return 0;
    }
}
