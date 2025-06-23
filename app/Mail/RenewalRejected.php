<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RenewalRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $memberName;
    public $remarks;

    public function __construct($memberName, $remarks)
    {
        $this->memberName = $memberName;
        $this->remarks = $remarks;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Renewal Request Rejected',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.member-renewal-rejected',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
