<?php

use App\Models\MemberActivityLog;
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