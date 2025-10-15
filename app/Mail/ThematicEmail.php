<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThematicEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $occasion;
    public $message;
    public $recipientName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($occasion, $message, $recipientName = 'Hamba Allah')
    {
        $this->occasion = $occasion;
        $this->message = $message;
        $this->recipientName = $recipientName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = '';
        switch ($this->occasion) {
            case 'ramadhan':
                $subject = '🌙 Selamat Menjalani Bulan Suci Ramadhan';
                break;
            case 'idul_fitri':
                $subject = '🌟 Taqabbalallahu Minna Wa Minkum';
                break;
            case 'idul_adha':
                $subject = '🐑 Selamat Hari Raya Idul Adha';
                break;
            default:
                $subject = '💌 ' . ucfirst($this->occasion);
        }

        return $this->subject($subject)
            ->view('emails.thematic-email')
            ->with([
                'occasion' => $this->occasion,
                'message' => $this->message,
                'recipientName' => $this->recipientName,
            ]);
    }
}
