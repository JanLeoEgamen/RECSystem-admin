<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MembershipExpiringSoon extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $daysLeft;
    public $renewalUrl;

    public function __construct($user, $daysLeft, $renewalUrl = null)
    {
        $this->user = $user;
        $this->daysLeft = $daysLeft;
        $this->renewalUrl = $renewalUrl;
    }

    public function build()
    {
        return $this->subject('REC Membership Renewal Reminder - ' . $this->daysLeft . ' Days Left')
            ->view('emails.member-expiring-soon')
            ->with([
                'user' => $this->user,
                'daysLeft' => $this->daysLeft,
                'renewalUrl' => $this->renewalUrl,
            ]);
    }
}
