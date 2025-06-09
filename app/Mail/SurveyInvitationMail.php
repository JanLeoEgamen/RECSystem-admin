<?php

namespace App\Mail;

use App\Models\Survey;
use App\Models\Member;
use App\Models\SurveyInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SurveyInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $survey;
    public $member;
    public $invitation;

    public function __construct(Survey $survey, Member $member, SurveyInvitation $invitation)
    {
        $this->survey = $survey;
        $this->member = $member;
        $this->invitation = $invitation;
    }

    public function build()
    {
        $url = route('survey.show', [
            'slug' => $this->survey->slug,
            'token' => $this->invitation->token
        ]);

        return $this->subject("Survey Invitation: {$this->survey->title}")
                    ->view('emails.survey-invitation') // Use your custom HTML Blade
                    ->with([
                        'survey' => $this->survey,
                        'member' => $this->member,
                        'invitation' => $this->invitation,
                        'url' => $url,
                    ]);
    }
}
