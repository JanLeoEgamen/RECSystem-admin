<?php

namespace App\Http\Controllers;

use App\Models\EmailLog;
use App\Models\EmailTemplate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmailController extends Controller implements HasMiddleware
{   
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view emails', only: ['index', 'logs']),
            new Middleware('permission:edit emails', only: ['edit', 'update']),
            new Middleware('permission:create emails', only: ['create', 'store']),
            new Middleware('permission:delete emails', only: ['destroy', 'destroyLog']),
            new Middleware('permission:send emails', only: ['compose', 'send']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = EmailTemplate::query();

            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('subject', 'like', "%$search%")
                      ->orWhere('body', 'like', "%$search%");
                });
            }

            // Sorting
            $sort = $request->input('sort', 'created_at');
            $direction = $request->input('direction', 'desc');
            $query->orderBy($sort, $direction);

            $perPage = $request->input('perPage', 10);
            $templates = $query->paginate($perPage);

            $transformedTemplates = $templates->map(function ($template) {
                return [
                    'id' => $template->id,
                    'name' => $template->name,
                    'subject' => $template->subject,
                    'body' => Str::limit(strip_tags($template->body), 50),
                    'created_at' => $template->created_at->format('d M, Y h:i A'),
                    'updated_at' => $template->updated_at->format('d M, Y h:i A'),
                    'can_edit' => auth()->user()->can('edit emails'),
                    'can_delete' => auth()->user()->can('delete emails'),
                ];
            });

            return response()->json([
                'data' => $transformedTemplates,
                'current_page' => $templates->currentPage(),
                'last_page' => $templates->lastPage(),
                'per_page' => $templates->perPage(),
                'total' => $templates->total(),
            ]);
        }

        return view('emails.list');
    }

    public function logs(Request $request)
    {
        $query = EmailLog::with('template');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('recipient_email', 'like', "%$search%")
                ->orWhere('recipient_name', 'like', "%$search%")
                ->orWhere('subject', 'like', "%$search%")
                ->orWhereHas('template', function($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
            });
        }

        // Sorting
        $sort = $request->input('sort', 'sent_at');
        $direction = $request->input('direction', 'desc');
        $query->orderBy($sort, $direction);

        $perPage = $request->input('perPage', 10);
        $logs = $query->paginate($perPage);

        $transformedLogs = $logs->map(function ($log) {
            $attachments = [];
            if ($log->attachments && is_array($log->attachments)) {
                foreach ($log->attachments as $file) {
                    $attachments[] = [
                        'name' => $file['name'] ?? basename($file['path']),
                        'url' => Storage::url($file['path'])
                    ];
                }
            }

            // Handle sent_at properly
            $sentAt = null;
            if ($log->sent_at) {
                try {
                    $sentAt = Carbon::parse($log->sent_at)->format('d M, Y h:i A');
                } catch (\Exception $e) {
                    // Fallback to raw value if parsing fails
                    $sentAt = $log->sent_at;
                }
            }

            return [
                'id' => $log->id,
                'recipient_email' => $log->recipient_email,
                'recipient_name' => $log->recipient_name,
                'template_name' => $log->template ? $log->template->name : 'Custom',
                'subject' => $log->subject,
                'attachments' => $attachments,
                'status' => $log->status,
                'sent_at' => $sentAt,
                'can_delete' => auth()->user()->can('delete emails'),
            ];
        });

        return response()->json([
            'data' => $transformedLogs,
            'current_page' => $logs->currentPage(),
            'last_page' => $logs->lastPage(),
            'per_page' => $logs->perPage(),
            'total' => $logs->total(),
        ]);
    }


    public function create()
    {
        return view('emails.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        EmailTemplate::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $request->body    ,
        ]);

        return redirect()->route('emails.index')->with('success', 'Email template created successfully.');
    }

    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('emails.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $template = EmailTemplate::findOrFail($id);
        $template->update($request->only('name', 'subject', 'body'));

        return redirect()->route('emails.index')->with('success', 'Email template updated successfully.');
    }

    public function compose()
    {
        $members = User::all(); // or use a separate Member model
        $templates = EmailTemplate::all();
        return view('emails.send', compact('members', 'templates'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:users,id', // validate each member ID exists
            'template' => 'required|string',
            'attachments.*' => 'file|max:10240',
            'custom_subject' => 'required_if:template,custom',
            'custom_message_body' => 'required_if:template,custom',
        ]);

        // Handle "select all" case if you have that option
        if (in_array('all', $request->member_ids)) {
            $members = User::all();
        } else {
            $members = User::whereIn('id', $request->member_ids)->get();
        }

        if ($request->template === 'custom') {
            $subject = $request->custom_subject;
            $messageContent = nl2br(e($request->custom_message_body));
        } else {
            $template = EmailTemplate::findOrFail($request->template);
            $subject = $template->name;
            $messageContent = $template->body;
        }

        foreach ($members as $member) {
            try {
                $savedAttachments = [];

                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $path = $file->store('attachments', 'public');
                        $savedAttachments[] = [
                            'name' => $file->getClientOriginalName(),
                            'path' => $path,
                        ];
                    }
                }

                Mail::send('emails.template', [
                    'user' => $member,
                    'custom_message' => $request->custom_message,
                    'subject' => $subject,
                    'messageContent' => $messageContent
                ], function ($message) use ($member, $subject, $request) {
                    $message->to($member->email, $member->name)
                            ->subject($subject);

                    if ($request->hasFile('attachments')) {
                        foreach ($request->file('attachments') as $file) {
                            $message->attach($file->getRealPath(), [
                                'as' => $file->getClientOriginalName(),
                                'mime' => $file->getClientMimeType(),
                            ]);
                        }
                    }
                });

                EmailLog::create([
                    'recipient_email' => $member->email,
                    'recipient_name' => $member->name ?? ($member->first_name . ' ' . $member->last_name),
                    'template_id' => $request->template === 'custom' ? null : $request->template,
                    'subject' => $subject,
                    'body' => $messageContent,
                    'status' => 'sent',
                    'error_message' => null,
                    'sent_at' => now(),
                    'sent_by' => Auth::id(),
                    'attachments' => $savedAttachments,
                ]);
            } catch (\Exception $e) {
                EmailLog::create([
                    'recipient_email' => $member->email,
                    'recipient_name' => $member->name ?? ($member->first_name . ' ' . $member->last_name),
                    'template_id' => $request->template === 'custom' ? null : $request->template,
                    'subject' => $subject,
                    'body' => $messageContent,
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'sent_at' => now(),
                    'sent_by' => Auth::id(),
                    'attachments' => $savedAttachments ?? null,
                ]); 

                Log::error('Email failed: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Emails sent successfully!');
    }

    public function destroy(Request $request)
    {
        $templateId = $request->id;

        $template = EmailTemplate::find($templateId);

        if (!$template) {
            return response()->json(['status' => 'error', 'message' => 'Template not found.'], 404);
        }

        try {
            $template->delete();
            return response()->json(['status' => 'success', 'message' => 'Template deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to delete template.']);
        }
    }

    public function destroyLog(Request $request)
    {
        $logId = $request->id;

        $log = EmailLog::find($logId);

        if (!$log) {
            return response()->json(['status' => 'error', 'message' => 'Log not found.'], 404);
        }

        try {
            $log->delete();
            return response()->json(['status' => 'success', 'message' => 'Log deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to delete log.']);
        }
    }
    
}