<?php

namespace App\Http\Middleware;

use App\Models\Applicant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RedirectPendingApplicants
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // In RedirectPendingApplicants middleware:
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        // Skip if no user or not an Applicant
        if (!$user || !$user->hasRole('Applicant')) {
            return $next($request);
        }

        // Skip verification-related routes
        if ($request->is('email/*') || $request->is('verify-email')) {
            return $next($request);
        }

        $applicant = Applicant::where('user_id', $user->id)->first();

        // Define exempt routes
        $exemptRoutes = [
            '/',
            'logout',
            'applicant.thankyou',
            'verification.notice',
            'verification.verify',
            'verification.send',
            'applicant.dashboard', // Allow access to application form
            'applicant.store', // Allow form submission
        ];

        // Allow access to application form for rejected/refunded payments
        $isPaymentRejectedOrRefunded = $applicant && in_array($applicant->payment_status, ['rejected', 'refunded']);
        
        if ($isPaymentRejectedOrRefunded) {
            if ($request->routeIs('applicant.dashboard') || $request->routeIs('applicant.store')) {
                return $next($request);
            }
            // Redirect to form for rejected payments trying to access other pages
            if (!in_array($request->route()->getName(), $exemptRoutes)) {
                return redirect()->route('applicant.dashboard');
            }
        }

        // Redirect if pending and not exempt (only for non-rejected payments)
        if ($applicant?->status === 'Pending' && !$isPaymentRejectedOrRefunded && !in_array($request->route()->getName(), $exemptRoutes)) {
            return redirect()->route('applicant.thankyou');
        }

        return $next($request);
    }
}
