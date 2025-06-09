<?php

namespace App\Http\Controllers;

use App\Models\EmailLog;
use App\Models\EmailTemplate;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

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
            $templates = EmailTemplate::query();

            return DataTables::of($templates)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('F d, Y h:i A');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->format('F d, Y h:i A');
            })
            ->addColumn('action', function ($row) {
                $buttons = '';
                
                if (request()->user()->can('edit emails')) {
                    $buttons .= '<a href="'.route('emails.edit', $row->id).'" class="p-2 text-blue-600 hover:text-white hover:bg-blue-600 rounded-full transition-colors duration-200" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </a>';
                }

                if (request()->user()->can('delete emails')) {
                    $buttons .= '<button onclick="deleteEmailTemplate('.$row->id.')" class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>';
                }

                return '<div class="flex space-x-2">'.$buttons.'</div>';
            })
            ->make(true);
        }

        return view('emails.list');
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

    public function logs()
    {
        $query = EmailLog::with('template');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('template_name', function ($log) {
                return $log->template ? $log->template->name : 'N/A';
            })
            ->addColumn('attachments', function ($log) {
                if (!$log->attachments || !is_array($log->attachments)) {
                    return '-';
                }

                $html = ''; 
                foreach ($log->attachments as $file) {
                    $name = $file['name'] ?? basename($file['path']);
                    $url = Storage::url($file['path']); // Make sure files are stored in a public disk
                    $html .= "<a href='{$url}' target='_blank' class='underline text-blue-400 block'>{$name}</a>";
                }

                return $html;
            })
            ->addColumn('action', function ($log) {
                $button = '';
                
                if (request()->user()->can('delete emails')) {
                    $button = '<button onclick="deleteEmailLog('.$log->id.')" class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>';
                }

                return $button;
            })
            ->rawColumns(['attachments', 'action']) // enable HTML for attachments column
            ->make(true);
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