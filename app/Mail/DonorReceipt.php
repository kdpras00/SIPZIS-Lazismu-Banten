<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ZakatPayment;

class DonorReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $donorName;
    public $pdfPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ZakatPayment $payment, $pdfPath = null)
    {
        $this->payment = $payment;
        $this->donorName = $payment->muzakki->name ?? 'Hamba Allah';
        $this->pdfPath = $pdfPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->subject('Tanda Terima Donasi Anda - ' . $this->payment->payment_code)
            ->view('emails.donor.receipt')
            ->with([
                'payment' => $this->payment,
                'donorName' => $this->donorName,
            ]);

        // Attach PDF receipt if available
        if ($this->pdfPath && file_exists($this->pdfPath)) {
            $email->attach($this->pdfPath, [
                'as' => 'kwitansi-' . $this->payment->payment_code . '.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        return $email;
    }
}
