<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view documents', only: ['index', 'view']),
            new Middleware('permission:edit documents', only: ['edit', 'update']),
            new Middleware('permission:create documents', only: ['create', 'store']),
            new Middleware('permission:delete documents', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Document::with(['user:id,first_name,last_name', 'members:id']);

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $query->where(function ($q) use ($request) {
                        $q->where('title', 'like', '%' . $request->search . '%')
                          ->orWhere('description', 'like', '%' . $request->search . '%')
                          ->orWhere('file_type', 'like', '%' . $request->search . '%')
                          ->orWhereHas('user', function($q) use ($request) {
                              $q->where('first_name', 'like', '%' . $request->search . '%')
                                ->orWhere('last_name', 'like', '%' . $request->search . '%');
                          });
                    });
                }

                // Apply sorting
                $this->applySorting($query, $request);

                // Pagination
                $perPage = $request->input('perPage', 10);
                $documents = $query->paginate($perPage);

                $transformedDocuments = $documents->getCollection()->map(function ($document) {
                    return [
                        'id' => $document->id,
                        'title' => $document->title,
                        'file_info' => $document->file_type,
                        'url' => $document->url,
                        'file_url' => $document->file_path 
                            ? Storage::disk('public')->url($document->file_path) 
                            : null,
                        'is_published' => $document->is_published,
                        'author' => $document->user->full_name ?? 'Unknown',
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

        } catch (\Exception $e) {
            Log::error('Document index error: ' . $e->getMessage());
            
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load documents'], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('error', 'Failed to load documents. Please try again.');
        }
    }

    public function create()
    {
        try {
            $members = Member::all(['id', 'first_name', 'last_name']);
            return view('documents.create', compact('members'));
        } catch (\Exception $e) {
            Log::error('Document create form error: ' . $e->getMessage());
            return redirect()->route('documents.index')
                ->with('error', 'Failed to load document creation form. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateDocumentRequest($request, true);

            $document = new Document();
            $document->title = $validated['title'];
            $document->description = $validated['description'] ?? null;
            $document->is_published = $validated['is_published'] ?? false;
            $document->user_id = $request->user()->id;

            if ($request->hasFile('file')) {
                $this->storeDocumentFile($document, $request->file('file'));
            } elseif ($request->url) {
                $document->url = $validated['url'];
                $document->file_type = 'link';
                $document->file_size = 'N/A';
            }

            $document->save();
            $document->members()->sync($validated['members']);

            return redirect()->route('documents.index')
                ->with('success', 'Document created successfully');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error('Document store error: ' . $e->getMessage());
            return redirect()->route('documents.create')
                ->withInput()
                ->with('error', 'Failed to create document. Please try again.');
        }
    }

    public function edit($id)
    {
        try {
            $document = Document::with('members:id')->findOrFail($id);
            $members = Member::all(['id', 'first_name', 'last_name']);
            
            return view('documents.edit', compact('document', 'members'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Document not found for editing: {$id}");
            return redirect()->route('documents.index')
                ->with('error', 'Document not found.');

        } catch (\Exception $e) {
            Log::error("Document edit form error for ID {$id}: " . $e->getMessage());
            return redirect()->route('documents.index')
                ->with('error', 'Failed to load document edit form. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $document = Document::findOrFail($id);
            $validated = $this->validateDocumentRequest($request, false);

            $document->title = $validated['title'];
            $document->description = $validated['description'] ?? null;
            $document->is_published = $validated['is_published'] ?? $document->is_published;

            if ($request->hasFile('file')) {
                $this->deleteDocumentFile($document);
                $this->storeDocumentFile($document, $request->file('file'));
                $document->url = null;
            } elseif ($request->url) {
                $this->deleteDocumentFile($document);
                $document->url = $validated['url'];
                $document->file_path = null;
                $document->file_type = 'link';
                $document->file_size = 'N/A';
            }

            $document->save();
            $document->members()->sync($validated['members']);

            return redirect()->route('documents.index')
                ->with('success', 'Document updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::warning("Document not found for update: {$id}");
            return redirect()->route('documents.index')
                ->with('error', 'Document not found.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error("Document update error for ID {$id}: " . $e->getMessage());
            return redirect()->route('documents.edit', $id)
                ->withInput()
                ->with('error', 'Failed to update document. Please try again.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $document = Document::findOrFail($request->id);
            $this->deleteDocumentFile($document);
            $document->delete();

            return response()->json([
                'status' => true,
                'message' => 'Document deleted successfully.'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("Document not found for deletion: {$request->id}");
            return response()->json([
                'status' => false,
                'message' => 'Document not found.'
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            Log::error("Document deletion error for ID {$request->id}: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete document. Please try again.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function view($id)
    {
        try {
            $document = Document::findOrFail($id);
            $members = $document->members()
                ->orderBy('pivot_viewed_at', 'desc')
                ->get(['id', 'first_name', 'last_name']);
            
            return view('documents.view', compact('document', 'members'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Document not found for viewing: {$id}");
            return redirect()->route('documents.index')
                ->with('error', 'Document not found.');

        } catch (\Exception $e) {
            Log::error("Document view error for ID {$id}: " . $e->getMessage());
            return redirect()->route('documents.index')
                ->with('error', 'Failed to load document. Please try again.');
        }
    }

    /**
     * Validate document request data
     */
    protected function validateDocumentRequest(Request $request, bool $isNew): array
    {
        $rules = [
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|min:10|max:1000',
            'is_published' => 'sometimes|boolean',
            'members' => 'required|array',
            'members.*' => 'exists:members,id',
            'file' => ($isNew ? 'required_without:url|' : 'sometimes|') . 'file|mimes:pdf,doc,docx,jpeg,png,jpg,gif|max:2048',
            'url' => ($isNew ? 'required_without:file|' : 'sometimes|') . 'url|nullable',
        ];

        return $request->validate($rules);
    }

    /**
     * Apply sorting to the query
     */
    protected function applySorting($query, Request $request): void
    {
        $sort = $request->sort ?? 'created_at';
        $direction = in_array(strtolower($request->direction ?? 'desc'), ['asc', 'desc']) 
            ? $request->direction 
            : 'desc';

        switch ($sort) {
            case 'title':
                $query->orderBy('title', $direction);
                break;
                
            case 'is_published':
                $query->orderBy('is_published', $direction);
                break;
                
            case 'created':
            case 'created_at':
                $query->orderBy('created_at', $direction);
                break;
                
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    }

    /**
     * Store document file and update document attributes
     */
    protected function storeDocumentFile(Document $document, $file): void
    {
        $path = $file->store('documents', 'public');
        
        $document->file_path = $path;
        $document->file_type = $file->getClientMimeType();
        $document->file_size = $this->formatBytes($file->getSize());
    }

    /**
     * Delete document file if exists
     */
    protected function deleteDocumentFile(Document $document): void
    {
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
    }

    /**
     * Format bytes to human readable format
     */
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