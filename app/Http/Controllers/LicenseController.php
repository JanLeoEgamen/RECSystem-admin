<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class LicenseController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view licenses', only: ['index', 'unlicensed', 'show']),
            new Middleware('permission:edit licenses', only: ['edit', 'update']),
            new Middleware('permission:delete licenses', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Member::with(['membershipType:id,type_name', 'section.bureau:id,bureau_name'])
                    ->whereNotNull('license_number')
                    ->whereNotNull('license_class');

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $query->where(function ($q) use ($request) {
                        $q->where('first_name', 'like', '%' . $request->search . '%')
                          ->orWhere('last_name', 'like', '%' . $request->search . '%')
                          ->orWhere('callsign', 'like', '%' . $request->search . '%')
                          ->orWhere('license_number', 'like', '%' . $request->search . '%')
                          ->orWhere('license_class', 'like', '%' . $request->search . '%')
                          ->orWhereHas('section.bureau', function($q) use ($request) {
                              $q->where('bureau_name', 'like', '%' . $request->search . '%');
                          });
                    });
                }

                // Apply sorting
                $this->applySorting($query, $request);

                // Pagination
                $perPage = $request->input('perPage', 10);
                $members = $query->paginate($perPage);

                $transformedMembers = $members->getCollection()->map(function ($member) {
                    return [
                        'id' => $member->id,
                        'name' => $member->first_name . ' ' . $member->last_name,
                        'callsign' => $member->callsign,
                        'license_class' => $member->license_class,
                        'membership_type' => $member->membershipType->type_name ?? 'N/A',
                        'bureau' => $member->section->bureau->bureau_name ?? 'N/A',
                        'section' => $member->section->section_name ?? 'N/A',
                        'license_validity' => $this->formatLicenseValidity($member->license_expiration_date),
                        'can_view' => request()->user()->can('view licenses'),
                        'can_edit' => request()->user()->can('edit licenses'),
                        'can_delete' => request()->user()->can('delete licenses'),
                    ];
                });

                return response()->json([
                    'data' => $transformedMembers,
                    'current_page' => $members->currentPage(),
                    'last_page' => $members->lastPage(),
                    'from' => $members->firstItem(),
                    'to' => $members->lastItem(),
                    'total' => $members->total(),
                ]);
            }

            return view('licenses.list');

        } catch (\Exception $e) {
            Log::error('License index error: ' . $e->getMessage());
            
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load licensed members'], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('error', 'Failed to load licensed members. Please try again.');
        }
    }

    public function unlicensed(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Member::with(['membershipType:id,type_name', 'section.bureau:id,bureau_name'])
                    ->where(function($query) {
                        $query->whereNull('license_number')
                            ->orWhereNull('license_class');
                    });

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $query->where(function ($q) use ($request) {
                        $q->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%')
                        ->orWhereHas('membershipType', function($q) use ($request) {
                            $q->where('type_name', 'like', '%' . $request->search . '%');
                        })
                        ->orWhereHas('section.bureau', function($q) use ($request) {
                            $q->where('bureau_name', 'like', '%' . $request->search . '%');
                        })
                        ->orWhereHas('section', function($q) use ($request) {
                            $q->where('section_name', 'like', '%' . $request->search . '%');
                        });
                    });
                }

                // Apply sorting
                $this->applyUnlicensedSorting($query, $request);

                // Pagination
                $perPage = $request->input('perPage', 10);
                $members = $query->paginate($perPage);

                $transformedMembers = $members->getCollection()->map(function ($member) {
                    return [
                        'id' => $member->id,
                        'name' => $member->first_name . ' ' . $member->last_name,
                        'membership_type' => $member->membershipType->type_name ?? 'N/A',
                        'bureau' => $member->section->bureau->bureau_name ?? 'N/A',
                        'section' => $member->section->section_name ?? 'N/A',
                        'can_edit' => request()->user()->can('edit licenses'),
                    ];
                });

                return response()->json([
                    'data' => $transformedMembers,
                    'current_page' => $members->currentPage(),
                    'last_page' => $members->lastPage(),
                    'from' => $members->firstItem(),
                    'to' => $members->lastItem(),
                    'total' => $members->total(),
                ]);
            }
            
            return view('licenses.unlicensed');

        } catch (\Exception $e) {
            Log::error('Unlicensed members list error: ' . $e->getMessage());
            
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load unlicensed members'], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('error', 'Failed to load unlicensed members. Please try again.');
        }
    }

    protected function applyUnlicensedSorting($query, Request $request): void
    {
        $sort = $request->sort ?? 'created_at';
        $direction = in_array(strtolower($request->direction ?? 'desc'), ['asc', 'desc']) 
            ? $request->direction 
            : 'desc';

        switch ($sort) {
            case 'name':
                $query->orderBy('last_name', $direction)
                    ->orderBy('first_name', $direction);
                break;
                
            case 'membership_type':
                $query->leftJoin('membership_types', 'members.membership_type_id', '=', 'membership_types.id')
                    ->orderBy('membership_types.type_name', $direction)
                    ->select('members.*');
                break;
                
            case 'bureau':
                $query->leftJoin('sections', 'members.section_id', '=', 'sections.id')
                    ->leftJoin('bureaus', 'sections.bureau_id', '=', 'bureaus.id')
                    ->orderBy('bureaus.bureau_name', $direction)
                    ->select('members.*');
                break;
                
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    }


    public function show(string $id)
    {
        try {
            $member = Member::with(['membershipType:id,type_name', 'section.bureau:id,bureau_name'])
                ->findOrFail($id);
                
            return view('licenses.show', compact('member'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Member not found for license view: {$id}");
            return redirect()->route('licenses.index')
                ->with('error', 'Member not found.');

        } catch (\Exception $e) {
            Log::error("License show error for ID {$id}: " . $e->getMessage());
            return redirect()->route('licenses.index')
                ->with('error', 'Failed to load license details. Please try again.');
        }
    }

    public function edit(string $id)
    {
        try {
            $member = Member::with(['membershipType:id,type_name', 'section.bureau:id,bureau_name'])
                ->findOrFail($id);
                
            // Convert license_expiration_date to Carbon instance if it exists
            if ($member->license_expiration_date) {
                $member->license_expiration_date = Carbon::parse($member->license_expiration_date);
            }

            return view('licenses.edit', compact('member'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Member not found for license edit: {$id}");
            return redirect()->route('licenses.index')
                ->with('error', 'Member not found.');

        } catch (\Exception $e) {
            Log::error("License edit form error for ID {$id}: " . $e->getMessage());
            return redirect()->route('licenses.index')
                ->with('error', 'Failed to load license edit form. Please try again.');
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $member = Member::findOrFail($id);
            $validated = $this->validateLicenseRequest($request, $id);

            $member->update([
                'license_class' => $validated['license_class'],
                'license_number' => $validated['license_number'],
                'license_expiration_date' => $validated['license_expiration_date'],
                'callsign' => $validated['callsign'] ?? null,
            ]);

            return redirect()->route('licenses.index')
                ->with('success', 'License information updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::warning("Member not found for license update: {$id}");
            return redirect()->route('licenses.index')
                ->with('error', 'Member not found.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error("License update error for ID {$id}: " . $e->getMessage());
            return redirect()->route('licenses.edit', $id)
                ->withInput()
                ->with('error', 'Failed to update license information. Please try again.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $member = Member::findOrFail($request->id);
            
            $member->update([
                'license_class' => null,
                'license_number' => null,
                'license_expiration_date' => null,
                'callsign' => null,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'License information removed successfully'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("Member not found for license removal: {$request->id}");
            return response()->json([
                'status' => false,
                'message' => 'Member not found.'
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            Log::error("License removal error for ID {$request->id}: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to remove license information. Please try again.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Validate license request data
     */
    protected function validateLicenseRequest(Request $request, $memberId): array
    {
        return $request->validate([
            'license_class' => 'required|string|max:255',
            'license_number' => 'required|string|max:255|unique:members,license_number,'.$memberId,
            'license_expiration_date' => 'required|date|after_or_equal:today',
            'callsign' => 'nullable|string|max:255',
        ]);
    }

    /**
     * Apply sorting to the query
     */
    protected function applySorting($query, Request $request): void
    {
        $sort = $request->sort ?? 'created_at';
        $direction = in_array(strtolower($request->direction ?? 'desc'), ['asc', 'desc']) 
            ? $request->direction 
            : 'desc';

        switch ($sort) {
            case 'name':
                $query->orderBy('last_name', $direction)
                    ->orderBy('first_name', $direction);
                break;
                
            case 'callsign':
                $query->orderBy('callsign', $direction);
                break;
                
            case 'expiry':
                $query->orderBy('license_expiration_date', $direction);
                break;
                
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    }

    /**
     * Format license validity with HTML styling
     */
    protected function formatLicenseValidity(?string $expiryDate): string
    {
        if (!$expiryDate) {
            return 'N/A';
        }

        $expiry = Carbon::parse($expiryDate);
        $now = now();
        
        if ($now->gt($expiry)) {
            return '<span class="text-red-600">Expired ' . $expiry->format('M d, Y') . '</span>';
        }
        
        return '<span class="text-green-600">Valid until ' . $expiry->format('M d, Y') . '</span>';
    }
}