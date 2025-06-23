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
        ];

        // ✅ Allow /application if editing (has ?edit=1)
        $isEditingPayment = $request->routeIs('applicant.dashboard') && $request->query('edit') === '1';

        // Redirect if pending and not exempt and not editing
        if ($applicant?->status === 'Pending' && !in_array($request->route()->getName(), $exemptRoutes) && !$isEditingPayment) {
            return redirect()->route('applicant.thankyou');
        }

        return $next($request);
    }
}
