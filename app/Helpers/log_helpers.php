<?php

use App\Models\Applicant;
use App\Models\Member;
use App\Models\MemberActivityLog;
use App\Models\Renewal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Log a member's activity in the activity log table.
 *
 * @param \App\Models\Member $member
 * @param string $type e.g. 'payment', 'status_change', 'profile_update'
 * @param string $action e.g. 'pending', 'succeeded', 'failed', 'updated'
 * @param string|null $details Optional summary message
 * @param array $meta Optional extra details (amount, transaction_id, etc.)
 * @param \App\Models\User|null $performedBy Optional user (default: current logged-in user)
 * @return \App\Models\MemberActivityLog
 */
function logMemberActivity($member, string $type, string $action, ?string $details = null, array $meta = [], $performedBy = null)
{
    try {
        return MemberActivityLog::create([
            'member_id'    => $member->id,
            'type'         => $type,
            'action'       => $action,
            'details'      => $details,
            'meta'         => $meta,
            'performed_by' => $performedBy ? $performedBy->id : Auth::id(),
            'created_at'   => now()
        ]);
    } catch (\Exception $e) {
        Log::error('Failed to log activity', [
            'error' => $e->getMessage(),
            'member_id' => $member->id ?? null,
            'type' => $type,
            'action' => $action
        ]);
        return null;
    }
}

/**
 * Log member registration activity
 */
function logMemberRegistration($member, $details = null, $meta = [])
{
    return logMemberActivity(
        $member,
        'registration',
        'created',
        $details ?? 'Member account created',
        $meta
    );
}

/**
 * Log membership renewal activity
 */
function logMembershipRenewal($member, $status, $details = null, $meta = [])
{
    return logMemberActivity(
        $member,
        'renewal',
        $status,
        $details ?? 'Membership renewal ' . $status,
        $meta
    );
}

/**
 * Log payment activity
 */
function logPaymentActivity($member, $status, $amount, $details = null, $meta = [])
{
    $meta['amount'] = $amount;
    return logMemberActivity(
        $member,
        'payment',
        $status,
        $details ?? 'Payment ' . $status,
        $meta
    );
}

/**
 * Log event participation activity
 */
function logEventParticipation($member, $event, $action, $details = null, $meta = [])
{
    $meta['event_id'] = $event->id;
    $meta['event_title'] = $event->title;
    return logMemberActivity(
        $member,
        'event',
        $action,
        $details ?? 'Event ' . $action,
        $meta
    );
}

/**
 * Log quiz/survey activity
 */
function logQuizSurveyActivity($member, $type, $item, $action, $details = null, $meta = [])
{
    $meta[$type.'_id'] = $item->id;
    $meta[$type.'_title'] = $item->title;
    return logMemberActivity(
        $member,
        $type,
        $action,
        $details ?? ucfirst($type) . ' ' . $action,
        $meta
    );
}

/**
 * Log member login activity
 */
function logMemberLogin($member, $details = null, $meta = [])
{
    return logMemberActivity(
        $member,
        'authentication',
        'login',
        $details ?? 'Member logged in',
        $meta
    );
}

/**
 * Log member logout activity
 */
function logMemberLogout($member, $details = null, $meta = [])
{
    return logMemberActivity(
        $member,
        'authentication',
        'logout',
        $details ?? 'Member logged out',
        $meta
    );
}

/**
 * Log applicant-to-member conversion
 */
function logApplicantToMemberConversion(Applicant $applicant, Member $member, User $approver = null, array $meta = [])
{
    return logMemberActivity(
        $member->id, // Now has member_id
        'approval',
        'converted_to_member',
        "Officially becomes a member",
        array_merge($meta, [
            'applicant_id' => $applicant->id,
            'approved_by' => $approver ? $approver->id : null,
            'membership_type' => $member->membership_type_id,
            'rec_number' => $member->rec_number
        ])
    );
}

/**
 * Log renewal approval
 */
function logRenewalApproved(Member $member, Renewal $renewal, User $processedBy, ?string $remarks = null)
{
    return logMemberActivity(
        $member->id,
        'renewal',
        'approved',
        "Membership renewal approved until {$member->membership_end}",
        [
            'renewal_id' => $renewal->id,
            'processed_by' => $processedBy->id,
            'remarks' => $remarks,
            'new_end_date' => $member->membership_end->toDateString()
        ]
    );
}

/**
 * Log renewal rejection
 */
function logRenewalRejected(Member $member, Renewal $renewal, User $processedBy, ?string $remarks = null)
{
    return logMemberActivity(
        $member->id,
        'renewal',
        'rejected',
        "Renewal rejected: " . ($remarks ?? 'No remarks provided'),
        [
            'renewal_id' => $renewal->id,
            'processed_by' => $processedBy->id,
            'remarks' => $remarks
        ]
    );
}