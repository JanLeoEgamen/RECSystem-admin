<?php

namespace App\Http\Controllers;

use App\Mail\RenewalApproved;
use App\Mail\RenewalRejected;
use App\Models\Member;
use App\Models\Renewal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Mail;

class RenewalController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view renewals', only: ['index']),
            new Middleware('permission:assess renewals', only: ['edit']),
        ];
    }

    // Member renewal form


    // List pending renewals (for admin)
    public function index()
    {
        $renewals = Renewal::with(['member', 'member.user'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('renew.list', compact('renewals'));
    }

    // Show assessment form
    public function edit(Renewal $renewal)
    {
        return view('renew.assess', compact('renewal'));
    }

    // Process assessment
    public function update(Request $request, Renewal $renewal)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $renewal->update([
            'status' => $request->status,
            'remarks' => $request->remarks,
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        $member = $renewal->member;
        $user = $member->user;

        if ($request->status === 'approved') {
            // Update membership
            $member->update([
                'last_renewal_date' => now(),
                'membership_end' => now()->addYear(),
            ]);

            // Send approval email
            Mail::to($user->email)->send(
                new RenewalApproved($user->name, $member->membership_end)
            );

        } elseif ($request->status === 'rejected') {
            // Send rejection email
            Mail::to($user->email)->send(
                new RenewalRejected($user->name, $request->remarks)
            );
        }

        return redirect()->route('renew.index')->with('success', 'Renewal request processed successfully!');
    }

    // Show history
    public function history()
    {
        $renewals = Renewal::with(['member', 'member.user', 'processor'])
            ->where('status', '!=', 'pending')
            ->latest()
            ->get();

        return view('renew.history', compact('renewals'));
    }
}