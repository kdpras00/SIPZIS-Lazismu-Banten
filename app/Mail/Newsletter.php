<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Newsletter extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $recipientName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $content, $recipientName = 'Hamba Allah')
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->recipientName = $recipientName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view('emails.newsletter')
            ->with([
                'content' => $this->content,
                'recipientName' => $this->recipientName,
            ]);
    }
}
