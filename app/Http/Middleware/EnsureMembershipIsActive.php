<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMembershipIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = auth()->user();
        $member = $user?->member;

        if (
            $member &&
            !$member->is_lifetime_member &&
            $member->membership_end &&
            now()->gt($member->membership_end) &&
            !$request->routeIs('member.renew')
        ) {
            return redirect()->route('member.renew');
        }

        return $next($request);
    }
}
