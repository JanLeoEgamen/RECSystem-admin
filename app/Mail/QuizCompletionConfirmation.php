<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuizCompletionConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $quizTitle,
        public int $score,
        public int $totalPoints,
        public float $percentage,
        public string $completionDate,
        public string $resultLink
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Quiz Completion Confirmation',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.quiz-completion',
            with: [
                'name' => $this->name,
                'quizTitle' => $this->quizTitle,
                'score' => $this->score,
                'totalPoints' => $this->totalPoints,
                'percentage' => $this->percentage,
                'completionDate' => $this->completionDate,
                'resultLink' => $this->resultLink,
                'grade' => $this->getGrade($this->percentage)
            ]
        );
    }

    protected function getGrade(float $percentage): string
    {
        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'F';
    }

    public function attachments(): array
    {
        return [];
    }
}