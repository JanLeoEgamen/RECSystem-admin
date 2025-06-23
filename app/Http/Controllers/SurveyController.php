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
use Yajra\DataTables\Facades\DataTables;

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
            $data = Survey::with('user')->select('*');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $buttons = '';
                    
                    if (request()->user()->can('view survey responses')) {
                        $buttons .= '<a href="'.route('surveys.responses', $row->id).'" class="p-2 text-blue-600 hover:text-white hover:bg-blue-600 rounded-full transition-colors duration-200" title="Responses">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </a>';
                    }

                    if (request()->user()->can('edit surveys')) {
                        $buttons .= '<a href="'.route('surveys.edit', $row->id).'" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-full transition-colors duration-200" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>';
                    }

                    if (request()->user()->can('delete surveys')) {
                        $buttons .= '<a href="javascript:void(0)" onclick="deleteSurvey('.$row->id.')" class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" title="Delete">
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