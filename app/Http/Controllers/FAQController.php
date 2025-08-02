<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class FAQController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view faqs', only: ['index']),
            new Middleware('permission:edit faqs', only: ['edit']),
            new Middleware('permission:create faqs', only: ['create']),
            new Middleware('permission:delete faqs', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = FAQ::with('user');

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('question', 'like', "%$search%")
                      ->orWhere('answer', 'like', "%$search%")
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
                    case 'question':
                        $query->orderBy('question', $direction);
                        break;
                        
                    case 'status':
                        $query->orderBy('status', $direction === 'asc' ? 'asc' : 'desc');
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
            $faqs = $query->paginate($perPage);

            $transformedFAQs = $faqs->getCollection()->map(function ($faq) {
                return [
                    'id' => $faq->id,
                    'question' => Str::limit($faq->question, 50),
                    'answer' => Str::limit($faq->answer, 50),
                    'author' => $faq->user->first_name . ' ' . $faq->user->last_name,
                    'status' => $faq->status ? 'Active' : 'Inactive',
                    'created_at' => $faq->created_at->format('d M, Y'),
                ];
            });

            return response()->json([
                'data' => $transformedFAQs,
                'current_page' => $faqs->currentPage(),
                'last_page' => $faqs->lastPage(),
                'from' => $faqs->firstItem(),
                'to' => $faqs->lastItem(),
                'total' => $faqs->total(),
            ]);
        }
        
        return view('faqs.list');
    }

    public function create()
    {
        return view('faqs.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|min:3',
            'answer' => 'required|min:10',
            'status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('faqs.create')->withInput()->withErrors($validator);
        }

        $faq = new FAQ();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->user_id = $request->user()->id;
        $faq->status = $request->status ?? true;
        $faq->save();

        return redirect()->route('faqs.index')->with('success', 'FAQ added successfully');
    }

    public function edit(string $id)
    {
        $faq = FAQ::findOrFail($id);
        return view('faqs.edit', [
            'faq' => $faq
        ]);
    }

    public function update(Request $request, string $id)
    {
        $faq = FAQ::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'question' => 'required|min:3',
            'answer' => 'required|min:10',
            'status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('faqs.edit', $id)->withInput()->withErrors($validator);
        }

        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->status = $request->status ?? $faq->status;
        $faq->save();

        return redirect()->route('faqs.index')->with('success', 'FAQ updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $faq = FAQ::findOrFail($id);

        if ($faq == null) {
            session()->flash('error', 'FAQ not found.');
            return response()->json([
                'status' => false
            ]);
        }

        $faq->delete();

        session()->flash('success', 'FAQ deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }
}