<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Applicant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Activitylog\Facades\CauserResolver;
use Spatie\Activitylog\Facades\LogBatch;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();
        
        if ($user->hasRole('Member')) {
            return redirect()->intended(route('member.dashboard'));
        }

        // Log the login activity
        LogBatch::startBatch();
        
        CauserResolver::setCauser($user);
        
        activity()
            ->useLog('authentication')
            ->causedBy($user)
            ->withProperties([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'login_time' => now(),
                'status' => 'success'
            ])
            ->log('user_login');
            
        LogBatch::endBatch();


        if ($user->hasRole('Member')) {
            return redirect()->route('member.dashboard');
        }

        if ($user->hasRole('Applicant')) {
            //  Check the applicant's status (not user's)
            $applicant = Applicant::where('user_id', $user->id)->first();

            if ($applicant && $applicant->status === 'Pending') {
                return redirect()->route('applicant.thankyou');
            }
            return redirect()->route('applicant.dashboard');
        }

        return redirect()->route('dashboard');
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Get user before logout
        $user = $request->user();
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();

        // Perform logout
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Log the logout activity if user was authenticated
        if ($user) {
            LogBatch::startBatch();
            
            CauserResolver::setCauser($user);
            
            activity()
                ->useLog('authentication')
                ->causedBy($user)
                ->withProperties([
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                    'logout_time' => now(),
                    'status' => 'success'
                ])
                ->log('user_logout');
                
            LogBatch::endBatch();
        }

        return redirect('/');
    }
}
