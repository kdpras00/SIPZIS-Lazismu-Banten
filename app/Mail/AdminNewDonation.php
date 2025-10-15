<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ZakatPayment;

class AdminNewDonation extends Mailable
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
        return $this->subject('🔔 Donasi Baru Masuk - ' . $this->payment->payment_code)
            ->view('emails.admin.new-donation')
            ->with([
                'payment' => $this->payment,
                'donorName' => $this->donorName,
            ]);
    }
}
