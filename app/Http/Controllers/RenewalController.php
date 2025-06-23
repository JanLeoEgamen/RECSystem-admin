<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Renewal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

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

        if ($request->status === 'approved') {
            // Update member's membership end date (you might want to adjust this logic)
            $member = $renewal->member;
            $member->update([
                'last_renewal_date' => now(),
                'membership_end' => now()->addYear(), // or whatever your renewal period is
            ]);
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