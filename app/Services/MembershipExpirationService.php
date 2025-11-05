<?php
namespace App\Services;

use App\Models\User;
use App\Mail\MembershipExpiringSoon;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class MembershipExpirationService
{
    public function checkExpiringMemberships()
    {
        $notificationIntervals = [7, 3, 1];
        
        foreach ($notificationIntervals as $days) {
            $this->sendNotificationsForDays($days);
        }
    }

    private function sendNotificationsForDays($daysLeft)
    {
        $expirationDate = Carbon::now()->addDays($daysLeft);
        
        $expiringMembers = User::where('membership_expires_at', '=', $expirationDate->format('Y-m-d'))
            ->where('status', 'active')
            ->get();

        foreach ($expiringMembers as $member) {
            // Check if we've already sent a notification for this interval
            if (!$this->notificationAlreadySent($member, $daysLeft)) {
                $this->sendNotification($member, $daysLeft);
                $this->recordNotification($member, $daysLeft);
            }
        }
    }

    private function sendNotification($member, $daysLeft)
    {
        $renewalUrl = route('membership.renew', ['token' => $member->renewal_token]);
        
        Mail::to($member->email)->send(new MembershipExpiringSoon($member, $daysLeft, $renewalUrl));
    }

    private function notificationAlreadySent($member, $daysLeft)
    {
        // Implement logic to check if notification was already sent
        // You might want to store this in a database table
        return false; // For now, always send
    }

    private function recordNotification($member, $daysLeft)
    {
        // Implement logic to record that notification was sent
        // This prevents duplicate emails
    }
}