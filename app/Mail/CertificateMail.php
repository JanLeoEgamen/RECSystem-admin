<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Certificate;
use App\Models\Member;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $certificate;
    public $member;
    public $imagePath;
    public $imageName;

    /**
     * Create a new message instance.
     *
     * @param Certificate $certificate
     * @param Member $member
     * @param string $imagePath Path to the image (storage path or public path)
     * @param string|null $customName Optional custom filename for attachment
     */
    public function __construct(Certificate $certificate, Member $member, string $imagePath, ?string $customName = null)
    {
        $this->certificate = $certificate;
        $this->member = $member;
        $this->imagePath = $imagePath;
        $this->imageName = $customName ?? $this->generateDefaultFilename();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject("Your Certificate: {$this->certificate->title}")
                    ->markdown('emails.certificate', [
                        'certificate' => $this->certificate,
                        'member' => $this->member,
                    ]);

        // Attach the certificate image
        $this->attachCertificateImage($mail);

        return $mail;
    }

    /**
     * Handle the certificate image attachment
     */
    protected function attachCertificateImage($mail)
    {
        try {
            if (Storage::disk('public')->exists($this->imagePath)) {
                // File exists in storage
                $mail->attachFromStorageDisk('public', $this->imagePath, [
                    'as' => $this->imageName,
                    'mime' => $this->getMimeType(),
                ]);
            } elseif (file_exists($this->imagePath)) {
                // Absolute path to file
                $mail->attach($this->imagePath, [
                    'as' => $this->imageName,
                    'mime' => $this->getMimeType(),
                ]);
            } else {
                Log::error("Certificate image not found: {$this->imagePath}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to attach certificate image: {$e->getMessage()}");
        }
    }

    /**
     * Generate a default filename for the attachment
     */
    protected function generateDefaultFilename(): string
    {
        $cleanTitle = preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $this->certificate->title);
        return "certificate_{$cleanTitle}_{$this->member->id}.jpg";
    }

    /**
     * Determine the MIME type based on file extension
     */
    protected function getMimeType(): string
    {
        $extension = pathinfo($this->imageName, PATHINFO_EXTENSION);
        
        return match(strtolower($extension)) {
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'image/jpeg',
        };
    }
}