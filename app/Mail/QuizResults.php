<?php

namespace App\Mail;

use App\Models\Quiz;
use App\Models\Member;
use App\Models\QuizAttempt;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuizResults extends Mailable
{
    use Queueable, SerializesModels;

    public $quiz;
    public $member;
    public $attempt;

    public function __construct(Quiz $quiz, Member $member, QuizAttempt $attempt)
    {
        $this->quiz = $quiz;
        $this->member = $member;
        $this->attempt = $attempt;
    }

    public function build()
    {
        return $this->subject('Quiz Results: ' . $this->quiz->title)
                    ->markdown('emails.quiz-results', [
                        'quiz' => $this->quiz,
                        'member' => $this->member,
                        'attempt' => $this->attempt
                    ]);
    }
}