<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use App\Models\SurveyAnswer;
use App\Models\SurveyInvitation;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SurveyInvitationMail;
use App\Mail\SurveyResultsMail;

class SurveyController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view surveys', only: ['index']),
            new Middleware('permission:edit surveys', only: ['edit', 'update']),
            new Middleware('permission:create surveys', only: ['create', 'store']),
            new Middleware('permission:delete surveys', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Survey::with(['user'])->select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $buttons = '';

                    // Edit button
                    if (request()->user()->can('edit surveys')) {
                        $buttons .= '<a href="'.route('surveys.edit', $row->id).'" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-full transition-colors duration-200" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>';
                    }

                    // Delete button
                    if (request()->user()->can('delete surveys')) {
                        $buttons .= '<a href="javascript:void(0)" onclick="deleteSurvey('.$row->id.')" class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </a>';
                    }

                    // View button
                    $buttons .= '<a href="'.route('surveys.view', $row->id).'" class="p-2 text-blue-600 hover:text-white hover:bg-blue-600 rounded-full transition-colors duration-200" title="View">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>';

// Responses button
$buttons .= '<a href="'.route('surveys.responses', ['survey' => $row->id]).'" class="p-2 text-green-600 hover:text-white hover:bg-green-600 rounded-full transition-colors duration-200" title="Responses">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
</a>';
                    // Send button
                    if (request()->user()->can('create surveys')) {
                        $buttons .= '<a href="'.route('surveys.send', $row->id).'" class="p-2 text-purple-600 hover:text-white hover:bg-purple-600 rounded-full transition-colors duration-200" title="Send">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </a>';
                    }

                    return '<div class="flex space-x-2">'.$buttons.'</div>';
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->format('d M, y');
                })
                ->addColumn('responses_count', function($row) {
                    return $row->responses()->count();
                })
                ->addColumn('author', function($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('surveys.list');
    }

    public function create()
    {
        return view('surveys.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'nullable',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|in:short-answer,long-answer,multiple-choice,checkbox,dropdown',
            'questions.*.options' => 'required_if:questions.*.type,multiple-choice,checkbox,dropdown',
            'questions.*.is_required' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('surveys.create')
                ->withInput()
                ->withErrors($validator);
        }

        $survey = new Survey();
        $survey->title = $request->title;
        $survey->description = $request->description;
        $survey->user_id = $request->user()->id;
        $survey->save();

        foreach ($request->questions as $index => $questionData) {
            $question = new SurveyQuestion();
            $question->survey_id = $survey->id;
            $question->question = $questionData['question'];
            $question->type = $questionData['type'];
            $question->is_required = $questionData['is_required'] ?? false;
            $question->order = $index;
            
            if (in_array($questionData['type'], ['multiple-choice', 'checkbox', 'dropdown'])) {
                $options = explode("\n", str_replace("\r", "", $questionData['options']));
                $question->options = array_map('trim', $options);
            }
            
            $question->save();
        }

        return redirect()->route('surveys.index')
            ->with('success', 'Survey created successfully');
    }

    public function view($id)
    {
        $survey = Survey::with(['questions'])->findOrFail($id);
        return view('surveys.view', compact('survey'));
    }

    public function edit($id)
    {
        $survey = Survey::with(['questions'])->findOrFail($id);
        return view('surveys.edit', compact('survey'));
    }

    public function update(Request $request, $id)
    {
        $survey = Survey::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'nullable',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|in:short-answer,long-answer,multiple-choice,checkbox,dropdown',
            'questions.*.options' => 'required_if:questions.*.type,multiple-choice,checkbox,dropdown',
            'questions.*.is_required' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('surveys.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $survey->title = $request->title;
        $survey->description = $request->description;
        $survey->save();

        // Delete existing questions
        $survey->questions()->delete();

        // Add new questions
        foreach ($request->questions as $index => $questionData) {
            $question = new SurveyQuestion();
            $question->survey_id = $survey->id;
            $question->question = $questionData['question'];
            $question->type = $questionData['type'];
            $question->is_required = $questionData['is_required'] ?? false;
            $question->order = $index;
            
            if (in_array($questionData['type'], ['multiple-choice', 'checkbox', 'dropdown'])) {
                $options = explode("\n", str_replace("\r", "", $questionData['options']));
                $question->options = array_map('trim', $options);
            }
            
            $question->save();
        }

        return redirect()->route('surveys.index')
            ->with('success', 'Survey updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $survey = Survey::findOrFail($id);

        if ($survey == null) {
            session()->flash('error', 'Survey not found.');
            return response()->json([
                'status' => false
            ]);
        }

        $survey->delete();

        session()->flash('success', 'Survey deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }

    public function send($id)
    {
        $survey = Survey::findOrFail($id);
        
        // Get members who haven't received this survey
        $members = Member::whereDoesntHave('surveyInvitations', function($query) use ($id) {
            $query->where('survey_id', $id);
        })->get();
        
        // Get members who have received this survey
        $sentMembers = $survey->invitations()->with('member')->get();
        
        return view('surveys.send', compact('survey', 'members', 'sentMembers'));
    }

    public function sendSurvey(Request $request, $id)
    {
        $request->validate([
            'members' => 'required|array',
            'members.*' => 'exists:members,id'
        ]);

        $survey = Survey::findOrFail($id);
        $memberIds = $request->input('members', []);
        
        foreach ($memberIds as $memberId) {
            $member = Member::findOrFail($memberId);
            
            $invitation = new SurveyInvitation();
            $invitation->survey_id = $survey->id;
            $invitation->member_id = $memberId;
            $invitation->sent_at = now();
            $invitation->save();
            
            // Send email
            Mail::to($member->email_address)->send(new SurveyInvitationMail($survey, $member, $invitation));
        }
        
        return back()->with('success', 'Survey invitations sent successfully');
    }

    public function resendSurvey($surveyId, $memberId)
    {
        $survey = Survey::findOrFail($surveyId);
        $member = Member::findOrFail($memberId);

        $invitation = SurveyInvitation::where('survey_id', $surveyId)
            ->where('member_id', $memberId)
            ->first();

        if (!$invitation) {
            return back()->with('error', 'No survey invitation found to resend');
        }

        // Update sent_at timestamp
        $invitation->update(['sent_at' => now()]);

        // Send email
        Mail::to($member->email_address)->send(new SurveyInvitationMail($survey, $member, $invitation));

        return back()->with('success', 'Survey invitation resent successfully');
    }

    public function responses($id, Request $request)
    {
        $survey = Survey::with(['questions'])->findOrFail($id);
        $viewType = $request->get('view', 'summary');

        $summaryData = [];
        $questions = $survey->questions;
        $responses = $survey->responses()->with(['member', 'answers'])->get();

        foreach ($questions as $question) {
            $answers = SurveyAnswer::where('question_id', $question->id)->get();
            
            $summaryData[$question->id] = [
                'question' => $question->question,
                'type' => $question->type,
                'total_answers' => $answers->count(),
                'answers' => $answers->pluck('answer')->toArray(),
            ];

            if (in_array($question->type, ['multiple-choice', 'checkbox', 'dropdown'])) {
                $options = $question->options;
                $optionCounts = array_fill_keys($options, 0);
                
                foreach ($answers as $answer) {
                    if ($question->type === 'checkbox') {
                        // For checkbox questions, answers might be arrays
                        $selectedOptions = json_decode($answer->answer, true) ?? [];
                        foreach ($selectedOptions as $option) {
                            if (isset($optionCounts[$option])) {
                                $optionCounts[$option]++;
                            }
                        }
                    } else {
                        // For single-select questions
                        if (isset($optionCounts[$answer->answer])) {
                            $optionCounts[$answer->answer]++;
                        }
                    }
                }
                
                $summaryData[$question->id]['options'] = $options;
                $summaryData[$question->id]['option_counts'] = $optionCounts;
            }
        }

        return view('surveys.responses', [
            'survey' => $survey,
            'viewType' => $viewType,
            'summaryData' => $summaryData,
            'questions' => $questions,
            'responses' => $responses,
        ]);
    }

    public function viewResponse($surveyId, $responseId)
    {
        $response = SurveyResponse::with(['survey', 'member', 'answers.question'])
            ->where('survey_id', $surveyId)
            ->findOrFail($responseId);

        return view('surveys.view-response', compact('response'));
    }

    public function deleteResponse(Request $request)
    {
        $id = $request->id;
        $response = SurveyResponse::findOrFail($id);

        if ($response == null) {
            session()->flash('error', 'Response not found.');
            return response()->json([
                'status' => false
            ]);
        }

        $response->delete();

        session()->flash('success', 'Response deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }

    public function resendResults($surveyId, $memberId)
    {
        $survey = Survey::findOrFail($surveyId);
        $member = Member::findOrFail($memberId);

        $response = SurveyResponse::where('survey_id', $surveyId)
            ->where('member_id', $memberId)
            ->first();

        if (!$response) {
            return back()->with('error', 'No survey response found to send results');
        }

        // Update results_sent_at timestamp
        SurveyInvitation::where('survey_id', $surveyId)
            ->where('member_id', $memberId)
            ->update(['results_sent_at' => now()]);

        // Send email with results
        Mail::to($member->email_address)->send(new SurveyResultsMail($survey, $member, $response));

        return back()->with('success', 'Survey results sent successfully');
    }

    // Public facing survey methods
    public function showSurvey($slug, $token = null)
    {
        $survey = Survey::with(['questions'])->where('slug', $slug)->firstOrFail();

        // If token is provided, validate it
        $invitation = null;
        $member = null;
        
        if ($token) {
            $invitation = SurveyInvitation::where('token', $token)
                ->where('survey_id', $survey->id)
                ->firstOrFail();
                
            $member = $invitation->member;
        }

        // Check if already completed
        $completed = false;
        if ($member) {
            $completed = SurveyResponse::where('survey_id', $survey->id)
                ->where('member_id', $member->id)
                ->whereNotNull('completed_at')
                ->exists();
        }

        return view('surveys.take-survey', [
            'survey' => $survey,
            'invitation' => $invitation,
            'member' => $member,
            'completed' => $completed,
        ]);
    }

    public function submitSurvey(Request $request, $slug, $token = null)
    {
        $survey = Survey::with(['questions'])->where('slug', $slug)->firstOrFail();

        // If token is provided, validate it
        $invitation = null;
        $member = null;
        
        if ($token) {
            $invitation = SurveyInvitation::where('token', $token)
                ->where('survey_id', $survey->id)
                ->firstOrFail();
                
            $member = $invitation->member;
        }

        // Validate responses
        $rules = [];
        foreach ($survey->questions as $question) {
            if ($question->is_required) {
                $rules["answers.{$question->id}"] = 'required';
            }
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create response
        $response = new SurveyResponse();
        $response->survey_id = $survey->id;
        if ($member) {
            $response->member_id = $member->id;
        }
        $response->started_at = now();
        $response->completed_at = now();
        $response->save();

        // Save answers
        $score = 0;
        foreach ($survey->questions as $question) {
            $answer = new SurveyAnswer();
            $answer->response_id = $response->id;
            $answer->question_id = $question->id;
            
            $answerValue = $request->input("answers.{$question->id}");
            
            if (is_array($answerValue)) {
                $answer->answer = json_encode($answerValue);
            } else {
                $answer->answer = $answerValue;
            }
            
            $answer->save();
        }

        // Update invitation if exists
        if ($invitation) {
            $invitation->answered_at = now();
            $invitation->save();
        }

        return redirect()->route('survey.thank-you', $survey->slug);
    }

    public function thankYou($slug)
    {
        $survey = Survey::where('slug', $slug)->firstOrFail();
        return view('surveys.thank-you', compact('survey'));
    }
}