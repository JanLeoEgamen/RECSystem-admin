<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentRefundedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $applicant;
    public $refundAmount;
    public $remarks;
    public $refundReceiptPath;

    public function __construct($applicant, $refundAmount, $remarks = null, $refundReceiptPath = null)
    {
        $this->applicant = $applicant;
        $this->refundAmount = $refundAmount;
        $this->remarks = $remarks;
        $this->refundReceiptPath = $refundReceiptPath;
    }

    public function build()
    {
        return $this->subject('Your Payment Refund Has Been Processed')
            ->view('emails.payment_refunded');
    }
}
