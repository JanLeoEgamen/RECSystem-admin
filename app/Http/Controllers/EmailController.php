<?php

namespace App\Http\Controllers;

use App\Models\EmailLog;
use App\Models\EmailTemplate;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class EmailController extends Controller
{
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
                return '
                    <a href="'.route('emails.edit', $row->id).'" class="text-blue-500 hover:underline">Edit</a>
                    <button onclick="deleteEmailTemplate('.$row->id.')" class="text-red-500 hover:underline ml-2">Delete</button>
                ';
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
            'member_id' => 'required|string',
            'template' => 'required|string',
            'attachments.*' => 'file|max:10240',
            'custom_subject' => 'required_if:template,custom',
            'custom_message_body' => 'required_if:template,custom',
        ]);

        $members = $request->member_id === 'all'
            ? User::all()
            : User::where('id', $request->member_id)->get();

        if ($request->template === 'custom') {
            $subject = $request->custom_subject;
            $messageContent = nl2br(e($request->custom_message_body)); // optional HTML-safe
        } else {
            $template = EmailTemplate::findOrFail($request->template);
            $subject = $template->name;
            $messageContent = $template->body;
        }

        foreach ($members as $member) {
            try {
                $savedAttachments = [];

                // Save attachments to disk first
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $path = $file->store('attachments', 'public'); // stored under storage/app/public/attachments
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

                // Log the successful email including attachments
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
                    'attachments' => $savedAttachments, // Log the file data
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
                    'attachments' => $savedAttachments ?? null, // store even failed attempts
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
                return '<button onclick="deleteEmailLog('.$log->id.')" class="text-red-600 hover:text-red-900">Delete</button>';
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