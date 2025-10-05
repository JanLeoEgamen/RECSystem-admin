<?php

namespace App\Jobs;

use App\Models\Member;
use App\Models\EmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendBulkEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $memberId; // Use ID instead of full object to avoid serialization issues
    public $subject;
    public $messageContent;
    public $templateId;
    public $savedAttachments;
    public $userId;

    public function __construct($memberId, $subject, $messageContent, $templateId, $savedAttachments, $userId)
    {
        $this->memberId = $memberId;
        $this->subject = $subject;
        $this->messageContent = $messageContent;
        $this->templateId = $templateId;
        $this->savedAttachments = $savedAttachments;
        $this->userId = $userId;
    }

    public function handle()
    {
        $member = Member::findOrFail($this->memberId);
        
        try {
            Mail::send('emails.template', [
                'user' => $member,
                'custom_message' => $this->messageContent,
                'subject' => $this->subject,
                'messageContent' => $this->messageContent
            ], function ($message) use ($member) {
                // FIXED: Use email_address instead of email
                $message->to($member->email_address, $member->first_name . ' ' . $member->last_name)
                        ->subject($this->subject);

                // Attach files from storage
                foreach ($this->savedAttachments as $attachment) {
                    $fullPath = Storage::disk('public')->path($attachment['path']);
                    if (file_exists($fullPath)) {
                        $message->attach($fullPath, ['as' => $attachment['name']]);
                    }
                }
            });

            EmailLog::create([
                // FIXED: Use email_address instead of email
                'recipient_email' => $member->email_address,
                'recipient_name' => $member->first_name . ' ' . $member->last_name,
                'template_id' => $this->templateId,
                'subject' => $this->subject,
                'body' => $this->messageContent,
                'status' => 'sent',
                'error_message' => null,
                'sent_at' => now(),
                'sent_by' => $this->userId,
                'attachments' => $this->savedAttachments,
            ]);

            Log::info('Email sent successfully to: ' . $member->email_address);

        } catch (\Exception $e) {
            Log::error('Email failed to: ' . ($member->email_address ?? 'unknown'), [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            EmailLog::create([
                'recipient_email' => $member->email_address ?? 'unknown',
                'recipient_name' => $member->first_name . ' ' . $member->last_name ?? 'unknown',
                'template_id' => $this->templateId,
                'subject' => $this->subject,
                'body' => $this->messageContent,
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'sent_at' => now(),
                'sent_by' => $this->userId,
                'attachments' => $this->savedAttachments ?? null,
            ]); 

            throw $e;
        }
    }
}