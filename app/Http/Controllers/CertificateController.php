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
use App\Models\Section;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        try {
            $user = auth()->user();
            
            // Get members based on user's bureau/section access
            $query = Member::with(['section']);
            
            if (!$user->can('view all members')) {
                $sectionIds = DB::table('user_bureau_section')
                    ->where('user_id', $user->id)
                    ->whereNotNull('section_id')
                    ->pluck('section_id');
                
                $bureauIds = DB::table('user_bureau_section')
                    ->where('user_id', $user->id)
                    ->whereNull('section_id')
                    ->pluck('bureau_id');
                
                $bureauSectionIds = Section::whereIn('bureau_id', $bureauIds)->pluck('id');
                
                $allSectionIds = $sectionIds->merge($bureauSectionIds)->unique();
                
                $query->whereIn('section_id', $allSectionIds);
            }

            $members = $query->get(['id', 'first_name', 'last_name', 'section_id']);
            
            // Get sections for filter dropdown
            $sectionsQuery = Section::with('bureau');
            if (!$user->can('view all members')) {
                $sectionsQuery->whereIn('id', $allSectionIds);
            }
            $sections = $sectionsQuery->get(['id', 'section_name', 'bureau_id']);

            return view('certificates.create', compact('members', 'sections'));

        } catch (\Exception $e) {
            Log::error('Certificate create form error: ' . $e->getMessage());
            return redirect()->route('certificates.index')
                ->with('error', 'Failed to load certificate creation form. Please try again.');
        }
    }

    public function edit(string $id)
    {
        try {
            $user = auth()->user();
            $certificate = Certificate::with(['signatories', 'members:id'])->findOrFail($id);
            
            // Get members based on user's bureau/section access
            $query = Member::with(['section']);
            
            if (!$user->can('view all members')) {
                $sectionIds = DB::table('user_bureau_section')
                    ->where('user_id', $user->id)
                    ->whereNotNull('section_id')
                    ->pluck('section_id');
                
                $bureauIds = DB::table('user_bureau_section')
                    ->where('user_id', $user->id)
                    ->whereNull('section_id')
                    ->pluck('bureau_id');
                
                $bureauSectionIds = Section::whereIn('bureau_id', $bureauIds)->pluck('id');
                
                $allSectionIds = $sectionIds->merge($bureauSectionIds)->unique();
                
                $query->whereIn('section_id', $allSectionIds);
            }

            $members = $query->get(['id', 'first_name', 'last_name', 'section_id']);
            
            // Get sections for filter dropdown
            $sectionsQuery = Section::with('bureau');
            if (!$user->can('view all members')) {
                $sectionsQuery->whereIn('id', $allSectionIds);
            }
            $sections = $sectionsQuery->get(['id', 'section_name', 'bureau_id']);

            return view('certificates.edit', compact('certificate', 'members', 'sections'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Certificate not found for editing: {$id}");
            return redirect()->route('certificates.index')
                ->with('error', 'Certificate not found.');

        } catch (\Exception $e) {
            Log::error("Certificate edit form error for ID {$id}: " . $e->getMessage());
            return redirect()->route('certificates.index')
                ->with('error', 'Failed to load certificate edit form. Please try again.');
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'content' => 'required|min:10',
            'signatories' => 'required|array|min:1|max:2', // Add max:2 here
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



    public function update(Request $request, string $id)
    {
        $certificate = Certificate::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'content' => 'required|min:10',
            'signatories' => 'required|array|min:1|max:2', // Add max:2 here
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

    public function previewContent($id)
    {
        $certificate = Certificate::with('signatories')->findOrFail($id);
        
        return view('certificates.jcertificate', [
            'certificate' => $certificate,
            'member' => null,
            'issueDate' => now()->format('F j, Y'),
            'embedded' => true
        ]);
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

        return view('certificates.jcertificate', [
            'certificate' => $certificate,
            'member' => $member,
            'issueDate' => now()->format('F j, Y'),
        ]);
    }

    public function downloadCertificate($certificateId, $memberId = null)
    {
        try {
            Log::info('Download Certificate: Starting download for certificate ' . $certificateId);
            
            $certificate = Certificate::with('signatories')->findOrFail($certificateId);
            $member = $memberId ? Member::findOrFail($memberId) : null;
            
            // Create minimal test data
            $data = [
                'certificate' => $certificate,
                'member' => $member,
                'issueDate' => now()->format('F j, Y')
            ];
            
            // Set a reasonable timeout
            set_time_limit(30);
            
            // Render the view to HTML using the beautiful template with embedded images
            $html = view('certificates.jcertificate', [
                'certificate' => $certificate,
                'member' => $member,
                'issueDate' => now()->format('F j, Y')
            ])->render();
            
            // Convert image URLs to base64 data URLs for PDF generation
            $html = preg_replace_callback('/src="[^"]*\/images\/([^"]+)"/', function($matches) {
                $imagePath = public_path('images/' . $matches[1]);
                if (file_exists($imagePath)) {
                    $imageData = base64_encode(file_get_contents($imagePath));
                    $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                    $mimeType = $extension === 'png' ? 'image/png' : 'image/jpeg';
                    return 'src="data:' . $mimeType . ';base64,' . $imageData . '"';
                }
                return $matches[0]; // Return original if file not found
            }, $html);
            
            // Convert external background image to base64 for PDF compatibility
            $backgroundUrl = 'https://static.vecteezy.com/system/resources/thumbnails/006/513/062/small_2x/abstract-clean-white-soft-cloth-background-with-soft-waves-luxury-gray-curved-smooth-curtain-background-illustration-free-vector.jpg';
            try {
                $backgroundContent = @file_get_contents($backgroundUrl);
                if ($backgroundContent !== false) {
                    $backgroundBase64 = base64_encode($backgroundContent);
                    $html = str_replace(
                        $backgroundUrl,
                        'data:image/jpeg;base64,' . $backgroundBase64,
                        $html
                    );
                } else {
                    // Fallback to gradient if external image fails
                    $html = preg_replace('/background-image:\s*url\([^)]+\);/', 'background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);', $html);
                }
            } catch (\Exception $e) {
                // Fallback to gradient if external image fails
                $html = preg_replace('/background-image:\s*url\([^)]+\);/', 'background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);', $html);
            }
            
            // Remove white spaces by adjusting container margins and padding
            $html = str_replace('margin-top: 8rem;', 'margin-top: 0;', $html);
            $html = str_replace('min-height: 100vh;', 'min-height: auto;', $html);
            $html = str_replace('margin-bottom: 20px;', 'margin-bottom: 0;', $html);
            
            // Remove external font links and replace with safe fonts for PDF
            $html = preg_replace('/<link[^>]*fonts\.cdnfonts\.com[^>]*>/', '', $html);
            $html = str_replace("'FS Elliot Pro', sans-serif", "'Arial', 'Helvetica', sans-serif", $html);
            
            // Remove CSS properties that don't work well with DomPDF
            $html = preg_replace('/box-shadow:[^;]+;/', '', $html);
            
            Log::info('PDF Generation: HTML processed, length: ' . strlen($html));
            
            // Configure DomPDF options for better performance with images
            $options = new Options();
            $options->set('defaultFont', 'Arial');
            $options->set('isRemoteEnabled', false);
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', false);
            $options->set('isFontSubsettingEnabled', false);
            $options->set('debugKeepTemp', false);
            $options->set('dpi', 150); // Higher DPI for better quality
            $options->set('marginTop', 0);
            $options->set('marginRight', 0);
            $options->set('marginBottom', 0);
            $options->set('marginLeft', 0);
            
            // Create DomPDF instance
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            
            // Increase time limit for rendering complex template
            set_time_limit(60);
            $dompdf->render();
            
            $output = $dompdf->output();
            $filename = 'certificate_' . $certificateId . ($memberId ? "_member_{$memberId}" : '') . '.pdf';
            
            Log::info('Download Certificate: PDF generated successfully, size: ' . strlen($output));
            
            return response($output, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Length' => strlen($output),
                'Cache-Control' => 'no-cache, must-revalidate',
                'Pragma' => 'no-cache',
            ]);
            
        } catch (\Exception $e) {
            Log::error('PDF Generation Failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return error page with image download option
            return response()->view('certificates.pdf-generation-failed', [
                'certificate_id' => $certificateId,
                'member_id' => $memberId,
                'error_message' => 'PDF generation failed: ' . $e->getMessage(),
                'image_download_url' => route('certificates.download-image', [
                    'certificate' => $certificateId,
                    'member' => $memberId ?: 0
                ])
            ], 500);
        }
    }


    private function generateImage($certificateId, $memberId = null, $format = 'png')
{
    $certificate = Certificate::with('signatories')->findOrFail($certificateId);
    $member = $memberId ? Member::findOrFail($memberId) : null;

    try {
        Log::info('Image Generation: Starting for certificate ' . $certificateId);
        
        // Generate HTML content with embedded flag
        $html = view('certificates.jcertificate', [
            'certificate' => $certificate,
            'member' => $member,
            'issueDate' => now()->format('F j, Y'),
            'embedded' => true
        ])->render();
        
        // Convert image URLs to base64 data URLs
        $html = preg_replace_callback('/src="[^"]*\/images\/([^"]+)"/', function($matches) {
            $imagePath = public_path('images/' . $matches[1]);
            if (file_exists($imagePath)) {
                $imageData = base64_encode(file_get_contents($imagePath));
                $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                $mimeType = $extension === 'png' ? 'image/png' : 'image/jpeg';
                return 'src="data:' . $mimeType . ';base64,' . $imageData . '"';
            }
            return $matches[0];
        }, $html);
        
        // Convert external background image to base64
        $backgroundUrl = 'https://static.vecteezy.com/system/resources/thumbnails/006/513/062/small_2x/abstract-clean-white-soft-cloth-background-with-soft-waves-luxury-gray-curved-smooth-curtain-background-illustration-free-vector.jpg';
        try {
            $backgroundContent = @file_get_contents($backgroundUrl);
            if ($backgroundContent !== false) {
                $backgroundBase64 = base64_encode($backgroundContent);
                $html = str_replace(
                    $backgroundUrl,
                    'data:image/jpeg;base64,' . $backgroundBase64,
                    $html
                );
            }
        } catch (\Exception $e) {
            Log::warning('Failed to load external background image: ' . $e->getMessage());
        }

        // Remove any margins/padding that might affect layout
        $html = str_replace('margin-top: 8rem;', 'margin-top: 0;', $html);
        $html = str_replace('margin-bottom: 20px;', 'margin-bottom: 0;', $html);
        $html = str_replace('padding: 0;', 'padding: 0; margin: 0;', $html);

        // Create temporary HTML file
        $tempHtmlPath = storage_path('app/temp_certificate_' . uniqid() . '.html');
        file_put_contents($tempHtmlPath, $html);

        // Create output path
        $filename = 'certificate_' . $certificateId . ($memberId ? "_member_{$memberId}" : '') . '.' . $format;
        $outputPath = storage_path('app/public/certificates/' . $filename);
        
        // Ensure directory exists
        $outputDir = dirname($outputPath);
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        // Capture screenshot using updated Node.js script
        $nodeScriptPath = base_path('capture-certificate.cjs');
        $command = "node \"{$nodeScriptPath}\" \"{$tempHtmlPath}\" \"{$outputPath}\"";
        
        Log::info('Image Generation: Executing command - ' . $command);
        
        $output = [];
        $returnCode = 0;
        exec($command . ' 2>&1', $output, $returnCode);
        
        // Clean up temp file
        if (file_exists($tempHtmlPath)) {
            unlink($tempHtmlPath);
        }

        if ($returnCode === 0 && file_exists($outputPath)) {
            Log::info('Image Generation: Success - ' . $outputPath);
            return [
                'success' => true,
                'path' => $outputPath,
                'filename' => $filename,
                'url' => Storage::url('certificates/' . $filename)
            ];
        } else {
            Log::error('Image Generation: Failed with return code ' . $returnCode);
            Log::error('Image Generation: Output - ' . implode("\n", $output));
            throw new \Exception('Failed to generate certificate image: ' . implode("\n", $output));
        }

    } catch (\Exception $e) {
        Log::error('Image Generation Error: ' . $e->getMessage());
        Log::error('Image Generation Stack Trace: ' . $e->getTraceAsString());
        throw $e;
    }
}

    public function downloadImage($certificateId, $memberId = null, $format = 'png')
    {
        // Handle route parameters properly
        if ($memberId && in_array($memberId, ['png', 'jpeg'])) {
            $format = $memberId;
            $memberId = null;
        }
        
        try {
            $result = $this->generateImage($certificateId, $memberId, $format);
            
            if ($result['success']) {
                $certificate = Certificate::findOrFail($certificateId);
                $member = $memberId ? Member::findOrFail($memberId) : null;
                
                $filename = 'certificate_' . $certificate->title;
                if ($member) {
                    $filename .= '_' . str_replace(' ', '_', $member->first_name . '_' . $member->last_name);
                }
                $filename .= '.' . $format;
                
                return response()->download($result['path'], $filename, [
                    'Content-Type' => $format === 'png' ? 'image/png' : 'image/jpeg',
                    'Cache-Control' => 'no-cache, must-revalidate',
                    'Pragma' => 'no-cache',
                ])->deleteFileAfterSend();
            }
            
        } catch (\Exception $e) {
            Log::error('Image Download Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate certificate image. Please try again.');
        }
    }


}