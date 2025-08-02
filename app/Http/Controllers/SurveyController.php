<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\Member;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SurveyController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view surveys', only: ['index']),
            new Middleware('permission:edit surveys', only: ['edit']),
            new Middleware('permission:create surveys', only: ['create']),
            new Middleware('permission:delete surveys', only: ['destroy']),
            new Middleware('permission:view survey responses', only: ['responses']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Survey::with(['user', 'responses']);

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
            $surveys = $query->paginate($perPage);

            $transformedSurveys = $surveys->getCollection()->map(function ($survey) {
                return [
                    'id' => $survey->id,
                    'title' => $survey->title,
                    'is_published' => $survey->is_published,
                    'responses_count' => $survey->responses->count(),
                    'author' => $survey->user->first_name . ' ' . $survey->user->last_name,
                    'created_at' => $survey->created_at->format('d M, Y'),
                    'can_view_responses' => request()->user()->can('view survey responses')
                ];
            });

            return response()->json([
                'data' => $transformedSurveys,
                'current_page' => $surveys->currentPage(),
                'last_page' => $surveys->lastPage(),
                'from' => $surveys->firstItem(),
                'to' => $surveys->lastItem(),
                'total' => $surveys->total(),
            ]);
        }
        
        return view('surveys.list');
    }

    public function create()
    {
        $members = Member::all();
        return view('surveys.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'nullable',
            'is_published' => 'sometimes|boolean',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|min:3',
            'questions.*.type' => 'required|in:short-answer,long-answer,checkbox,multiple-choice',
            'questions.*.options' => 'required_if:questions.*.type,checkbox,multiple-choice',
            'members' => 'required|array',
            'members.*' => 'exists:members,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('surveys.create')
                ->withInput()
                ->withErrors($validator);
        }

        $survey = Survey::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_published' => $request->is_published ?? false,
            'user_id' => $request->user()->id,
        ]);

        foreach ($request->questions as $index => $questionData) {
            $question = new SurveyQuestion([
                'question' => $questionData['question'],
                'type' => $questionData['type'],
                'order' => $index,
            ]);

            if (in_array($questionData['type'], ['checkbox', 'multiple-choice'])) {
                $options = explode("\n", $questionData['options']);
                $options = array_map('trim', $options);
                $options = array_filter($options);
                $question->options = $options;
            }

            $survey->questions()->save($question);
        }

        $survey->members()->sync($request->members);

        return redirect()->route('surveys.index')
            ->with('success', 'Survey created successfully');
    }

    public function edit($id)
    {
        $survey = Survey::with(['questions', 'members'])->findOrFail($id);
        $members = Member::all();
        return view('surveys.edit', compact('survey', 'members'));
    }

    public function update(Request $request, $id)
    {
        $survey = Survey::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'nullable',
            'is_published' => 'sometimes|boolean',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|min:3',
            'questions.*.type' => 'required|in:short-answer,long-answer,checkbox,multiple-choice',
            'questions.*.options' => 'required_if:questions.*.type,checkbox,multiple-choice',
            'members' => 'required|array',
            'members.*' => 'exists:members,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('surveys.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $survey->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_published' => $request->is_published ?? $survey->is_published,
        ]);

        // Delete removed questions
        $existingQuestionIds = $survey->questions->pluck('id')->toArray();
        $updatedQuestionIds = [];
        
        foreach ($request->questions as $index => $questionData) {
            if (isset($questionData['id'])) {
                $question = SurveyQuestion::find($questionData['id']);
                $updatedQuestionIds[] = $questionData['id'];
            } else {
                $question = new SurveyQuestion();
            }

            $question->question = $questionData['question'];
            $question->type = $questionData['type'];
            $question->order = $index;

            if (in_array($questionData['type'], ['checkbox', 'multiple-choice'])) {
                $options = explode("\n", $questionData['options']);
                $options = array_map('trim', $options);
                $options = array_filter($options);
                $question->options = $options;
            } else {
                $question->options = null;
            }

            $survey->questions()->save($question);
        }

        // Delete questions not in the updated list
        $questionsToDelete = array_diff($existingQuestionIds, $updatedQuestionIds);
        if (!empty($questionsToDelete)) {
            SurveyQuestion::whereIn('id', $questionsToDelete)->delete();
        }

        $survey->members()->sync($request->members);
        return redirect()->route('surveys.index')
            ->with('success', 'Survey updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $survey = Survey::findOrFail($id);

        if ($survey == null) {
            session()->flash('error', 'Survey not found.');
            return response()->json(['status' => false]);
        }

        $survey->delete();

        session()->flash('success', 'Survey deleted successfully.');
        return response()->json(['status' => true]);
    }

    public function responses($id)
    {
        $survey = Survey::with(['questions', 'responses.member'])->findOrFail($id);
        return view('surveys.responses', compact('survey'));
    }

    public function individualResponse(Survey $survey, SurveyResponse $response)
    {
        $response->load(['survey', 'member', 'answers.question']);
        return view('surveys.individual-response', compact('response'));
    }
}