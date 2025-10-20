<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateCampaignStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically update campaign statuses when they reach their end date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating campaign statuses...');

        // Find all published campaigns that have ended but are not marked as completed
        $expiredCampaigns = Campaign::where('status', 'published')
            ->where('end_date', '<', Carbon::now())
            ->get();

        $updatedCount = 0;
        $errorCount = 0;

        foreach ($expiredCampaigns as $campaign) {
            try {
                $campaign->update(['status' => 'completed']);
                $updatedCount++;

                $this->info("Updated campaign '{$campaign->title}' to completed status.");
                
                // Optional: Send notification to admins or log the event
                Log::info("Campaign automatically completed", [
                    'campaign_id' => $campaign->id,
                    'campaign_title' => $campaign->title,
                    'end_date' => $campaign->end_date
                ]);
            } catch (\Exception $e) {
                $errorCount++;
                $this->error("Failed to update campaign '{$campaign->title}': " . $e->getMessage());
                Log::error("Failed to automatically complete campaign", [
                    'campaign_id' => $campaign->id,
                    'campaign_title' => $campaign->title,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->info("Completed! Updated {$updatedCount} campaigns.");
        
        if ($errorCount > 0) {
            $this->warn("Encountered errors with {$errorCount} campaigns.");
        }

        // Also log for monitoring purposes
        Log::info("Campaign status update job completed", [
            'total_expired' => $expiredCampaigns->count(),
            'updated_count' => $updatedCount,
            'error_count' => $errorCount
        ]);

        return Command::SUCCESS;
    }
}