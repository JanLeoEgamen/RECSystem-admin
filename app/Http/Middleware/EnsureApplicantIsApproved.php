<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApplicantIsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (
            $user &&
            $user->hasRole('Applicant') &&
            $user->status === 'pending' &&
            !$request->is('applicant-dashboard/applicationSent')
        ) {
            return redirect()->route('applicant.thankyou');
        }
        
        return $next($request);
    }
}
