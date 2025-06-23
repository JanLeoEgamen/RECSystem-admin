<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DocumentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view documents', only: ['index']),
            new Middleware('permission:edit documents', only: ['edit']),
            new Middleware('permission:create documents', only: ['create']),
            new Middleware('permission:delete documents', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Document::with('user')->select('*');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $buttons = '';
                    
                    if (request()->user()->can('edit documents')) {
                        $buttons .= '<a href="'.route('documents.edit', $row->id).'" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-full transition-colors duration-200" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>';
                    }

                    if (request()->user()->can('delete documents')) {
                        $buttons .= '<a href="javascript:void(0)" onclick="deleteDocument('.$row->id.')" class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" title="Delete">
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
                ->addColumn('file_info', function($row) {
                    if ($row->url) {
                        return '<a href="'.$row->url.'" target="_blank" class="text-blue-600 hover:underline">External Link</a>';
                    }
                    return '<div class="flex items-center">
                        <i class="fas '.$row->file_icon.' mr-2"></i>
                        '.$row->file_type.'
                    </div>';
                })
                ->rawColumns(['action', 'is_published', 'file_info'])
                ->make(true);
        }
        
        return view('documents.list');
    }

    public function create()
    {
        $members = Member::all();
        return view('documents.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'nullable|min:10',
            'is_published' => 'sometimes|boolean',
            'members' => 'required|array',
            'members.*' => 'exists:members,id',
            'file' => 'required_without:url|file|mimes:pdf,doc,docx,jpeg,png,jpg,gif|max:2048',
            'url' => 'required_without:file|url|nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('documents.create')
                ->withInput()
                ->withErrors($validator);
        }

        $document = new Document();
        $document->title = $request->title;
        $document->description = $request->description;
        $document->is_published = $request->is_published ?? false;
        $document->user_id = $request->user()->id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('documents', 'public');
            
            $document->file_path = $path;
            $document->file_type = $file->getClientMimeType();
            $document->file_size = $this->formatBytes($file->getSize());
        } elseif ($request->url) {
            $document->url = $request->url;
            $document->file_type = 'link';
            $document->file_size = 'N/A';
        }

        $document->save();
        $document->members()->sync($request->members);

        return redirect()->route('documents.index')
            ->with('success', 'Document created successfully');
    }

    public function edit($id)
    {
        $document = Document::with('members')->findOrFail($id);
        $members = Member::all();
        return view('documents.edit', compact('document', 'members'));
    }

    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'description' => 'nullable|min:10',
            'is_published' => 'sometimes|boolean',
            'members' => 'required|array',
            'members.*' => 'exists:members,id',
            'file' => 'sometimes|file|mimes:pdf,doc,docx,jpeg,png,jpg,gif|max:2048',
            'url' => 'sometimes|url|nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('documents.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $document->title = $request->title;
        $document->description = $request->description;
        $document->is_published = $request->is_published ?? $document->is_published;

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $path = $file->store('documents', 'public');
            
            $document->file_path = $path;
            $document->file_type = $file->getClientMimeType();
            $document->file_size = $this->formatBytes($file->getSize());
            $document->url = null;
        } elseif ($request->url) {
            // Delete old file if exists
            if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $document->url = $request->url;
            $document->file_path = null;
            $document->file_type = 'link';
            $document->file_size = 'N/A';
        }

        $document->save();
        $document->members()->sync($request->members);

        return redirect()->route('documents.index')
            ->with('success', 'Document updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $document = Document::findOrFail($id);

        if ($document == null) {
            session()->flash('error', 'Document not found.');
            return response()->json(['status' => false]);
        }

        // Delete file if exists
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        session()->flash('success', 'Document deleted successfully.');
        return response()->json(['status' => true]);
    }

    public function view($id)
    {
        $document = Document::findOrFail($id);
        $members = $document->members()->orderBy('pivot_viewed_at', 'desc')->get();
        
        return view('documents.view', compact('document', 'members'));
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}