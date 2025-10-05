<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

class LockedAccountsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:unlock accounts'),
        ];
    }

    /**
     * Display a listing of locked accounts.
     */
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = User::where('is_locked', true)
                    ->with(['roles', 'assignedBureaus', 'assignedSections']);

                // Search functionality
                if ($request->has('search') && $request->search != '') {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                    });
                }

                // Sorting
                if ($request->has('sort') && $request->has('direction')) {
                    $sort = $request->sort;
                    $direction = $request->direction;
                    
                    switch ($sort) {
                        case 'name':
                            $query->orderBy('first_name', $direction)
                                ->orderBy('last_name', $direction);
                            break;
                            
                        case 'email':
                            $query->orderBy('email', $direction);
                            break;
                            
                        case 'locked_at':
                            $query->orderBy('locked_at', $direction);
                            break;
                            
                        default:
                            $query->orderBy('locked_at', 'desc');
                            break;
                    }
                } else {
                    $query->orderBy('locked_at', 'desc');
                }

                $perPage = $request->input('perPage', 10);
                $users = $query->paginate($perPage);

                $transformedUsers = $users->getCollection()->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->first_name . ' ' . $user->last_name,
                        'email' => $user->email,
                        'roles' => $user->roles->pluck('name')->implode(', '),
                        'login_attempts' => $user->login_attempts,
                        'locked_at' => $user->locked_at ? $user->locked_at->format('M d, Y h:i A') : 'N/A',
                        'assignments' => collect([
                            ...$user->assignedBureaus->map(fn($b) => 'Bureau: ' . $b->bureau_name),
                            ...$user->assignedSections->map(fn($s) => 'Section: ' . $s->section_name . ' (' . $s->bureau->bureau_name . ')'),
                        ])->implode('<br>'),
                    ];
                });

                return response()->json([
                    'data' => $transformedUsers,
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                    'total' => $users->total(),
                ]);
            }

            return view('locked-accounts');

        } catch (\Exception $e) {
            Log::error('Error in LockedAccountsController@index: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Failed to retrieve locked accounts. Please try again.'
                ], 500);
            }
            
            return back()->with('error', 'Failed to load locked accounts. Please try again.');
        }
    }

    /**
     * Unlock a user account.
     */
    public function unlock(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);

            $user->update([
                'is_locked' => false,
                'login_attempts' => 0,
                'locked_at' => null
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Account unlocked successfully.'
                ]);
            }

            return back()->with('success', 'Account unlocked successfully.');

        } catch (\Exception $e) {
            Log::error('Error unlocking account: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to unlock account. Please try again.'
                ], 500);
            }
            
            return back()->with('error', 'Failed to unlock account. Please try again.');
        }
    }
}