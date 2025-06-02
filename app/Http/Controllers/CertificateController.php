<?php

namespace App\Http\Controllers;

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
                    
                    if (request()->user()->can('edit certificates')) {
                        $buttons .= '<a href="'.route('certificates.edit', $row->id).'" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 rounded-full transition-colors duration-200" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>';
                    }

                    if (request()->user()->can('delete certificates')) {
                        $buttons .= '<a href="javascript:void(0)" onclick="deleteCertificate('.$row->id.')" class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" title="Delete">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </a>';
                    }

                    // Preview button
                    $buttons .= '<a href="'.route('certificates.preview', $row->id).'" class="p-2 text-blue-600 hover:text-white hover:bg-blue-600 rounded-full transition-colors duration-200" title="Preview">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </a>';

                    return '<div class="flex space-x-2">'.$buttons.'</div>';
                })
                ->editColumn('content', function($row) {
                    return Str::limit(strip_tags($row->content), 50);
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
        
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        
        $dompdf = new Dompdf($options);
        
        $html = view('certificates.pdf-template', [
            'certificate' => $certificate,
            'member' => null, // No member for preview
            'issueDate' => now()->format('F j, Y')
        ])->render();
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        return $dompdf->stream("certificate_preview_{$id}.pdf", ['Attachment' => false]);
    }

    public function preview($id)
    {
        $certificate = Certificate::with('signatories')->findOrFail($id);
        return view('certificates.preview', compact('certificate'));
    }


    public function generatePdf($certificateId, $memberId = null)
    {
        $certificate = Certificate::with('signatories')->findOrFail($certificateId);
        $member = $memberId ? Member::findOrFail($memberId) : null;

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        
        $dompdf = new Dompdf($options);
        
        $html = view('certificates.pdf-template', [
            'certificate' => $certificate,
            'member' => $member,
            'issueDate' => now()->format('F j, Y')
        ])->render();
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        return $dompdf;
    }


    public function download($id)
    {
        $dompdf = $this->generatePdf($id);
        return $dompdf->stream("certificate_{$id}.pdf");
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

        $certificate = Certificate::findOrFail($id);
        $memberIds = $request->input('members', []);
        
        foreach ($memberIds as $memberId) {
            $member = Member::findOrFail($memberId);
            
            // Generate PDF
            $dompdf = $this->generatePdf($id, $memberId);
            $pdfContent = $dompdf->output();
            
            // Save PDF to storage (using 'public' disk which points to public/images)
            $filename = "certificates/{$certificate->id}/member_{$member->id}_".now()->format('YmdHis').'.pdf';
            Storage::disk('public')->put($filename, $pdfContent);
            
            // Send email
            Mail::to($member->email_address)->send(new CertificateMail($certificate, $member, $filename));
            
            // Attach to certificate
            $certificate->members()->attach($memberId, [
                'issued_at' => now(),
                'pdf_path' => $filename
            ]);
        }
        
        return redirect()->route('certificates.send', $id)
            ->with('success', 'Certificates sent successfully');
    }



    public function resendCertificate($certificateId, $memberId)
    {
        $certificate = Certificate::findOrFail($certificateId);
        $member = Member::findOrFail($memberId);
        
        $latestIssue = $certificate->members()->where('member_id', $memberId)
            ->orderBy('issued_at', 'desc')
            ->first();
        
        if (!$latestIssue) {
            return back()->with('error', 'No certificate found to resend');
        }
        
        // Get the full path to the PDF file
        $filePath = Storage::disk('public')->path($latestIssue->pivot->pdf_path);
        
        // Send email with attachment
        Mail::to($member->email_address)->send(new CertificateMail(
            $certificate, 
            $member, 
            $latestIssue->pivot->pdf_path,
            $filePath
        ));
        
        // Update sent_at timestamp
        $certificate->members()->updateExistingPivot($memberId, [
            'sent_at' => now()
        ]);
        
        return back()->with('success', 'Certificate resent successfully');
    }

}
