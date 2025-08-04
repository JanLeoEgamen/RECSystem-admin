<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)                    // Minimum 8 characters
                    ->letters()                     // Must contain at least one letter
                    ->mixedCase()                  // Must contain both uppercase and lowercase
                    ->numbers()                    // Must contain at least one number
                    ->symbols()                    // Must contain at least one symbol
                    ->uncompromised(),              // Must not be compromised in data leaks
                // Add validation to prevent same as current password
                function ($attribute, $value, $fail) use ($request) {
                    if (Hash::check($value, $request->user()->password)) {
                        $fail('The new password must be different from your current password.');
                    }
                }

            ],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}