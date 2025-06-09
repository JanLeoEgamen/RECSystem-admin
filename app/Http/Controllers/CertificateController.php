<?php

namespace App\Http\Controllers;

use App\Jobs\SendCertificateJob;
use App\Models\Certificate;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\CertificateMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Dompdf\Dompdf;
use Dompdf\Options;

class CertificateController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view certificates', only: ['index']),
            new Middleware('permission:edit certificates', only: ['edit']),
            new Middleware('permission:create certificates', only: ['create']),
            new Middleware('permission:delete certificates', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Certificate::with(['user', 'signatories'])->select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $buttons = '';

                    // Edit button
                    if (request()->user()->can('edit certificates')) {
                        $buttons .= '<a href="'.route('certificates.edit', $row->id).'" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-full transition-colors duration-200" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>';
                    }

                    // Delete button
                    if (request()->user()->can('delete certificates')) {
                        $buttons .= '<a href="javascript:void(0)" onclick="deleteCertificate('.$row->id.')" class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </a>';
                    }

                    // Preview button (always available)
                    $buttons .= '<a href="'.route('certificates.preview', $row->id).'" class="p-2 text-blue-600 hover:text-white hover:bg-blue-600 rounded-full transition-colors duration-200" title="Preview">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>';

                    return '<div class="flex space-x-2">'.$buttons.'</div>';
                })
                ->editColumn('content', function($row) {
                    return \Illuminate\Support\Str::limit(strip_tags($row->content), 50);
                })
                ->addColumn('signatories', function($row) {
                    return $row->signatories->pluck('name')->join(', ');
                })
                ->addColumn('author', function($row) {
                    return $row->user->first_name . ' ' . $row->user->last_name;
                })
                ->editColumn('created_at', function($row) {
                    return $row->created_at->format('d M, y');
                })
                ->rawColumns(['action', 'content'])
                ->make(true);
        }

        return view('certificates.list');
    }

    public function create()
    {
        return view('certificates.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'content' => 'required|min:10',
            'signatories' => 'required|array|min:1',
            'signatories.*.name' => 'required|string',
            'signatories.*.position' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('certificates.create')
                ->withInput()
                ->withErrors($validator);
        }

        $certificate = new Certificate();
        $certificate->title = $request->title;
        $certificate->content = $request->content;
        $certificate->user_id = $request->user()->id;
        $certificate->save();

        // Save signatories
        foreach ($request->signatories as $index => $signatory) {
            $certificate->signatories()->create([
                'name' => $signatory['name'],
                'position' => $signatory['position'] ?? null,
                'order' => $index,
            ]);
        }

        return redirect()->route('certificates.index')
            ->with('success', 'Certificate template created successfully');
    }

    public function edit(string $id)
    {
        $certificate = Certificate::with('signatories')->findOrFail($id);
        return view('certificates.edit', [
            'certificate' => $certificate
        ]);
    }

    public function update(Request $request, string $id)
    {
        $certificate = Certificate::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'content' => 'required|min:10',
            'signatories' => 'required|array|min:1',
            'signatories.*.name' => 'required|string',
            'signatories.*.position' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->route('certificates.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        $certificate->title = $request->title;
        $certificate->content = $request->content;
        $certificate->save();

        // Delete existing signatories
        $certificate->signatories()->delete();

        // Add new signatories
        foreach ($request->signatories as $index => $signatory) {
            $certificate->signatories()->create([
                'name' => $signatory['name'],
                'position' => $signatory['position'] ?? null,
                'order' => $index,
            ]);
        }

        return redirect()->route('certificates.index')
            ->with('success', 'Certificate template updated successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $certificate = Certificate::findOrFail($id);

        if ($certificate == null) {
            session()->flash('error', 'Certificate template not found.');
            return response()->json([
                'status' => false
            ]);
        }

        $certificate->delete();

        session()->flash('success', 'Certificate template deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }


    public function view($id)
    {
        $certificate = Certificate::with('signatories')->findOrFail($id);

        return view('certificates.jcertificate', [
            'certificate' => $certificate,
            'member' => null,
            'issueDate' => now()->format('F j, Y')
        ]);
    }

    public function preview($id)
    {
        $certificate = Certificate::with('signatories')->findOrFail($id);
        return view('certificates.preview', compact('certificate'));
    }


    private function generatePdf($certificateId, $memberId = null)
    {
        $certificate = Certificate::with('signatories')->findOrFail($certificateId);
        $member = $memberId ? Member::findOrFail($memberId) : null;

        $options = new Options();
        $options->set([
            'isRemoteEnabled' => true,
            'defaultFont' => 'DejaVu Sans',
            'dpi' => 150, // Optimal for email attachments
            'isPhpEnabled' => true,
            'marginTop' => '0',
            'marginRight' => '0',
            'marginBottom' => '0',
            'marginLeft' => '0',
            'isHtml5ParserEnabled' => true, 
        ]);

        $dompdf = new Dompdf($options);

        $html = view('certificates.jcertificate', [
            'certificate' => $certificate,
            'member' => $member,
            'issueDate' => now()->format('F j, Y'),
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->set_option('enable_css_page_break', false);
        $dompdf->render();

        return $dompdf;
    }


    public function download($certificateId, $memberId)
    {
        $certificate = Certificate::with('signatories')->findOrFail($certificateId);
        $member = Member::findOrFail($memberId);

        // Render the HTML content from the 'jcertificate' view
        $html = view('certificates.jcertificate', [
            'certificate' => $certificate,
            'member' => $member,
            'issueDate' => now()->format('F j, Y'),
        ])->render();

        // Return response that forces browser to download the HTML content as a file
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="certificate_' . $certificateId . '_' . $memberId . '.html"');
    }

    public function send($id)
    {
        $certificate = Certificate::findOrFail($id);
        
        // Get members who haven't received this certificate
        $members = Member::whereDoesntHave('certificates', function($query) use ($id) {
            $query->where('certificate_id', $id);
        })->get();
        
        // Get members who have received this certificate
        $sentMembers = $certificate->members()->get();
        
        return view('certificates.send', compact('certificate', 'members', 'sentMembers'));
    }

    public function sendCertificate(Request $request, $id)
    {
        $request->validate([
            'members' => 'required|array',
            'members.*' => 'exists:members,id'
        ]);

        $memberIds = $request->input('members');

        foreach ($memberIds as $memberId) {
            SendCertificateJob::dispatch($id, $memberId);
        }

        return back()->with('success', 'Certificate sending has been queued and will be processed shortly.');
    }


    public function resendCertificate($certificateId, $memberId)
    {
        $certificate = Certificate::findOrFail($certificateId);
        $member = Member::findOrFail($memberId);

        // Find the latest certificate issuance
        $latestIssue = $certificate->members()
            ->where('member_id', $memberId)
            ->latest('issued_at')
            ->first();

        if (!$latestIssue) {
            // No record exists, generate PDF and attach record
            $dompdf = $this->generatePdf($certificateId, $memberId);
            $pdfContent = $dompdf->output();

            $filename = "certificates/{$certificateId}/member_{$memberId}_" . now()->format('YmdHis') . '.pdf';
            Storage::disk('public')->put($filename, $pdfContent);

            $certificate->members()->attach($memberId, [
                'issued_at' => now(),
                'pdf_path' => $filename,
            ]);
        } else {
            $filename = $latestIssue->pivot->pdf_path;

            // Regenerate PDF if file is missing
            if (!Storage::disk('public')->exists($filename)) {
                $dompdf = $this->generatePdf($certificateId, $memberId);
                $pdfContent = $dompdf->output();
                Storage::disk('public')->put($filename, $pdfContent);
            }
        }

        // Dispatch a job to send the certificate email asynchronously (better for retries and responsiveness)
        SendCertificateJob::dispatch($certificateId, $memberId);

        // Update sent_at timestamp now, or inside the job if preferred
        $certificate->members()->updateExistingPivot($memberId, [
            'sent_at' => now(),
        ]);

        return back()->with('success', 'Certificate resend has been queued and will be processed shortly.');
    }

    public function deleteMemberCertificate(Certificate $certificate, Member $member)
    {
        try {
            // Check if the member has this certificate
            if (!$certificate->members()->where('member_id', $member->id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This member does not have this certificate'
                ], 404);
            }

            // Get the PDF path before detaching
            $pdfPath = $certificate->members()
                ->where('member_id', $member->id)
                ->first()
                ->pivot
                ->pdf_path ?? null;

            // Detach the member
            $certificate->members()->detach($member->id);

            // Delete the PDF file if it exists
            if ($pdfPath && Storage::disk('public')->exists($pdfPath)) {
                Storage::disk('public')->delete($pdfPath);
            }

            

            return response()->json([
                'success' => true,
                'message' => 'Certificate successfully removed from member'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function viewMemberCertificate($certificateId, $memberId)
    {
        $certificate = Certificate::with('signatories')->findOrFail($certificateId);
        $member = Member::findOrFail($memberId);

        return view('certificates.jcertificate  ', [
            'certificate' => $certificate,
            'member' => $member,
            'issueDate' => now()->format('F j, Y'),
        ]);
    }

    public function downloadCertificate($certificateId, $memberId = null)
    {
        // Pass memberId optionally for personalized PDFs
        $dompdf = $this->generatePdf($certificateId, $memberId);

        return response($dompdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="certificate_' . $certificateId . ($memberId ? "_member_{$memberId}" : '') . '.pdf"');
    }


}
