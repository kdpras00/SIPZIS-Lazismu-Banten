<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Muzakki;

class DonorZakatReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $muzakki;
    public $reminderType;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Muzakki $muzakki, $reminderType = 'zakat')
    {
        $this->muzakki = $muzakki;
        $this->reminderType = $reminderType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = '';
        if ($this->reminderType == 'zakat') {
            $subject = '📅 Pengingat Zakat Tahunan - Waktunya Membersihkan Harta';
        } elseif ($this->reminderType == 'inactive') {
            $subject = '🤝 Kami Rindu Kehadiran Anda Kembali';
        }

        return $this->subject($subject)
            ->view('emails.donor.zakat-reminder')
            ->with([
                'muzakki' => $this->muzakki,
                'reminderType' => $this->reminderType,
            ]);
    }
}
