<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberFile;
use App\Models\MemberFileUpload;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class MemberFileController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view member files', only: ['index', 'view']),
            new Middleware('permission:edit member files', only: ['edit', 'update']),
            new Middleware('permission:create member files', only: ['create', 'store']),
            new Middleware('permission:delete member files', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = MemberFile::with(['assigner:id,first_name,last_name', 'member:id,first_name,last_name', 'latestUpload']);

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $query->where(function ($q) use ($request) {
                        $q->where('title', 'like', '%' . $request->search . '%')
                          ->orWhere('description', 'like', '%' . $request->search . '%')
                          ->orWhereHas('assigner', function($q) use ($request) {
                              $q->where('first_name', 'like', '%' . $request->search . '%')
                                ->orWhere('last_name', 'like', '%' . $request->search . '%');
                          })
                          ->orWhereHas('member', function($q) use ($request) {
                              $q->where('first_name', 'like', '%' . $request->search . '%')
                                ->orWhere('last_name', 'like', '%' . $request->search . '%');
                          });
                    });
                }

                // Filter by member
                if ($request->has('member_id') && !empty($request->member_id)) {
                    $query->where('member_id', $request->member_id);
                }

                // Filter by status
                if ($request->has('status') && !empty($request->status)) {
                    if ($request->status === 'uploaded') {
                        $query->whereHas('uploads');
                    } elseif ($request->status === 'pending') {
                        $query->whereDoesntHave('uploads');
                    }
                }

                // Apply sorting
                $this->applySorting($query, $request);

                // Pagination
                $perPage = $request->input('perPage', 10);
                $files = $query->paginate($perPage);

                $transformedFiles = $files->getCollection()->map(function ($file) {
                    return [
                        'id' => $file->id,
                        'title' => $file->title,
                        'description' => $file->description,
                        'member' => $file->member->first_name . ' ' . $file->member->last_name,
                        'assigner' => $file->assigner->full_name ?? 'Unknown',
                        'due_date' => $file->due_date ? $file->due_date->format('d M, Y') : 'No due date',
                        'is_required' => $file->is_required,
                        'status' => $file->uploads->count() > 0 ? 'Uploaded' : 'Pending',
                        'uploaded_file' => $file->latestUpload ? $file->latestUpload->file_name : null,
                        'uploaded_at' => $file->latestUpload ? $file->latestUpload->uploaded_at->format('d M, Y H:i') : null,
                        'created_at' => $file->created_at->format('d M, Y'),
                    ];
                });

                return response()->json([
                    'data' => $transformedFiles,
                    'current_page' => $files->currentPage(),
                    'last_page' => $files->lastPage(),
                    'from' => $files->firstItem(),
                    'to' => $files->lastItem(),
                    'total' => $files->total(),
                ]);
            }
            
            $members = Member::all(['id', 'first_name', 'last_name']);
            return view('memberfiles.list', compact('members'));

        } catch (\Exception $e) {
            Log::error('Member File index error: ' . $e->getMessage());
            
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load member files'], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('error', 'Failed to load member files. Please try again.');
        }
    }

    public function create()
    {
        try {
            $members = Member::with('user')->get(['id', 'first_name', 'last_name', 'user_id']);
            return view('memberfiles.create', compact('members'));
        } catch (\Exception $e) {
            Log::error('Member File create form error: ' . $e->getMessage());
            return redirect()->route('memberfiles.index')
                ->with('error', 'Failed to load file creation form. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateMemberFileRequest($request);

            // Create a file assignment for each selected member
            foreach ($validated['member_ids'] as $memberId) {
                $file = new MemberFile();
                $file->title = $validated['title'];
                $file->description = $validated['description'] ?? null;
                $file->assigned_by = $request->user()->id;
                $file->member_id = $memberId;
                $file->due_date = $validated['due_date'] ?? null;
                $file->is_required = $validated['is_required'] ?? false;
                $file->save();
            }

            return redirect()->route('memberfiles.index')
                ->with('success', 'File assignment' . (count($validated['member_ids']) > 1 ? 's' : '') . ' created successfully for ' . count($validated['member_ids']) . ' member(s)');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error('Member File store error: ' . $e->getMessage());
            return redirect()->route('memberfiles.create')
                ->withInput()
                ->with('error', 'Failed to create file assignment. Please try again.');
        }
    }

    public function edit($id)
    {
        try {
            $file = MemberFile::findOrFail($id);
            $members = Member::with('user')->get(['id', 'first_name', 'last_name', 'user_id']);
            
            return view('memberfiles.edit', compact('file', 'members'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Member File not found for editing: {$id}");
            return redirect()->route('memberfiles.index')
                ->with('error', 'File assignment not found.');

        } catch (\Exception $e) {
            Log::error("Member File edit form error for ID {$id}: " . $e->getMessage());
            return redirect()->route('memberfiles.index')
                ->with('error', 'Failed to load file edit form. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $file = MemberFile::findOrFail($id);
            $validated = $this->validateMemberFileRequest($request, true);

            $file->title = $validated['title'];
            $file->description = $validated['description'] ?? null;
            $file->member_id = $validated['member_id'];
            $file->due_date = $validated['due_date'] ?? null;
            $file->is_required = $validated['is_required'] ?? false;
            $file->save();

            return redirect()->route('memberfiles.index')
                ->with('success', 'File assignment updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::warning("Member File not found for update: {$id}");
            return redirect()->route('memberfiles.index')
                ->with('error', 'File assignment not found.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error("Member File update error for ID {$id}: " . $e->getMessage());
            return redirect()->route('memberfiles.edit', $id)
                ->withInput()
                ->with('error', 'Failed to update file assignment. Please try again.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $file = MemberFile::findOrFail($request->id);
            
            // Delete associated uploads and files
            foreach ($file->uploads as $upload) {
                if ($upload->file_path && Storage::disk('public')->exists($upload->file_path)) {
                    Storage::disk('public')->delete($upload->file_path);
                }
                $upload->delete();
            }
            
            $file->delete();

            return response()->json([
                'status' => true,
                'message' => 'File assignment deleted successfully.'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("Member File not found for deletion: {$request->id}");
            return response()->json([
                'status' => false,
                'message' => 'File assignment not found.'
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            Log::error("Member File deletion error for ID {$request->id}: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete file assignment. Please try again.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function view($id)
    {
        try {
            $file = MemberFile::with(['assigner', 'member', 'uploads'])->findOrFail($id);
            return view('memberfiles.view', compact('file'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Member File not found for viewing: {$id}");
            return redirect()->route('memberfiles.index')
                ->with('error', 'File assignment not found.');

        } catch (\Exception $e) {
            Log::error("Member File view error for ID {$id}: " . $e->getMessage());
            return redirect()->route('memberfiles.index')
                ->with('error', 'Failed to load file assignment. Please try again.');
        }
    }

    public function downloadUpload($id, $uploadId)
    {
        try {
            $file = MemberFile::findOrFail($id);
            $upload = MemberFileUpload::findOrFail($uploadId);
            
            if ($upload->member_file_id !== $file->id) {
                throw new ModelNotFoundException();
            }
            
            return Storage::disk('public')->download($upload->file_path, $upload->file_name);

        } catch (ModelNotFoundException $e) {
            Log::warning("File upload not found for download: {$uploadId}");
            return redirect()->route('memberfiles.view', $id)
                ->with('error', 'File upload not found.');

        } catch (\Exception $e) {
            Log::error("File download error for upload ID {$uploadId}: " . $e->getMessage());
            return redirect()->route('memberfiles.view', $id)
                ->with('error', 'Failed to download file. Please try again.');
        }
    }

    /**
     * Validate member file request data
     */
    protected function validateMemberFileRequest(Request $request, $isUpdate = false): array
    {
        $rules = [
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|min:10|max:1000',
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:members,id',
            'due_date' => 'nullable|date',
            'is_required' => 'sometimes|boolean',
        ];

        // For update, we might need different validation
        if ($isUpdate) {
            $rules['member_id'] = 'required|exists:members,id';
        }

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
                
            case 'member':
                $query->join('members', 'member_files.member_id', '=', 'members.id')
                    ->orderBy('members.first_name', $direction)
                    ->orderBy('members.last_name', $direction);
                break;
                
            case 'due_date':
                $query->orderBy('due_date', $direction);
                break;
                
            case 'status':
                $query->leftJoin('member_file_uploads', 'member_files.id', '=', 'member_file_uploads.member_file_id')
                    ->select('member_files.*')
                    ->orderByRaw('CASE WHEN member_file_uploads.id IS NULL THEN 0 ELSE 1 END ' . $direction);
                break;
                
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    }
}