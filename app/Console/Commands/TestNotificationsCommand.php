<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Muzakki;
use App\Models\Notification;

class TestNotificationsCommand extends Command
{
    protected $signature = 'test:notifications';
    protected $description = 'Test notifications functionality';

    public function handle()
    {
        $muzakki = Muzakki::first();

        if ($muzakki) {
            $this->info("Muzakki: " . $muzakki->name);
            $this->info("Total notifications: " . $muzakki->notifications()->count());
            $this->info("Unread notifications: " . $muzakki->notifications()->unread()->count());

            // Get latest notifications
            $notifications = $muzakki->notifications()->latest()->limit(3)->get();
            $this->info("Latest notifications:");
            foreach ($notifications as $notification) {
                $this->line("- " . $notification->title . ": " . $notification->message);
            }

            // Test the view rendering
            try {
                $html = view('muzakki.partials.notifications-popup', compact('notifications'))->render();
                $this->info("View rendered successfully, HTML length: " . strlen($html) . " characters");
            } catch (\Exception $e) {
                $this->error("Error rendering view: " . $e->getMessage());
            }
        } else {
            $this->error("No muzakki found");
        }

        return 0;
    }
}
