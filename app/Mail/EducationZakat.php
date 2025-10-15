<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EducationZakat extends Mailable
{
    use Queueable, SerializesModels;

    public $topic;
    public $content;
    public $recipientName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($topic, $content, $recipientName = 'Hamba Allah')
    {
        $this->topic = $topic;
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
        return $this->subject('💡 Edukasi Zakat: ' . $this->topic)
            ->view('emails.education-zakat')
            ->with([
                'topic' => $this->topic,
                'content' => $this->content,
                'recipientName' => $this->recipientName,
            ]);
    }
}
