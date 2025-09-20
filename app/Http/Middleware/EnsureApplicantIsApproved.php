<?php

namespace App\Http\Middleware;

use App\Models\Applicant;
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
            // Check if payment was rejected/refunded - allow access to form
            $applicant = Applicant::where('user_id', $user->id)->first();
            if ($applicant && in_array($applicant->payment_status, ['rejected', 'refunded'])) {
                return $next($request);
            }
            
            // Redirect to thank you page only if payment is NOT rejected/refunded
            if (!$applicant || !in_array($applicant->payment_status, ['rejected', 'refunded'])) {
                return redirect()->route('applicant.thankyou');
            }
        }
        
        return $next($request);
    }
}
