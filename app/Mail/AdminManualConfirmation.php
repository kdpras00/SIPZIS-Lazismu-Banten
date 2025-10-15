<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ZakatPayment;

class AdminManualConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $donorName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ZakatPayment $payment)
    {
        $this->payment = $payment;
        $this->donorName = $payment->muzakki->name ?? 'Hamba Allah';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('🔔 Konfirmasi Manual Dibutuhkan - ' . $this->payment->payment_code)
            ->view('emails.admin.manual-confirmation')
            ->with([
                'payment' => $this->payment,
                'donorName' => $this->donorName,
            ]);
    }
}
