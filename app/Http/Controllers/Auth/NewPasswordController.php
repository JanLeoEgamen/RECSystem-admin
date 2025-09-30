<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Check if new password is different from current password FIRST
            if (Hash::check($request->password, $user->password)) {
                if ($request->expectsJson()) {
                    throw ValidationException::withMessages([
                        'password' => ['The new password must be different from your current password.'],
                    ]);
                } else {
                    return back()->withErrors(['password' => 'The new password must be different from your current password.']);
                }
            }

            // Then check if password was used in last 5 passwords
            if ($user->isPasswordInHistory($request->password)) {
                if ($request->expectsJson()) {
                    throw ValidationException::withMessages([
                        'password' => ['You cannot use any of your last 5 passwords. Please choose a new password.'],
                    ]);
                } else {
                    return back()->withErrors(['password' => 'You cannot use any of your last 5 passwords. Please choose a new password.']);
                }
            }
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                // Add current password to history before changing it
                // Make sure to pass the hashed password
                $user->addPasswordToHistory($user->password);

                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // Handle JSON responses for AJAX requests
        if ($request->expectsJson()) {
            if ($status == Password::PASSWORD_RESET) {
                return response()->json([
                    'message' => __($status),
                    'redirect' => route('login')
                ]);
            } else {
                return response()->json([
                    'message' => __($status),
                    'errors' => ['email' => [__($status)]]
                ], 422);
            }
        }

        // Handle regular form submissions
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}