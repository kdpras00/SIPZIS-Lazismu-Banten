<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Notification;

class TestNotificationPopup extends Command
{
    protected $signature = 'test:notification-popup {message?} {--type=info} {--to=all}';
    protected $description = 'Send a test notification to users for popup testing';

    public function handle()
    {
        $message = $this->argument('message') ?? 'Ini adalah pesan notifikasi test untuk memeriksa tampilan popup.';
        $type = $this->option('type');
        $to = $this->option('to');

        $this->info("Sending test notification...");
        $this->info("Message: " . $message);
        $this->info("Type: " . $type);
        $this->info("To: " . $to);

        // Get users based on the --to option
        if ($to === 'all') {
            $users = User::active()->get();
            $this->info("Sending to all " . $users->count() . " active users");
        } else {
            // If not 'all', try to find user by ID or email
            $users = User::where('id', $to)->orWhere('email', $to)->get();
            if ($users->isEmpty()) {
                $this->error("No user found with ID or email: " . $to);
                return 1;
            }
        }

        $sentCount = 0;
        foreach ($users as $user) {
            try {
                // Create notification for the user
                Notification::createMessageNotification($user, $message, 'Test System');
                $sentCount++;
                $this->line("Sent to: " . $user->name . " (" . $user->email . ")");
            } catch (\Exception $e) {
                $this->error("Failed to send to " . $user->name . ": " . $e->getMessage());
            }
        }

        $this->info("Successfully sent " . $sentCount . " notifications!");

        // Test rendering the popup view with sample notifications
        $this->info("\nTesting popup view rendering...");
        $sampleUser = $users->first();
        if ($sampleUser) {
            $notifications = $sampleUser->notifications()->latest()->limit(3)->get();

            try {
                $html = view('muzakki.partials.notifications-popup', compact('notifications'))->render();
                $this->info("Popup view rendered successfully!");
                $this->info("HTML length: " . strlen($html) . " characters");

                // Save the HTML to a file for inspection
                file_put_contents('test_notification_popup.html', $html);
                $this->info("HTML output saved to test_notification_popup.html");
            } catch (\Exception $e) {
                $this->error("Error rendering popup view: " . $e->getMessage());
            }
        }

        return 0;
    }
}
