<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountActivity extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $activityType;
    public $activityDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $activityType, $activityDetails = [])
    {
        $this->user = $user;
        $this->activityType = $activityType;
        $this->activityDetails = $activityDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = '';
        switch ($this->activityType) {
            case 'login':
                $subject = '📬 Aktivitas Login Baru di Akun Anda';
                break;
            case 'profile_update':
                $subject = '🔄 Profil Anda Telah Diperbarui';
                break;
            case 'password_change':
                $subject = '🔑 Kata Sandi Anda Telah Diubah';
                break;
            default:
                $subject = '📬 Aktivitas Akun Anda';
        }

        return $this->subject($subject)
            ->view('emails.auth.account-activity')
            ->with([
                'user' => $this->user,
                'activityType' => $this->activityType,
                'activityDetails' => $this->activityDetails,
            ]);
    }
}
