<?php

namespace App\Jobs;

use App\Models\Certificate;
use App\Models\Member;
use App\Mail\CertificateMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Dompdf\Dompdf;
use Dompdf\Options;
use Intervention\Image\ImageManager;

class SendCertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $certificateId;
    protected $memberId;

    public function __construct($certificateId, $memberId)
    {
        $this->certificateId = $certificateId;
        $this->memberId = $memberId;
    }

    public function handle()
    {
        $certificate = Certificate::findOrFail($this->certificateId);
        $member = Member::findOrFail($this->memberId);

        // Generate HTML with absolute URLs for assets
        $html = view('certificates.jcertificate', [
            'certificate' => $certificate,
            'member' => $member,
            'issueDate' => now()->format('F j, Y'),
        ])->render();

        // Configure DomPDF
        $options = new Options();
        $options->set([
            'isRemoteEnabled' => true,
            'defaultFont' => 'FS Elliot Pro',
            'dpi' => 300,
            'isPhpEnabled' => true,
            'marginTop' => '0',
            'marginRight' => '0',
            'marginBottom' => '0',
            'marginLeft' => '0',
        ]);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Save PDF temporarily
        $tempPdfPath = storage_path("app/temp_certificate_{$this->memberId}.pdf");
        file_put_contents($tempPdfPath, $dompdf->output());

        // Convert PDF to JPG
        $filename = "certificates/{$certificate->id}/member_{$member->id}_" . now()->format('YmdHis') . '.jpg';
        $outputPath = storage_path("app/public/{$filename}");

        // Use Intervention Image to convert PDF to JPG
        $image = ImageManager::imagick()->make($tempPdfPath);
        $image->setResolution(300, 300);
        $image->save($outputPath, 90);

        // Send email
        Mail::to($member->email)->send(new CertificateMail($certificate, $member, $filename));

        // Update database
        $certificate->members()->syncWithoutDetaching([
            $member->id => [
                'issued_at' => now(),
                'pdf_path' => $filename,
                'sent_at' => now()
            ]
        ]);

        // Clean up
        unlink($tempPdfPath);
    }
}