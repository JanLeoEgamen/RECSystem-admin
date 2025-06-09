<?php

namespace App\Mail;

use App\Models\Survey;
use App\Models\Member;
use App\Models\SurveyResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SurveyResultsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $survey;
    public $member;
    public $response;

    public function __construct(Survey $survey, Member $member, SurveyResponse $response)
    {
        $this->survey = $survey;
        $this->member = $member;
        $this->response = $response;
    }

    public function build()
    {
        return $this->subject("Your Survey Results: {$this->survey->title}")
            ->view('emails.survey-results') // Switch from markdown to custom view
            ->with([
                'survey' => $this->survey,
                'member' => $this->member,
                'response' => $this->response,
            ]);
    }
}
