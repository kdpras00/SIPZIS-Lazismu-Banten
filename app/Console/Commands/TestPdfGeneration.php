<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ZakatPayment;
use Barryvdh\DomPDF\Facade\Pdf;

class TestPdfGeneration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-pdf-generation {paymentCode?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test PDF generation for guest receipt';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $paymentCode = $this->argument('paymentCode');

        if ($paymentCode) {
            $payment = ZakatPayment::where('payment_code', $paymentCode)
                ->where('is_guest_payment', true)
                ->first();

            if (!$payment) {
                $this->error("Payment with code {$paymentCode} not found");
                return 1;
            }
        } else {
            // Get the first guest payment
            $payment = ZakatPayment::where('is_guest_payment', true)->first();

            if (!$payment) {
                $this->error("No guest payments found in the database");
                return 1;
            }
        }

        $payment->load(['muzakki', 'programType']);

        $this->info("Generating PDF for payment: {$payment->payment_code}");

        try {
            $pdf = Pdf::loadView('payments.guest-receipt-pdf', compact('payment'));
            $filename = 'kwitansi-' . $payment->payment_code . '.pdf';
            $pdf->save(storage_path('app/' . $filename));

            $this->info("PDF saved to: " . storage_path('app/' . $filename));
            return 0;
        } catch (\Exception $e) {
            $this->error("Error generating PDF: " . $e->getMessage());
            return 1;
        }
    }
}
