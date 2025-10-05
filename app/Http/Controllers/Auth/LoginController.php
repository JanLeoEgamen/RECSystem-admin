<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\RecaptchaRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class LoginController extends Controller
{
    public function show()
    {
        // Check for existing lockout and set session data
        $email = old('email');
        if ($email) {
            $throttleKey = Str::lower($email).'|'.request()->ip();
            if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
                $seconds = RateLimiter::availableIn($throttleKey);
                session([
                    'lockout_time' => $seconds,
                    'lockout_seconds' => $seconds // Add this for accurate timing
                ]);
            }
        }
        
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => ['required', new RecaptchaRule],
        ]);

        $email = $request->email;
        $throttleKey = Str::lower($email).'|'.$request->ip();

        // Check if user is temporarily locked out (5 attempts)
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            
            // Store lockout time in session for the view
            session([
                'lockout_time' => $seconds,
                'lockout_seconds' => $seconds
            ]);
            
            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again in '.ceil($seconds / 60).' minutes.',
            ])->withInput();
        }

        // Check if user account is permanently locked (3 failed attempts)
        $user = User::where('email', $email)->first();
        if ($user && $user->is_locked) {
            return back()->withErrors([
                'email' => 'Your account has been locked due to too many failed attempts. Please contact the administrator.',
            ])->withInput();
        }

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            // Successful login - reset attempts and lock status
            RateLimiter::clear($throttleKey);
            
            if ($user) {
                $user->update([
                    'login_attempts' => 0,
                    'is_locked' => false,
                    'locked_at' => null
                ]);
            }

            // Clear lockout session
            session()->forget(['lockout_time', 'lockout_seconds']);
            
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // Failed login attempt - increment rate limiter
        // Use 300 seconds (5 minutes) for the decay rate
        RateLimiter::hit($throttleKey, 300);

        if ($user) {
            // Increment user's login attempts
            $user->increment('login_attempts');
            
            // Check if account should be locked after 3 failed attempts
            if ($user->login_attempts >= 3) {
                $user->update([
                    'is_locked' => true,
                    'locked_at' => Carbon::now()
                ]);
                
                return back()->withErrors([
                    'email' => 'Your account has been locked due to too many failed attempts. Please contact the administrator.',
                ])->withInput();
            }
        }

        $attempts = RateLimiter::attempts($throttleKey);
        $remainingAttempts = 5 - $attempts;

        $errorMessage = 'The provided credentials do not match our records.';
        if ($remainingAttempts <= 3) {
            $errorMessage .= ' ' . $remainingAttempts . ' attempts remaining.';
        }

        // Check if this was the 5th attempt to set lockout session
        if ($remainingAttempts <= 0) {
            $seconds = RateLimiter::availableIn($throttleKey);
            session([
                'lockout_time' => $seconds,
                'lockout_seconds' => $seconds
            ]);
        }

        return back()->withErrors([
            'email' => $errorMessage,
        ])->withInput();
    }
}