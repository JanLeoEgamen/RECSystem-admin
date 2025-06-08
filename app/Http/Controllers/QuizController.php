<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuizInvitation;
use App\Mail\QuizResults;

class QuizController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view quizzes', only: ['index']),
            new Middleware('permission:edit quizzes', only: ['edit', 'update']),
            new Middleware('permission:create quizzes', only: ['create', 'store']),
            new Middleware('permission:delete quizzes', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Quiz::with(['user'])->select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $buttons = '';

                    // Edit button
                    if (request()->user()->can('edit quizzes')) {
                        $buttons .= '<a href="'.route('quizzes.edit', $row->id).'" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-full transition-colors duration-200" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>';
                    }

                    // Delete button
                    if (request()->user()->can('delete quizzes')) {
                        $buttons .= '<a href="javascript:void(0)" onclick="deleteQuiz('.$row->id.')" class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </a>';
                    }

                    // View button
                    $buttons .= '<a href="'.route('quizzes.view', $row->id).'" class="p-2 text-blue-600 hover:text-white hover:bg-blue-600 rounded-full transition-colors duration-200" title="View">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>';

                    // Send button
                    if (request()->user()->can('create quizzes')) {
                        $buttons .= '<a href="'.route('quizzes.send', $row->id).'" class="p-2 text-green-600 hover:text-white hover:bg-green-600 rounded-full transition-colors duration-200" title="Send">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </a>';
                    }

                    return '<div class="flex space-x-2">'.$buttons.'</div>';
                })
                ->editColumn('description', function($row) {
                    return Str::limit(strip_tags($row->description), 50);
                })
                ->addColumn('author', function($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->format('d M, y');
                })
                ->rawColumns(['action', 'description'])
                ->make(true);
        }

        return view('quizzes.list');
    }

    public function create()
    {
        return view('quizzes.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'nullable',
            'time_limit' => 'nullable|integer',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|in:multiple_choice,identification,enumeration,essay',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.answers' => 'required_if:questions.*.type,multiple_choice|array|min:1',
            'questions.*.correct_answer' => 'required_if:questions.*.type,multiple_choice|integer',
            'questions.*.correct_answer' => 'required_if:questions.*.type,identification|string',
            'questions.*.enumeration_items' => 'required_if:questions.*.type,enumeration|array|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->route('quizzes.create')
                ->withInput()
                ->withErrors($validator);
        }

        $quiz = new Quiz();
        $quiz->title = $request->title;
        $quiz->description = $request->description;
        $quiz->time_limit = $request->time_limit;
        $quiz->user_id = $request->user()->id;
        $quiz->save();

        foreach ($request->questions as $index => $questionData) {
            $question = new QuizQuestion();
            $question->quiz_id = $quiz->id;
            $question->question = $questionData['question'];
            $question->type = $questionData['type'];
            $question->points = $questionData['points'];
            $question->order = $index;
            $question->save();

            // Handle answers based on question type
            switch ($questionData['type']) {
                case 'multiple_choice':
                    foreach ($questionData['answers'] as $answerIndex => $answerData) {
                        $answer = new QuizAnswer();
                        $answer->question_id = $question->id;
                        $answer->answer = $answerData['answer'];
                        $answer->is_correct = ($questionData['correct_answer'] == $answerIndex);
                        $answer->save();
                    }
                    break;
                    
                case 'identification':
                    $answer = new QuizAnswer();
                    $answer->question_id = $question->id;
                    $answer->answer = $questionData['correct_answer'];
                    $answer->is_correct = true;
                    $answer->save();
                    break;
                    
                case 'enumeration':
                    foreach ($questionData['enumeration_items'] as $item) {
                        $answer = new QuizAnswer();
                        $answer->question_id = $question->id;
                        $answer->answer = $item;
                        $answer->is_correct = true;
                        $answer->save();
                    }
                    break;
                    
                case 'essay':
                    // No answers needed for essay questions
                    break;
            }
        }

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz created successfully');
    }

    public function view($id)
    {
        $quiz = Quiz::with(['questions', 'questions.answers'])->findOrFail($id);
        return view('quizzes.view', compact('quiz'));
    }

    public function edit($id)
    {
        $quiz = Quiz::with(['questions', 'questions.answers'])->findOrFail($id);
        return view('quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'nullable',
            'time_limit' => 'nullable|integer',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|in:multiple_choice,identification,enumeration,essay',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.answers' => 'required_if:questions.*.type,multiple_choice|array|min:1',
            'questions.*.correct_answer' => 'required_if:questions.*.type,multiple_choice|integer',
            'questions.*.correct_answer' => 'required_if:questions.*.type,identification|string',
            'questions.*.enumeration_items' => 'required_if:questions.*.type,enumeration|array|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->route('quizzes.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $quiz->title = $request->title;
        $quiz->description = $request->description;
        $quiz->time_limit = $request->time_limit;
        $quiz->save();

        // Delete existing questions and answers
        $quiz->questions()->delete();

        foreach ($request->questions as $index => $questionData) {
            $question = new QuizQuestion();
            $question->quiz_id = $quiz->id;
            $question->question = $questionData['question'];
            $question->type = $questionData['type'];
            $question->points = $questionData['points'];
            $question->order = $index;
            $question->save();

            // Handle answers based on question type
            switch ($questionData['type']) {
                case 'multiple_choice':
                    foreach ($questionData['answers'] as $answerIndex => $answerData) {
                        $answer = new QuizAnswer();
                        $answer->question_id = $question->id;
                        $answer->answer = $answerData['answer'];
                        $answer->is_correct = ($questionData['correct_answer'] == $answerIndex);
                        $answer->save();
                    }
                    break;
                    
                case 'identification':
                    $answer = new QuizAnswer();
                    $answer->question_id = $question->id;
                    $answer->answer = $questionData['correct_answer'];
                    $answer->is_correct = true;
                    $answer->save();
                    break;
                    
                case 'enumeration':
                    foreach ($questionData['enumeration_items'] as $item) {
                        $answer = new QuizAnswer();
                        $answer->question_id = $question->id;
                        $answer->answer = $item;
                        $answer->is_correct = true;
                        $answer->save();
                    }
                    break;
                    
                case 'essay':
                    // No answers needed for essay questions
                    break;
            }
        }

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $quiz = Quiz::findOrFail($id);

        if ($quiz == null) {
            session()->flash('error', 'Quiz not found.');
            return response()->json([
                'status' => false
            ]);
        }

        $quiz->delete();

        session()->flash('success', 'Quiz deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }

    public function send($id)
    {
        $quiz = Quiz::findOrFail($id);
        
        // Get members who haven't received this quiz
        $members = Member::whereDoesntHave('quizAttempts', function($query) use ($id) {
            $query->where('quiz_id', $id);
        })->get();
            
        // Get members who have received this quiz
        $sentMembers = $quiz->attempts()->with('member')->get();
        
        return view('quizzes.send', compact('quiz', 'members', 'sentMembers'));
    }

    public function sendQuiz(Request $request, $id)
    {
        $request->validate([
            'members' => 'required|array',
            'members.*' => 'exists:members,id'
        ]);

        $quiz = Quiz::findOrFail($id);
        $memberIds = $request->input('members', []);
        
        foreach ($memberIds as $memberId) {
            $member = Member::findOrFail($memberId);
            
            // Create quiz attempt
            $attempt = new QuizAttempt();
            $attempt->quiz_id = $quiz->id;
            $attempt->member_id = $memberId;
            $attempt->save();
            
            // Send email with quiz link
            Mail::to($member->email_address)->send(new QuizInvitation($quiz, $member));
        }
        
        return back()->with('success', 'Quizzes sent successfully');
    }

    public function resendQuiz($quizId, $memberId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $member = Member::findOrFail($memberId);

        // Find or create attempt
        $attempt = QuizAttempt::firstOrCreate(
            ['quiz_id' => $quizId, 'member_id' => $memberId],
            ['started_at' => null, 'completed_at' => null]
        );

        // Send email with quiz link
        Mail::to($member->email_address)->send(new QuizInvitation($quiz, $member));

        return back()->with('success', 'Quiz resent successfully');
    }

    public function resendResults($quizId, $memberId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $member = Member::findOrFail($memberId);
        $attempt = QuizAttempt::where('quiz_id', $quizId)
            ->where('member_id', $memberId)
            ->whereNotNull('completed_at')
            ->firstOrFail();

        // Send email with results
        Mail::to($member->email_address)->send(new QuizResults($quiz, $member, $attempt));

        return back()->with('success', 'Results resent successfully');
    }

public function viewAttempt($quiz, $member)
{
    $quiz = Quiz::with(['questions', 'questions.answers', 'questions.correctAnswers'])
              ->findOrFail($quiz);
              
    $member = Member::findOrFail($member);
    
    // Get the most recent completed attempt
    $attempt = QuizAttempt::with(['answers', 'answers.question'])
        ->where('quiz_id', $quiz->id)
        ->where('member_id', $member->id)
        ->whereNotNull('completed_at')
        ->latest() // gets the most recent one
        ->firstOrFail();

    return view('quizzes.attempt-view', compact('quiz', 'member', 'attempt'));
}

}