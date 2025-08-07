<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SurveyCompletionConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $name;
    public $surveyTitle;
    public $completionDate;
    public $surveyLink;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string $name,
        string $surveyTitle,
        string $completionDate,
        string $surveyLink
    ) {
        $this->name = $name ?? 'Valued Member';
        $this->surveyTitle = $surveyTitle ?? 'Our Survey';
        $this->completionDate = $completionDate ?? now()->format('F j, Y g:i a');
        $this->surveyLink = $surveyLink ?? route('member.surveys');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank You for Completing Our Survey',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.survey-completion',
            with: [
                'name' => $this->name,
                'surveyTitle' => $this->surveyTitle,
                'completionDate' => $this->completionDate,
                'surveyLink' => $this->surveyLink,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}