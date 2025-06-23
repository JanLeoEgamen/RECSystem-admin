<?php

namespace App\Http\Controllers;

use App\Mail\PaymentRejectedMail;
use App\Models\Applicant;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\Middleware as RouteMiddleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class CashierApplicantController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new RouteMiddleware('permission:view applicants', only: ['index']),
            new RouteMiddleware('permission:verify applicants', only: ['verify']),
            new RouteMiddleware('permission:delete applicants', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = $request->user();

            $query = Applicant::where('payment_status', 'Pending')->orderBy('created_at', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('payment_proof_path', function ($row) {
                    return $row->payment_proof_path
                        ? '<img src="'.asset('images/payment_proofs/'.$row->payment_proof_path).'">'
                        : 'No receipt';
                })
                ->addColumn('action', function ($row) use ($request) {
                    $buttons = '';

                    if ($request->user()->can('verify applicants')) {
                        $buttons .= '<a href="' . route('cashier.assess', $row->id) . '" 
                            class="p-2 text-blue-600 hover:text-white hover:bg-blue-600 rounded-full transition-colors duration-200" title="Verify Payment">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>';
                    }

                    return '<div class="flex justify-center space-x-2">' . $buttons . '</div>';
                })
                ->editColumn('status', fn ($row) => ucfirst(str_replace('_', ' ', $row->status)))
                ->rawColumns(['payment_proof_path', 'action']) // allow image and buttons to render
                ->make(true);
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
        $applicant = Applicant::findOrFail($id);
        $applicant->payment_status = 'verified';
        $applicant->save();

        return response()->json(['success' => true, 'message' => 'Applicant payment has been verified.']);
    }

    public function reject(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);

        $reason = $request->input('reason');

        $applicant->payment_status = 'rejected';
        $applicant->save();

        // Send rejection email
        Mail::to($applicant->email_address)->send(new PaymentRejectedMail($applicant, $reason));

        return response()->json([
            'success' => true,
            'message' => 'Payment rejected and applicant notified via email.',
        ]);
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
        $applicant = Applicant::findOrFail($id);
        $applicant->payment_status = 'pending';
        $applicant->save();

        return response()->json([
            'success' => true,
            'message' => 'Applicant restored to pending payments.'
        ]);
    }
}
