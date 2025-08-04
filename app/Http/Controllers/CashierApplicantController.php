<?php

namespace App\Http\Controllers;

use App\Mail\PaymentRejectedMail;
use App\Models\Applicant;
use App\Models\MemberActivityLog;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\Middleware as RouteMiddleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class CashierApplicantController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new RouteMiddleware('permission:view payements', only: ['index']),
            new RouteMiddleware('permission:verify payments', only: ['verify']),
            new RouteMiddleware('permission:delete payments', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Applicant::where('payment_status', 'Pending');

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('email_address', 'like', "%$search%")
                    ->orWhere('reference_number', 'like', "%$search%");
                });
            }

            if ($request->has('sort') && $request->has('direction')) {
                $sort = $request->sort;
                $direction = $request->direction;
                
                switch ($sort) {
                    case 'name':
                        $query->orderBy('last_name', $direction)
                            ->orderBy('first_name', $direction);
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
            $applicants = $query->paginate($perPage);

            $transformedApplicants = $applicants->getCollection()->map(function ($applicant) {
                return [
                    'id' => $applicant->id,
                    'first_name' => $applicant->first_name,
                    'last_name' => $applicant->last_name,
                    'email_address' => $applicant->email_address,
                    'reference_number' => $applicant->reference_number,
                    'payment_proof_path' => $applicant->payment_proof_path,
                    'payment_status' => $applicant->payment_status,
                    'can_verify' => request()->user()->can('verify payments'),
                ];
            });

            return response()->json([
                'data' => $transformedApplicants,
                'current_page' => $applicants->currentPage(),
                'last_page' => $applicants->lastPage(),
                'from' => $applicants->firstItem(),
                'to' => $applicants->lastItem(),
                'total' => $applicants->total(),
            ]);
        }

        return view('cashier.list');
    }


    public function destroy($id)
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->delete();

        return response()->json(['message' => 'Applicant deleted successfully.']);
    }

    public function assess($id)
    {
        $applicant = Applicant::findOrFail($id);
        return view('cashier.assess', compact('applicant'));
    }

    public function verify($id) 
    {
        try {
            $applicant = Applicant::findOrFail($id);
            
            // Verify the payment
            $applicant->payment_status = 'verified';
            $applicant->verified_at = now();
            $applicant->save();

            // Log the verification
            $this->logPaymentActivity(
                $applicant,
                'verified',
                'Payment verified by cashier',
                [
                    'cashier_id' => auth()->id(),
                    'verified_at' => now()->toDateTimeString()
                ]
            );

            return response()->json([
                'success' => true, 
                'message' => 'Applicant payment has been verified.'
            ]);

        } catch (\Exception $e) {
            Log::error('Payment verification failed', [
                'error' => $e->getMessage(),
                'applicant_id' => $id,
                'cashier_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify payment'
            ], 500);
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        try {
            $applicant = Applicant::findOrFail($id);

            // Reject the payment
            $applicant->payment_status = 'rejected';
            $applicant->rejection_reason = $request->reason;
            $applicant->rejected_at = now();
            $applicant->save();

            // Log the rejection
            $this->logPaymentActivity(
                $applicant,
                'rejected',
                'Payment rejected by cashier',
                [
                    'cashier_id' => auth()->id(),
                    'rejection_reason' => $request->reason,
                    'rejected_at' => now()->toDateTimeString()
                ]
            );

            // Send rejection email
            Mail::to($applicant->email_address)
                ->send(new PaymentRejectedMail($applicant, $request->reason));

            return response()->json([
                'success' => true,
                'message' => 'Payment rejected and applicant notified via email.'
            ]);

        } catch (\Exception $e) {
            Log::error('Payment rejection failed', [
                'error' => $e->getMessage(),
                'applicant_id' => $id,
                'cashier_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject payment'
            ], 500);
        }
    }

    public function verified(Request $request)
    {
        if ($request->ajax()) {
            $data = Applicant::where('payment_status', 'verified')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('first_name', fn($row) => $row->first_name)
                ->addColumn('last_name', fn($row) => $row->last_name)
                ->addColumn('email_address', fn($row) => $row->email_address)
                ->addColumn('reference_number', fn($row) => $row->reference_number)
                ->addColumn('payment_proof_path', function ($row) {
                    return $row->payment_proof_path
                        ? '<img src="' . asset('images/payment_proofs/' . $row->payment_proof_path) . '" class="h-12 mx-auto">'
                        : 'No receipt';
                })
                ->addColumn('verified_at', function ($row) {
                    return \Carbon\Carbon::parse($row->updated_at)->format('M d, Y h:i A');
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('cashier.assess', ['id' => $row->id, 'from' => 'verified']) . '" 
                        class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600 transition"
                        title="View Payment Details">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        View
                    </a>';
                })
                ->rawColumns(['payment_proof_path', 'action'])
                ->make(true);
        }

        return view('cashier.verified');
    }

    public function rejected(Request $request)
    {
        if ($request->ajax()) {
            $data = Applicant::where('payment_status', 'rejected')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('first_name', fn($row) => $row->first_name)
                ->addColumn('last_name', fn($row) => $row->last_name)
                ->addColumn('email_address', fn($row) => $row->email_address)
                ->addColumn('reference_number', fn($row) => $row->reference_number)
                ->addColumn('payment_proof_path', function ($row) {
                    return $row->payment_proof_path
                        ? '<img src="' . asset('images/payment_proofs/' . $row->payment_proof_path) . '" class="h-12 mx-auto">'
                        : 'No receipt';
                })
                ->addColumn('rejected_at', function ($row) {
                    return \Carbon\Carbon::parse($row->updated_at)->format('M d, Y h:i A');
                })
                ->addColumn('action', function ($row) {
                    $viewBtn = '<a href="' . route('cashier.assess', ['id' => $row->id, 'from' => 'verified']) . '" 
                        class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600 transition"
                        title="View Payment Details">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        View
                    </a>';

                    $restoreBtn = '<button onclick="restoreApplicant(' . $row->id . ')" 
                        class="text-green-600 hover:text-white hover:bg-green-600 p-2 rounded-full transition" title="Restore">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M4 4v16h16V4H4zm2 2h12v12H6V6z"/>
                        </svg>
                    </button>';

                    return '<div class="flex justify-center space-x-2">' . $viewBtn . $restoreBtn . '</div>';
                })
                ->rawColumns(['payment_proof_path', 'action'])
                ->make(true);
        }

        return view('cashier.rejected');
    }

    public function restore($id)
    {
        try {
            $applicant = Applicant::findOrFail($id);
            
            // Restore to pending
            $applicant->payment_status = 'pending';
            $applicant->rejection_reason = null;
            $applicant->rejected_at = null;
            $applicant->save();

            // Log the restoration
            $this->logPaymentActivity(
                $applicant,
                'restored',
                'Payment restored to pending',
                [
                    'cashier_id' => auth()->id(),
                    'previous_status' => 'rejected',
                    'restored_at' => now()->toDateTimeString()
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Applicant restored to pending payments.'
            ]);

        } catch (\Exception $e) {
            Log::error('Payment restoration failed', [
                'error' => $e->getMessage(),
                'applicant_id' => $id,
                'cashier_id' => auth()->id()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore payment'
            ], 500);
        }
    }

    /**
     * Helper method to log payment activities
     */
    protected function logPaymentActivity($applicant, $action, $details, $meta = [])
    {
        MemberActivityLog::create([
            'member_id' => $applicant->id, // Assuming applicant can be treated as member
            'type' => 'payment',
            'action' => $action,
            'details' => $details,
            'meta' => $meta,
            'performed_by' => auth()->id(),
            'created_at' => now()
        ]);
    }
}
