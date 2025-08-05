<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Member;
use App\Models\QuizResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class QuizController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view quizzes', only: ['index']),
            new Middleware('permission:edit quizzes', only: ['edit']),
            new Middleware('permission:create quizzes', only: ['create']),
            new Middleware('permission:delete quizzes', only: ['destroy']),
            new Middleware('permission:view quiz responses', only: ['responses']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Quiz::with('user')->select('*');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $buttons = '';
                    
                    if (request()->user()->can('view quiz responses')) {
                        $buttons .= '<a href="'.route('quizzes.responses', $row->id).'" class="p-2 text-blue-600 hover:text-white hover:bg-blue-600 rounded-full transition-colors duration-200" title="Responses">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </a>';
                    }

                    if (request()->user()->can('edit quizzes')) {
                        $buttons .= '<a href="'.route('quizzes.edit', $row->id).'" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-full transition-colors duration-200" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>';
                    }

                    if (request()->user()->can('delete quizzes')) {
                        $buttons .= '<a href="javascript:void(0)" onclick="deleteQuiz('.$row->id.')" class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </a>';
                    }

                    return '<div class="flex space-x-2">'.$buttons.'</div>';
                })
                ->editColumn('is_published', function($row) {
                    return $row->is_published 
                        ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Published</span>'
                        : '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Draft</span>';
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->format('d M, y');
                })
                ->addColumn('author', function($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->addColumn('responses_count', function($row) {
                    return $row->responses()->count();
                })
                ->rawColumns(['action', 'is_published'])
                ->make(true);
        }
        
        return view('quizzes.list');
    }

    public function create()
    {
        $members = Member::all();
        return view('quizzes.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'nullable',
            'is_published' => 'sometimes|boolean',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|min:3',
            'questions.*.type' => 'required|in:identification,true-false,checkbox,multiple-choice',
            'questions.*.options' => 'required_if:questions.*.type,checkbox,multiple-choice',
            'questions.*.correct_answers' => 'required',
            'questions.*.points' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('quizzes.create')
                ->withInput()
                ->withErrors($validator);
        }

        $quiz = Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_published' => $request->is_published ?? false,
            'user_id' => $request->user()->id,
        ]);

        foreach ($request->questions as $index => $questionData) {
            $question = new QuizQuestion([
                'question' => $questionData['question'],
                'type' => $questionData['type'],
                'order' => $index,
                'points' => $questionData['points'],
            ]);

            if (in_array($questionData['type'], ['checkbox', 'multiple-choice'])) {
                $options = explode("\n", $questionData['options']);
                $options = array_map('trim', $options);
                $options = array_filter($options);
                $question->options = $options;
            }

            // Process correct answers
            $correctAnswers = [];
            if ($questionData['type'] === 'true-false') {
                $correctAnswers = [$questionData['correct_answers']];
            } elseif ($questionData['type'] === 'checkbox') {
                $correctAnswers = $questionData['correct_answers'] ?? [];
            } else {
                $correctAnswers = [$questionData['correct_answers']];
            }
            $question->correct_answers = $correctAnswers;

            $quiz->questions()->save($question);
        }

        $quiz->members()->sync($request->members);

        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz created successfully');
    }

    public function edit($id)
    {
        $quiz = Quiz::with(['questions', 'members'])->findOrFail($id);
        $members = Member::all();
        return view('quizzes.edit', compact('quiz', 'members'));
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'nullable',
            'is_published' => 'sometimes|boolean',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|min:3',
            'questions.*.type' => 'required|in:identification,true-false,checkbox,multiple-choice',
            'questions.*.options' => 'required_if:questions.*.type,checkbox,multiple-choice',
            'questions.*.correct_answers' => 'required',
            'questions.*.points' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('quizzes.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_published' => $request->is_published ?? $quiz->is_published,
        ]);

        // Delete removed questions
        $existingQuestionIds = $quiz->questions->pluck('id')->toArray();
        $updatedQuestionIds = [];
        
        foreach ($request->questions as $index => $questionData) {
            if (isset($questionData['id'])) {
                $question = QuizQuestion::find($questionData['id']);
                $updatedQuestionIds[] = $questionData['id'];
            } else {
                $question = new QuizQuestion();
            }

            $question->question = $questionData['question'];
            $question->type = $questionData['type'];
            $question->order = $index;
            $question->points = $questionData['points'];

            if (in_array($questionData['type'], ['checkbox', 'multiple-choice'])) {
                $options = explode("\n", $questionData['options']);
                $options = array_map('trim', $options);
                $options = array_filter($options);
                $question->options = $options;
            } else {
                $question->options = null;
            }

            // Process correct answers
            $correctAnswers = [];
            if ($questionData['type'] === 'true-false') {
                $correctAnswers = [$questionData['correct_answers']];
            } elseif ($questionData['type'] === 'checkbox') {
                $correctAnswers = $questionData['correct_answers'] ?? [];
            } else {
                $correctAnswers = [$questionData['correct_answers']];
            }
            $question->correct_answers = $correctAnswers;

            $quiz->questions()->save($question);
        }

        // Delete questions not in the updated list
        $questionsToDelete = array_diff($existingQuestionIds, $updatedQuestionIds);
        if (!empty($questionsToDelete)) {
            QuizQuestion::whereIn('id', $questionsToDelete)->delete();
        }

        $quiz->members()->sync($request->members);
        return redirect()->route('quizzes.index')
            ->with('success', 'Quiz updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $quiz = Quiz::findOrFail($id);

        if ($quiz == null) {
            session()->flash('error', 'Quiz not found.');
            return response()->json(['status' => false]);
        }

        $quiz->delete();

        session()->flash('success', 'Quiz deleted successfully.');
        return response()->json(['status' => true]);
    }

    public function responses($id)
    {
        $quiz = Quiz::with(['questions', 'responses.member'])->findOrFail($id);
        return view('quizzes.responses', compact('quiz'));
    }

    public function individualResponse(Quiz $quiz, QuizResponse $response)
    {
        $response->load(['quiz', 'member', 'answers.question']);
        return view('quizzes.individual-response', compact('response'));
    }

    public function summaryResponse(Quiz $quiz)
    {
        $quiz->load(['questions.answers', 'responses.member']);
        
        $questionStats = [];
        foreach ($quiz->questions as $question) {
            $totalAnswers = $question->answers->count();
            $correctAnswers = $question->answers->where('is_correct', true)->count();
            
            $questionStats[] = [
                'question' => $question->question,
                'type' => $question->type,
                'total_answers' => $totalAnswers,
                'correct_answers' => $correctAnswers,
                'accuracy' => $totalAnswers > 0 ? ($correctAnswers / $totalAnswers) * 100 : 0,
            ];
        }
        
        return view('quizzes.summary-response', compact('quiz', 'questionStats'));
    }
}
