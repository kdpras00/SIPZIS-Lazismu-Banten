<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckPaymentColumns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-payment-columns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if midtrans_payment_method column exists in zakat_payments table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check if the column exists
        $columns = DB::select('SHOW COLUMNS FROM zakat_payments LIKE "midtrans_payment_method"');
        if (count($columns) > 0) {
            $this->info("Column 'midtrans_payment_method' exists in zakat_payments table");
        } else {
            $this->error("Column 'midtrans_payment_method' does NOT exist in zakat_payments table");
        }

        // List all columns in the table
        $allColumns = DB::select('SHOW COLUMNS FROM zakat_payments');
        $this->info("All columns in zakat_payments table:");
        foreach ($allColumns as $column) {
            $this->line("- " . $column->Field . " (" . $column->Type . ")");
        }
    }
}
