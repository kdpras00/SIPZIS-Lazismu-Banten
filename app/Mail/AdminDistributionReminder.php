<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ZakatDistribution;

class AdminDistributionReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $distribution;
    public $programName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ZakatDistribution $distribution)
    {
        $this->distribution = $distribution;
        $this->programName = $distribution->program ? $distribution->program->name : 'Program Zakat';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('📦 Pengingat Penyaluran Dana - ' . $this->programName)
            ->view('emails.admin.distribution-reminder')
            ->with([
                'distribution' => $this->distribution,
                'programName' => $this->programName,
            ]);
    }
}
