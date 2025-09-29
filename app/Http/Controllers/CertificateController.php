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
        $query = Certificate::with(['user', 'signatories']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('content', 'like', "%$search%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%");
                  })
                  ->orWhereHas('signatories', function($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
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
        $certificates = $query->paginate($perPage);

        $transformedCertificates = $certificates->getCollection()->map(function ($certificate) {
            return [
                'id' => $certificate->id,
                'title' => $certificate->title,
                'content' => Str::limit(strip_tags($certificate->content), 50),
                'signatories' => $certificate->signatories->pluck('name')->join(', '),
                'author' => $certificate->user->first_name . ' ' . $certificate->user->last_name,
                'created_at' => $certificate->created_at->format('d M, Y'),
            ];
        });

        return response()->json([
            'data' => $transformedCertificates,
            'current_page' => $certificates->currentPage(),
            'last_page' => $certificates->lastPage(),
            'from' => $certificates->firstItem(),
            'to' => $certificates->lastItem(),
            'total' => $certificates->total(),
        ]);
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
            'signatories' => 'required|array|min:1|max:3', // Add max:3 here
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
            'signatories' => 'required|array|min:1|max:3', // Add max:3 here
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
            'dpi' => 96, // Reduced for faster generation
            'isPhpEnabled' => false, // Security improvement
            'marginTop' => '0',
            'marginRight' => '0',
            'marginBottom' => '0',
            'marginLeft' => '0',
            'isHtml5ParserEnabled' => true,
            'debugKeepTemp' => false,
            'debugCss' => false,
            'debugLayout' => false,
            'debugLayoutLines' => false,
            'debugLayoutBlocks' => false,
            'debugLayoutInline' => false,
            'debugLayoutPaddingBox' => false,
        ]);

        $dompdf = new Dompdf($options);

        try {
            $html = view('certificates.jcertificate', [
                'certificate' => $certificate,
                'member' => $member,
                'issueDate' => now()->format('F j, Y'),
            ])->render();

            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            return $dompdf;
        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());
            throw $e;
        }
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
        // Validate the request
        $request->validate([
            'members' => 'required|array',
            'members.*' => 'exists:members,id'
        ]);

        // Find the certificate
        $certificate = Certificate::findOrFail($id);

        // Get the selected member IDs
        $memberIds = $request->input('members');

        foreach ($memberIds as $memberId) {
            // Check if member already has this certificate
            if (!$certificate->members()->where('member_id', $memberId)->exists()) {
                // Just attach the certificate to the member
                $certificate->members()->attach($memberId, [
                    'issued_at' => now(),
                    'pdf_path' => null // No PDF file
                ]);
            }
        }

        return back()->with('success', 'Certificates have been issued to selected members.');
    }



    public function resendCertificate($certificateId, $memberId)
    {
        try {
            $certificate = Certificate::findOrFail($certificateId);
            $member = Member::findOrFail($memberId);

            // Find the latest certificate issuance
            $latestIssue = $certificate->members()
                ->where('member_id', $memberId)
                ->latest('issued_at')
                ->first();

            if (!$latestIssue) {
                // No record exists, create one without PDF generation for faster response
                $certificate->members()->attach($memberId, [
                    'issued_at' => now(),
                    'pdf_path' => null,
                    'sent_at' => now(),
                ]);
            } else {
                // Update sent_at timestamp
                $certificate->members()->updateExistingPivot($memberId, [
                    'sent_at' => now(),
                ]);
            }

            // Dispatch the job for background processing
            SendCertificateJob::dispatch($certificateId, $memberId);

            return redirect()->back()->with('success', 'Certificate resend has been queued and will be processed shortly.');
            
        } catch (\Exception $e) {
            Log::error('Resend Certificate Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to resend certificate. Please try again.');
        }
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
        try {
            // Pass memberId optionally for personalized PDFs
            $dompdf = $this->generatePdf($certificateId, $memberId);
            $output = $dompdf->output();
            
            $filename = 'certificate_' . $certificateId . ($memberId ? "_member_{$memberId}" : '') . '.pdf';
            
            return response($output, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Length' => strlen($output),
                'Cache-Control' => 'no-cache, must-revalidate',
                'Pragma' => 'no-cache',
            ]);
        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate PDF. Please try again.');
        }
    }


}