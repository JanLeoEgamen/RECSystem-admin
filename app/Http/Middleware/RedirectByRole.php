<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectByRole
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only check authenticated users
        if (Auth::check()) {
            $user = Auth::user();
            
            // If member tries to access regular dashboard
            if ($user->hasRole('Member') && $request->is('dashboard')) {
                return redirect()->route('member.dashboard');
            }
            
            // Add other role checks as needed
        }

        return $next($request);
    }
}