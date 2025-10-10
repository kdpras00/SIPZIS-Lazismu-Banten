<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ZakatDistribution;
use App\Models\Mustahik;
use App\Models\ZakatPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestDistributionCreation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:distribution-creation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test distribution creation to identify issues';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Testing distribution creation...');

        try {
            // Get a verified mustahik
            $mustahik = Mustahik::verified()->active()->first();

            if (!$mustahik) {
                $this->error('No verified mustahik found');
                return 1;
            }

            $this->info('Using mustahik: ' . $mustahik->name);

            // Check available balance
            $availableBalance = ZakatPayment::completed()->sum('paid_amount') - ZakatDistribution::sum('amount');
            $this->info('Available balance: ' . $availableBalance);

            // Try to create a distribution
            DB::beginTransaction();

            $distributionCode = ZakatDistribution::generateDistributionCode();
            $this->info('Generated distribution code: ' . $distributionCode);

            $distribution = ZakatDistribution::create([
                'distribution_code' => $distributionCode,
                'mustahik_id' => $mustahik->id,
                'amount' => 100000,
                'distribution_type' => 'cash',
                'distribution_date' => now(),
                'distributed_by' => 1, // Assuming user ID 1 exists
                'is_received' => false,
            ]);

            DB::commit();

            $this->info('Distribution created successfully with ID: ' . $distribution->id);

            // Clean up - delete the test distribution
            $distribution->delete();
            $this->info('Test distribution cleaned up');

            return 0;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error in test distribution creation: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            $this->error('Error occurred: ' . $e->getMessage());
            return 1;
        }
    }
}
