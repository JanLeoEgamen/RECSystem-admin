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
        $query = Document::with(['user', 'members']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('file_type', 'like', "%$search%")
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
        $documents = $query->paginate($perPage);

        $transformedDocuments = $documents->getCollection()->map(function ($document) {
            return [
                'id' => $document->id,
                'title' => $document->title,
                'file_info' => $document->file_type,
                'url' => $document->url,
                'is_published' => $document->is_published,
                'author' => $document->user->first_name . ' ' . $document->user->last_name,
                'created_at' => $document->created_at->format('d M, Y'),
            ];
        });

        return response()->json([
            'data' => $transformedDocuments,
            'current_page' => $documents->currentPage(),
            'last_page' => $documents->lastPage(),
            'from' => $documents->firstItem(),
            'to' => $documents->lastItem(),
            'total' => $documents->total(),
        ]);
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