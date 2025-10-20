<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ZakatPayment;
use App\Models\Program;
use App\Models\Campaign;

class DebugPrograms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:debug-programs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug program data to check progress and collected amounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check if there are any completed payments
        $completedPayments = ZakatPayment::completed()->count();
        $this->info('Total completed payments in database: ' . $completedPayments);

        $this->info("\n=== PROGRAMS AND THEIR PAYMENTS ===");

        // Check all programs
        $programs = Program::orderBy('category')->get();
        foreach ($programs as $program) {
            $this->info('Program: ' . $program->name . ' (Category: ' . $program->category . ')');
            $this->info('  Target amount: ' . $program->target_amount);
            $this->info('  Total collected: ' . $program->total_collected);
            $this->info('  Progress percentage: ' . number_format($program->progress_percentage, 2) . '%');
            $this->info('  Formatted total collected: ' . $program->formatted_total_collected);
            $this->info('  Formatted total target: ' . $program->formatted_total_target);

            // Show direct payments
            $directPayments = $program->zakatPayments()->completed()->count();
            if ($directPayments > 0) {
                $this->info('  Direct payments: ' . $directPayments);
            }

            // Show campaign payments
            $campaigns = $program->campaigns()->published()->get();
            if ($campaigns->count() > 0) {
                $this->info('  Campaigns: ' . $campaigns->count());
                foreach ($campaigns as $campaign) {
                    $campaignPayments = $campaign->zakatPayments()->completed()->count();
                    if ($campaignPayments > 0) {
                        $campaignTotal = $campaign->zakatPayments()->completed()->sum('paid_amount');
                        $this->info('    - ' . $campaign->title . ': ' . $campaignPayments . ' payments (' . $campaignTotal . ')');
                    }
                }
            }

            $this->info('---');
        }

        $this->info("\n=== CAMPAIGNS AND THEIR PAYMENTS ===");

        // Check all campaigns
        $campaigns = Campaign::orderBy('program_category')->orderBy('title')->get();
        foreach ($campaigns as $campaign) {
            $this->info('Campaign: ' . $campaign->title . ' (Category: ' . $campaign->program_category . ')');
            $this->info('  Target amount: ' . $campaign->target_amount);
            $this->info('  Collected amount: ' . $campaign->collected_amount);
            $this->info('  Progress percentage: ' . number_format($campaign->progress_percentage, 2) . '%');

            $campaignPayments = $campaign->zakatPayments()->completed()->count();
            if ($campaignPayments > 0) {
                $campaignTotal = $campaign->zakatPayments()->completed()->sum('paid_amount');
                $this->info('  Payments: ' . $campaignPayments . ' (' . $campaignTotal . ')');
            }

            $this->info('---');
        }
    }
}
