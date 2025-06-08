<?php

namespace App\Mail;

use App\Models\Quiz;
use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuizInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $quiz;
    public $member;

    public function __construct(Quiz $quiz, Member $member)
    {
        $this->quiz = $quiz;
        $this->member = $member;
    }

    public function build()
    {
        return $this->subject('Quiz Invitation: ' . $this->quiz->title)
                    ->markdown('emails.quiz-invitation', [
                        'quiz' => $this->quiz,
                        'member' => $this->member,
                        'url' => route('quiz.take', $this->quiz->link)
                    ]);
    }
}