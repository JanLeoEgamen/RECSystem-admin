<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Member;
use App\Models\QuizResponse;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
                        $query->orderBy('is_published', $direction);
                        break;
                        
                    case 'created_at':
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
                $buttons = '';
                
                if (request()->user()->can('view quiz responses')) {
                    $buttons .= '<a href="'.route('quizzes.responses', $quiz->id).'" class="group bg-blue-100 hover:bg-blue-200 p-2 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 group-hover:text-blue-800 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </a>';
                }

                if (request()->user()->can('edit quizzes')) {
                    $buttons .= '<a href="'.route('quizzes.edit', $quiz->id).'" class="group bg-indigo-100 hover:bg-indigo-200 p-2 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 group-hover:text-indigo-800 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </a>';
                }

                if (request()->user()->can('delete quizzes')) {
                    $buttons .= '<button onclick="deleteQuiz('.$quiz->id.')" class="group bg-red-100 hover:bg-red-200 p-2 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 group-hover:text-red-800 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>';
                }

                return [
                    'id' => $quiz->id,
                    'title' => $quiz->title,
                    'is_published' => $quiz->is_published 
                        ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Published</span>'
                        : '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Draft</span>',
                    'responses_count' => $quiz->responses->count(),
                    'author' => $quiz->user->first_name . ' ' . $quiz->user->last_name,
                    'created_at' => $quiz->created_at->format('d M, Y'),
                    'action' => '<div class="flex space-x-2 justify-center">'.$buttons.'</div>'
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
        try {
            $user = auth()->user();
            
            // Get members based on user's bureau/section access
            $query = Member::with(['section']);
            
            if (!$user->can('view all members')) {
                $sectionIds = DB::table('user_bureau_section')
                    ->where('user_id', $user->id)
                    ->whereNotNull('section_id')
                    ->pluck('section_id');
                
                $bureauIds = DB::table('user_bureau_section')
                    ->where('user_id', $user->id)
                    ->whereNull('section_id')
                    ->pluck('bureau_id');
                
                $bureauSectionIds = Section::whereIn('bureau_id', $bureauIds)->pluck('id');
                
                $allSectionIds = $sectionIds->merge($bureauSectionIds)->unique();
                
                $query->whereIn('section_id', $allSectionIds);
            }

            $members = $query->get(['id', 'first_name', 'last_name', 'section_id']);
            
            // Get sections for filter dropdown
            $sectionsQuery = Section::with('bureau');
            if (!$user->can('view all members')) {
                $sectionsQuery->whereIn('id', $allSectionIds);
            }
            $sections = $sectionsQuery->get(['id', 'section_name', 'bureau_id']);

            return view('quizzes.create', compact('members', 'sections'));

        } catch (\Exception $e) {
            Log::error('Quiz create form error: ' . $e->getMessage());
            return redirect()->route('quizzes.index')
                ->with('error', 'Failed to load quiz creation form. Please try again.');
        }
    }

    public function edit($id)
    {
    try {
        $user = auth()->user();
        $quiz = Quiz::with(['questions', 'members:id'])->findOrFail($id);
        
        // Get members based on user's bureau/section access (same logic as create method)
        $query = Member::with(['section']);
        
        if (!$user->can('view all members')) {
            $sectionIds = DB::table('user_bureau_section')
                ->where('user_id', $user->id)
                ->whereNotNull('section_id')
                ->pluck('section_id');
            
            $bureauIds = DB::table('user_bureau_section')
                ->where('user_id', $user->id)
                ->whereNull('section_id')
                ->pluck('bureau_id');
            
            $bureauSectionIds = Section::whereIn('bureau_id', $bureauIds)->pluck('id');
            
            $allSectionIds = $sectionIds->merge($bureauSectionIds)->unique();
            
            $query->whereIn('section_id', $allSectionIds);
        }

        $members = $query->get(['id', 'first_name', 'last_name', 'section_id']);
        
        // Get sections for filter dropdown
        $sectionsQuery = Section::with('bureau');
        if (!$user->can('view all members')) {
            $sectionsQuery->whereIn('id', $allSectionIds);
        }
        $sections = $sectionsQuery->get(['id', 'section_name', 'bureau_id']);
        
        return view('quizzes.edit', compact('quiz', 'members', 'sections'));

    } catch (ModelNotFoundException $e) {
        Log::warning("Quiz not found for editing: {$id}");
        return redirect()->route('quizzes.index')
            ->with('error', 'Quiz not found.');

    } catch (\Exception $e) {
        Log::error('Quiz edit form error: ' . $e->getMessage());
        return redirect()->route('quizzes.index')
            ->with('error', 'Failed to load quiz edit form. Please try again.');
    }
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
