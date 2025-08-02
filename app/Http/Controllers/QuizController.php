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
            $query = Quiz::with(['user', 'responses']);

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhereHas('user', function($q) use ($search) {
                        $q->where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%");
                    });
                });
            }

            if ($request->has('sort') && $request->has('direction')) {
                $sort = $request->sort;
                $direction = $request->direction;
                
                switch ($sort) {
                    case 'title':
                        $query->orderBy('title', $direction);
                        break;
                        
                    case 'is_published':
                        $query->orderBy('is_published', $direction === 'asc' ? 'asc' : 'desc');
                        break;
                        
                    case 'responses_count':
                        $query->withCount('responses')->orderBy('responses_count', $direction);
                        break;
                        
                    case 'created':
                        $query->orderBy('created_at', $direction);
                        break;
                        
                    default:
                        $query->orderBy('created_at', 'desc');
                        break;
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $perPage = $request->input('perPage', 10);
            $quizzes = $query->paginate($perPage);

            $transformedQuizzes = $quizzes->getCollection()->map(function ($quiz) {
                return [
                    'id' => $quiz->id,
                    'title' => $quiz->title,
                    'is_published' => $quiz->is_published,
                    'responses_count' => $quiz->responses->count(),
                    'author' => $quiz->user->first_name . ' ' . $quiz->user->last_name,
                    'created_at' => $quiz->created_at->format('d M, Y'),
                    'can_view_responses' => request()->user()->can('view quiz responses')
                ];
            });

            return response()->json([
                'data' => $transformedQuizzes,
                'current_page' => $quizzes->currentPage(),
                'last_page' => $quizzes->lastPage(),
                'from' => $quizzes->firstItem(),
                'to' => $quizzes->lastItem(),
                'total' => $quizzes->total(),
            ]);
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
