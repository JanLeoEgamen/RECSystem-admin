<?php

namespace App\Http\Controllers;

use App\Mail\RenewalSubmitted;
use App\Mail\SurveyCompletionConfirmation;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Models\MemberFile;
use App\Models\MemberFileUpload; 

class MemberDashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(['auth', 'verified', 'role:Member']),
        ];
    }


    private function isMembershipExpired($member)
    {
        return !$member->is_lifetime_member && $member->membership_end && now()->gt($member->membership_end);
    }

    public function index()
    {
        $member = auth()->user()->member;
        
        // Check if membership is expired
        if ($this->isMembershipExpired($member)) {
            return redirect()->route('member.renew');
        }
        
        return view('member.dashboard', [
            'isMembershipNearExpiry' => $this->isMembershipNearExpiry($member),
            'isMembershipExpired' => $this->isMembershipExpired($member)
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
    
    // Check for pending renewal
    $hasPendingRenewal = Renewal::where('member_id', $member->id)
                              ->where('status', 'pending')
                              ->exists();
    
    $pendingRenewal = null;
    if ($hasPendingRenewal) {
        $pendingRenewal = Renewal::where('member_id', $member->id)
                               ->where('status', 'pending')
                               ->latest()
                               ->first();
    }

    return view('member.renew', [
        'hasPendingRenewal' => $hasPendingRenewal,
        'pendingRenewal' => $pendingRenewal,
        'member' => $member
    ]);
}

    public function store(Request $request)
{
    $request->validate([
        'reference_number' => 'required|string|max:255|unique:renewals',
        'receipt' => 'required|image|max:2048',
    ]);

    $member = Auth::user()->member;
    if (!$member) {
        Log::error('Renewal submission failed - no member profile', ['user_id' => Auth::id()]);
        return back()->with('error', 'No member profile found');
    }

    // Check for existing pending renewal
    $hasPendingRenewal = Renewal::where('member_id', $member->id)
                              ->where('status', 'pending')
                              ->exists();

    if ($hasPendingRenewal) {
        return back()->with('error', 'You already have a pending renewal request');
    }

    Log::info('Starting renewal process', ['member_id' => $member->id]);

    try {
        $receiptPath = $request->file('receipt')->store('renewals', 'public');

        $renewal = Renewal::create([
            'member_id' => $member->id,
            'reference_number' => $request->reference_number,
            'receipt_path' => $receiptPath,
            'status' => 'pending',
        ]);

        // Detailed activity log
        logMembershipRenewal(
            $member,
            'pending',
            'Membership renewal submitted',
            [
                'reference_number' => $request->reference_number,
                'receipt_path' => $receiptPath,
                'renewal_id' => $renewal->id,
                'ip' => $request->ip()
            ]
        );

        Mail::to(Auth::user()->email)->send(
            new RenewalSubmitted(Auth::user()->name, $request->reference_number)
        );

        return redirect()->route('renew.thank-you')->with([
            'success' => 'Renewal request submitted successfully!',
            'reference_number' => $renewal->reference_number,
            'submission_date' => $renewal->created_at->format('F j, Y g:i a'),
            'renewal_id' => $renewal->id
        ]);

    } catch (\Exception $e) {
        Log::error('Renewal submission failed', [
            'error' => $e->getMessage(),
            'member_id' => $member->id
        ]);
        return back()->with('error', 'Failed to submit renewal request');
    }
}

    public function thankYou()
{
    // Check if user came from a successful submission
    if (!session()->has('reference_number')) {
        return redirect()->route('member.renew');
    }

    // Logout the user immediately
    Auth::logout();

    return view('member.renew-thank-you');
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
        $user = auth()->user();
        
        // Check if already submitted
        if ($survey->responses()->where('member_id', $member->id)->exists()) {
            logMemberActivity(
                $member,
                'survey',
                'duplicate_attempt',
                "Attempted to submit survey {$survey->id} again",
                ['survey_id' => $survey->id]
            );
            
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
            logMemberActivity(
                $member,
                'survey',
                'validation_failed',
                "Failed validation for survey {$survey->id}",
                [
                    'survey_id' => $survey->id,
                    'errors' => $validator->errors()->all()
                ]
            );
            
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
        
        /***** CRITICAL LOGGING *****/
        logMemberActivity(
            $member,
            'survey',
            'completed',
            "Completed survey: {$survey->title}",
            [
                'survey_id' => $survey->id,
                'response_id' => $response->id,
                'questions_answered' => count($survey->questions)
            ]
        );
        
        /***** EMAIL CONFIRMATION *****/
        Mail::to($user->email)->send(new SurveyCompletionConfirmation(
            $user->name,
            $survey->title,
            now()->format('F j, Y g:i a'),
            route('member.surveys')
        ));
        
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

        // In registerForEvent method:
        logEventParticipation(
            $member,
            $event,
            'registered',
            "Registered for event: {$event->title}"
        );
                
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

        // In cancelRegistration method:
        logEventParticipation(
            $member,
            $event,
            'cancelled',
            "Cancelled registration for event: {$event->title}"
        );
        
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

// Add these methods to your existing MemberDashboardController
    public function myFiles()
    {
        $member = auth()->user()->member;
        $files = $member->files()
            ->with(['assigner', 'latestUpload'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('member.myfiles', compact('files'));
    }

    public function viewFile($id)
    {
        $member = auth()->user()->member;
        $file = $member->files()
            ->with(['assigner', 'uploads'])
            ->findOrFail($id);

        return view('member.view-file', compact('file'));
    }

    public function uploadFile(Request $request, $id)
    {
        $member = auth()->user()->member;
        $file = $member->files()->findOrFail($id);

        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,jpeg,png,jpg,gif,txt|max:2048',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $uploadedFile = $request->file('file');
            $path = $uploadedFile->store('member_files', 'public');

            $upload = new MemberFileUpload();
            $upload->member_file_id = $file->id;
            $upload->file_path = $path;
            $upload->file_name = $uploadedFile->getClientOriginalName();
            $upload->file_type = $uploadedFile->getClientMimeType();
            $upload->file_size = $this->formatBytes($uploadedFile->getSize());
            $upload->notes = $request->notes;
            $upload->uploaded_at = now();
            $upload->save();

            logMemberActivity(
                $member,
                'file',
                'uploaded',
                "Uploaded file: {$upload->file_name} for assignment: {$file->title}",
                [
                    'file_id' => $file->id,
                    'upload_id' => $upload->id,
                    'file_name' => $upload->file_name
                ]
            );

            return redirect()->route('member.view-file', $id)
                ->with('success', 'File uploaded successfully.');

        } catch (\Exception $e) {
            Log::error("File upload error for assignment ID {$id}: " . $e->getMessage());
            return redirect()->route('member.view-file', $id)
                ->with('error', 'Failed to upload file. Please try again.');
        }
    }

    public function downloadFile($id, $uploadId)
    {
        $member = auth()->user()->member;
        $file = $member->files()->findOrFail($id);
        $upload = MemberFileUpload::findOrFail($uploadId);
        
        if ($upload->member_file_id !== $file->id) {
            abort(404);
        }
        
        return Storage::disk('public')->download($upload->file_path, $upload->file_name);
    }

    // Add this helper method to the controller
    private function formatBytes($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }


}