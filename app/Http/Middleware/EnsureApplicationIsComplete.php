<?php

namespace App\Http\Middleware;

use App\Models\Applicant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureApplicationIsComplete
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Skip middleware for guest users or exempted routes
        if (!$user || $request->is('application*') || $request->is('logout')) {
            return $next($request);
        }

        $applicant = Applicant::where('user_id', $user->id)->first();

        // No application exists - redirect to form
        if (!$applicant) {
            return redirect()->route('applicant.form');
        }

        // Application is pending - redirect to thank you page
        if ($applicant->status === 'Pending') {
            return redirect()->route('applicant.thankyou');
        }

        // Application is rejected/needs changes - redirect to form
        if ($applicant->status === 'Rejected') {
            return redirect()->route('applicant.form')
                ->with('error', 'Please update your application as requested.');
        }

        // Application is approved - allow access
        if ($applicant->status === 'Approved') {
            return $next($request);
        }

        // Default fallback (shouldn't reach here)
        return redirect()->route('applicant.form');
    }
}