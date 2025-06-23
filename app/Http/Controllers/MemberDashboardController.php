<?php

namespace App\Http\Controllers;

use App\Mail\RenewalSubmitted;
use App\Models\Event;
use App\Models\Renewal;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MemberDashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(['auth', 'verified', 'role:Member']),
        ];
    }


public function index()
{
    $member = auth()->user()->member;
    
    // Check if membership is expired
    if (!$member->is_lifetime_member && $member->membership_end && now()->gt($member->membership_end)) {
        return redirect()->route('member.renew');
    }
    
    return view('member.dashboard', [
        'isMembershipNearExpiry' => $this->isMembershipNearExpiry($member)
    ]);
}

    public function membershipDetails()
    {
        // Get the authenticated user's member record
            $member = auth()->user()->member;
        
        $regionName = DB::table('ref_psgc_region')->where('psgc_reg_code', $member->region)->value('psgc_reg_desc');
        $provinceName = DB::table('ref_psgc_province')->where('psgc_prov_code', $member->province)->value('psgc_prov_desc');
        $municipalityName = DB::table('ref_psgc_municipality')->where('psgc_munc_code', $member->municipality)->value('psgc_munc_desc');
        $barangayName = DB::table('ref_psgc_barangay')->where('psgc_brgy_code', $member->barangay)->value('psgc_brgy_desc');


        return view('member.membership-details', compact(
            'member',
            'regionName',
            'provinceName',
            'municipalityName',
            'barangayName'
        ));
    }


    // Add this helper method to the controller
    private function isMembershipNearExpiry($member)
    {
        if ($member->is_lifetime_member || !$member->membership_end) {
            return false;
        }
        
        $expiryDate = \Carbon\Carbon::parse($member->membership_end);
        return now()->diffInDays($expiryDate) <= 30; // 30 days threshold
    }

    // Add this method for the renew page
    public function renew()
    {
        return view('member.renew');
    }

    public function create()
    {
        $member = Auth::user()->member;
        return view('member.renew', compact('member'));
    }

    // Store renewal request
    public function store(Request $request)
    {
        $request->validate([
            'reference_number' => 'required|string|max:255|unique:renewals',
            'receipt' => 'required|image|max:2048',
        ]);

        $receiptPath = $request->file('receipt')->store('renewals', 'public');

        Renewal::create([
            'member_id' => Auth::user()->member->id,
            'reference_number' => $request->reference_number,
            'receipt_path' => $receiptPath,
            'status' => 'pending',
        ]);

        // Send email using the Mailable class
        Mail::to(Auth::user()->email)->send(
            new RenewalSubmitted(Auth::user()->name, $request->reference_number)
        );

        return redirect()->route('member.dashboard')->with('success', 'Renewal request submitted successfully!');
    }




    public function announcements()
    {
        $member = auth()->user()->member;
        $announcements = $member->announcements()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('member.announcements', compact('announcements'));
    }

    public function viewAnnouncement($id)
    {
    $member = auth()->user()->member;
    
    if (!$member) {
        abort(404, 'Member record not found');
    }

    $announcement = $member->announcements()
        ->where('announcements.id', $id)
        ->firstOrFail();

    // Mark as read if not already read
    if (!$announcement->pivot->is_read) {
        $member->announcements()->updateExistingPivot($announcement->id, [
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    return view('member.view-announcement', compact('announcement'));
    }

    public function surveys()
    {
        $member = auth()->user()->member;
        $surveys = $member->surveys()
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('member.surveys', compact('surveys'));
    }
    public function takeSurvey($id)
    {
        $survey = Survey::with('questions')->findOrFail($id);
        
        if (!$survey->is_published) {
            abort(404);
        }
        
        return view('member.take-survey', compact('survey'));
    }

    public function submitSurvey(Request $request, $id)
    {
        $survey = Survey::with('questions')->findOrFail($id);
        $member = auth()->user()->member;
        
        // Check if already submitted
        if ($survey->responses()->where('member_id', $member->id)->exists()) {
            return redirect()->route('member.surveys')
                ->with('error', 'You have already submitted this survey.');
        }
        
        // Validate answers
        $rules = [];
        foreach ($survey->questions as $question) {
            $rules["answers.{$question->id}"] = 'required';
            if ($question->type === 'checkbox') {
                $rules["answers.{$question->id}"] = 'array';
                $rules["answers.{$question->id}.*"] = 'in:'.implode(',', $question->options);
            } elseif (in_array($question->type, ['multiple-choice'])) {
                $rules["answers.{$question->id}"] = 'in:'.implode(',', $question->options);
            }
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()->route('member.take-survey', $id)
                ->withErrors($validator)
                ->withInput();
        }
        
        // Create response
        $response = SurveyResponse::create([
            'survey_id' => $survey->id,
            'member_id' => $member->id,
        ]);
        
        // Save answers
        foreach ($survey->questions as $question) {
            $answer = $request->input("answers.{$question->id}");
            
            if ($question->type === 'checkbox' && is_array($answer)) {
                $answer = json_encode($answer);
            }
            
            SurveyAnswer::create([
                'response_id' => $response->id,
                'question_id' => $question->id,
                'answer' => $answer,
            ]);
        }
        
        return redirect()->route('member.surveys')
            ->with('success', 'Thank you for completing the survey!');
    }


    public function events()
    {
        $member = auth()->user()->member;
        $events = Event::where('is_published', true)
            ->orderBy('start_date', 'desc')
            ->get();
            
        return view('member.events', compact('events'));
    }

    public function viewEvent($id)
    {
        $event = Event::findOrFail($id);
        return view('member.view-event', compact('event'));
    }

    public function registerForEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $member = auth()->user()->member;
        
        // Check if already registered
        if ($event->registrations()->where('member_id', $member->id)->exists()) {
            return redirect()->route('member.events')
                ->with('error', 'You are already registered for this event.');
        }
        
        // Check capacity
        if ($event->capacity && $event->registrations()->count() >= $event->capacity) {
            return redirect()->route('member.events')
                ->with('error', 'This event has reached its capacity.');
        }
        
        // Register
        $event->registrations()->create([
            'member_id' => $member->id,
            'status' => 'registered'
        ]);
        
        return redirect()->route('member.events')
            ->with('success', 'You have successfully registered for the event.');
    }

    public function cancelRegistration(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $member = auth()->user()->member;
        
        $registration = $event->registrations()
            ->where('member_id', $member->id)
            ->first();
        
        if (!$registration) {
            return redirect()->route('member.events')
                ->with('error', 'You are not registered for this event.');
        }
        
        $registration->update([
            'status' => 'cancelled'
        ]);
        
        return redirect()->route('member.events')
            ->with('success', 'Your registration has been cancelled.');
    }


    public function documents()
    {
        $documents = auth()->user()->member->documents()->paginate(12);
        return view('member.documents', compact('documents'));
    }

    public function viewDocument($id)
    {
        $document = auth()->user()->member->documents()->where('documents.id', $id)->firstOrFail();
        
        // Mark as viewed if not already
        if (!$document->pivot->is_viewed) {
            auth()->user()->member->documents()->updateExistingPivot($document->id, [
                'is_viewed' => true,
                'viewed_at' => now()
            ]);
        }
        
        return view('member.view-document', compact('document'));
    }
        
    // Add this to your MemberDashboardController
public function downloadDocument($id)
{
    $document = auth()->user()->member->documents()->where('documents.id', $id)->firstOrFail();
    
    // Mark as downloaded if not already
    if (!$document->pivot->is_downloaded) {
        auth()->user()->member->documents()->updateExistingPivot($document->id, [
            'is_downloaded' => true,
            'downloaded_at' => now()
        ]);
    }
    
    if ($document->url) {
        return redirect()->away($document->url);
    }
    
    if ($document->file_path) {
        return Storage::disk('public')->download($document->file_path, $document->title . '.' . pathinfo($document->file_path, PATHINFO_EXTENSION));
    }
    
    abort(404);
}


}