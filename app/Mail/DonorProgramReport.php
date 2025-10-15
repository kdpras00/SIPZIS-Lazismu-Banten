<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Muzakki;
use App\Models\Program;

class DonorProgramReport extends Mailable
{
    use Queueable, SerializesModels;

    public $muzakki;
    public $program;
    public $reportData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Muzakki $muzakki, Program $program, $reportData = [])
    {
        $this->muzakki = $muzakki;
        $this->program = $program;
        $this->reportData = $reportData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('📈 Laporan Penyaluran Zakat Anda - ' . $this->program->name)
            ->view('emails.donor.program-report')
            ->with([
                'muzakki' => $this->muzakki,
                'program' => $this->program,
                'reportData' => $this->reportData,
            ]);
    }
}
