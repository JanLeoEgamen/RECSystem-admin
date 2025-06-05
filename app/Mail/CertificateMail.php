<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Certificate;
use App\Models\Member;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $certificate;
    public $member;
    public $filename;
    public $filePath;

    public function __construct(Certificate $certificate, Member $member, $filename, $filePath = null)
    {
        $this->certificate = $certificate;
        $this->member = $member;
        $this->filename = $filename;
        $this->filePath = $filePath;
    }

    public function build()
    {
        $mail = $this->subject($this->certificate->title)
            ->markdown('certificates.certificate');
            
        // For new certificates, use the stored content
        if ($this->filePath === null) {
            $mail->attachFromStorageDisk('public', $this->filename, $this->certificate->title . '.pdf', [
                'mime' => 'application/pdf',
            ]);
        } else {
            // For resent certificates, use the file path
            $mail->attach($this->filePath, [
                'as' => $this->certificate->title . '.pdf',
                'mime' => 'application/pdf',
            ]);
        }
            
        return $mail;
    }
}