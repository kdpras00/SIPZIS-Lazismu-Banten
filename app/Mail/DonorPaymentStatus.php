<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ZakatPayment;

class DonorPaymentStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $donorName;
    public $status;
    public $statusMessage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ZakatPayment $payment, $status)
    {
        $this->payment = $payment;
        $this->donorName = $payment->muzakki->name ?? 'Hamba Allah';
        $this->status = $status;

        // Set status message based on status
        switch ($status) {
            case 'pending':
                $this->statusMessage = 'Menunggu Konfirmasi';
                break;
            case 'completed':
                $this->statusMessage = 'Pembayaran Berhasil';
                break;
            case 'failed':
                $this->statusMessage = 'Pembayaran Gagal';
                break;
            case 'cancelled':
                $this->statusMessage = 'Pembayaran Dibatalkan';
                break;
            default:
                $this->statusMessage = 'Status Pembayaran';
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Status Pembayaran Donasi Anda - ' . $this->statusMessage)
            ->view('emails.donor.payment-status')
            ->with([
                'payment' => $this->payment,
                'donorName' => $this->donorName,
                'status' => $this->status,
                'statusMessage' => $this->statusMessage,
            ]);
    }
}
