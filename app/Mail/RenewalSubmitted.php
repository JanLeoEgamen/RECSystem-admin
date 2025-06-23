<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RenewalSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $memberName;
    public $referenceNumber;

    public function __construct($memberName, $referenceNumber)
    {
        $this->memberName = $memberName;
        $this->referenceNumber = $referenceNumber;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Renewal Request Submitted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.member-renewal-submitted', // replace this with your actual Blade view
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

