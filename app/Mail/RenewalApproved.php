<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RenewalApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $memberName;
    public $membershipEnd;

    public function __construct($memberName, $membershipEnd)
    {
        $this->memberName = $memberName;
        $this->membershipEnd = $membershipEnd;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Renewal Has Been Approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.member-renewal-approved',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
