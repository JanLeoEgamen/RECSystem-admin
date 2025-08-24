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
use Illuminate\Support\Facades\Log;
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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Renewal::with(['member', 'member.user'])
                ->where('status', 'pending');

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('reference_number', 'like', "%$search%")
                    ->orWhereHas('member.user', function($q) use ($search) {
                        $q->where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%");
                    });
                });
            }

            if ($request->has('sort') && $request->has('direction')) {
                $sort = $request->sort;
                $direction = $request->direction;
                
                switch ($sort) {
                    case 'name':
                        $query->join('members', 'renewals.member_id', '=', 'members.id')
                            ->join('users', 'members.user_id', '=', 'users.id')
                            ->orderBy('users.last_name', $direction)
                            ->orderBy('users.first_name', $direction)
                            ->select('renewals.*');
                        break;
                        
                    case 'created':
                        $query->orderBy('created_at', $direction);
                        break;
                        
                    default:
                        $query->orderBy('created_at', 'desc');
                        break;
                }
            } else {
                $query->orderBy('created_at', 'desc');
            }

            $perPage = $request->input('perPage', 10);
            $renewals = $query->paginate($perPage);

            $transformedRenewals = $renewals->getCollection()->map(function ($renewal) {
                return [
                    'id' => $renewal->id,
                    'member' => [
                        'user' => $renewal->member->user ?? null
                    ],
                    'reference_number' => $renewal->reference_number,
                    'receipt_path' => $renewal->receipt_path,
                    'created_at' => $renewal->created_at,
                ];
            });

            return response()->json([
                'data' => $transformedRenewals,
                'current_page' => $renewals->currentPage(),
                'last_page' => $renewals->lastPage(),
                'from' => $renewals->firstItem(),
                'to' => $renewals->lastItem(),
                'total' => $renewals->total(),
            ]);
        }

        return view('renew.list');
    }

    // Show assessment form
    public function edit(Renewal $renewal)
    {
        Log::info('Renewal Assessment Access Attempt', [
        'renewal_id' => $renewal->id,
        'user_id' => auth()->id(),
        'user_email' => auth()->user()->email,
        'has_permission' => auth()->user()->can('assess renewals'),
        'route' => request()->fullUrl()
    ]);

    // Check permission
    if (!auth()->user()->can('assess renewals')) {
        Log::warning('Permission Denied for Renewal Assessment', [
            'renewal_id' => $renewal->id,
            'user_id' => auth()->id()
        ]);
        return redirect()->route('dashboard');
    }
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
        $processor = Auth::user();

        if ($request->status === 'approved') {
            // Update membership
            $member->update([
                'last_renewal_date' => now(),
                'membership_end' => now()->addYear(),
            ]);

            /***** CRITICAL LOG *****/
            logRenewalApproved($member, $renewal, $processor, $request->remarks);

            // Send approval email
            Mail::to($user->email)->send(
                new RenewalApproved($user->name, $member->membership_end)
            );

        } elseif ($request->status === 'rejected') {
            /***** CRITICAL LOG *****/
            logRenewalRejected($member, $renewal, $processor, $request->remarks);

            // Send rejection email
            Mail::to($user->email)->send(
                new RenewalRejected($user->name, $request->remarks)
            );
        }

        return redirect()->route('renew.index')->with('success', 'Renewal request processed successfully!');
    }

    // Show history
    public function history(Request $request)
    {
        if ($request->ajax()) {
            $query = Renewal::with(['member.user', 'processor'])
                ->where('status', '!=', 'pending');

            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('reference_number', 'like', "%$search%")
                      ->orWhereHas('member.user', function($q) use ($search) {
                          $q->where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%");
                      })
                      ->orWhereHas('processor', function($q) use ($search) {
                          $q->where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%");
                      });
                });
            }

            // Status filter
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            // Sorting
            if ($request->has('sort') && $request->has('direction')) {
                $sort = $request->sort;
                $direction = $request->direction;
                
                switch ($sort) {
                    case 'name':
                        $query->join('members', 'renewals.member_id', '=', 'members.id')
                            ->join('users', 'members.user_id', '=', 'users.id')
                            ->orderBy('users.last_name', $direction)
                            ->orderBy('users.first_name', $direction)
                            ->select('renewals.*');
                        break;
                        
                    case 'reference':
                        $query->orderBy('reference_number', $direction);
                        break;
                        
                    case 'status':
                        $query->orderBy('status', $direction);
                        break;
                        
                    case 'processed_at':
                        $query->orderBy('processed_at', $direction);
                        break;
                        
                    default:
                        $query->orderBy('processed_at', 'desc');
                        break;
                }
            } else {
                $query->orderBy('processed_at', 'desc');
            }

            $perPage = $request->input('perPage', 10);
            $renewals = $query->paginate($perPage);

            $transformedRenewals = $renewals->getCollection()->map(function ($renewal) {
                return [
                    'id' => $renewal->id,
                    'member_name' => $renewal->member->user->first_name . ' ' . $renewal->member->user->last_name,
                    'reference_number' => $renewal->reference_number,
                    'status' => $renewal->status,
                    'processed_by' => $renewal->processor ? $renewal->processor->first_name . ' ' . $renewal->processor->last_name : 'System',
                    'processed_at' => $renewal->processed_at ? $renewal->processed_at->format('M d, Y h:i A') : 'N/A',
                    'receipt_url' => $renewal->receipt_path ? Storage::url($renewal->receipt_path) : null,
                ];
            });

            return response()->json([
                'data' => $transformedRenewals,
                'current_page' => $renewals->currentPage(),
                'last_page' => $renewals->lastPage(),
                'from' => $renewals->firstItem(),
                'to' => $renewals->lastItem(),
                'total' => $renewals->total(),
            ]);
        }

        // For non-AJAX requests, just return the view
        return view('renew.history');
    }
}