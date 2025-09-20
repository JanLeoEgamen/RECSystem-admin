<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class PaymentMethodController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view payment methods', only: ['index', 'view']),
            new Middleware('permission:edit payment methods', only: ['edit', 'update']),
            new Middleware('permission:create payment methods', only: ['create', 'store']),
            new Middleware('permission:delete payment methods', only: ['destroy']),
        ];
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = PaymentMethod::query();

                // Search functionality
                if ($request->has('search') && !empty($request->search)) {
                    $query->where(function ($q) use ($request) {
                        $q->where('mode_of_payment_name', 'like', '%' . $request->search . '%')
                          ->orWhere('account_name', 'like', '%' . $request->search . '%')
                          ->orWhere('account_number', 'like', '%' . $request->search . '%');
                    });
                }

                // Apply sorting
                $this->applySorting($query, $request);

                // Pagination
                $perPage = $request->input('perPage', 10);
                $paymentMethods = $query->paginate($perPage);

                $transformedPaymentMethods = $paymentMethods->getCollection()->map(function ($paymentMethod) {
                    return [
                        'id' => $paymentMethod->id,
                        'mode_of_payment_name' => $paymentMethod->mode_of_payment_name,
                        'account_name' => $paymentMethod->account_name,
                        'account_number' => $paymentMethod->account_number,
                        'is_published' => $paymentMethod->is_published,
                        'mode_of_payment_qr_image' => $paymentMethod->mode_of_payment_qr_image 
                            ? Storage::disk('public')->url($paymentMethod->mode_of_payment_qr_image) 
                            : null,
                        'created_at' => $paymentMethod->created_at->format('d M, Y'),
                    ];
                });

                return response()->json([
                    'data' => $transformedPaymentMethods,
                    'current_page' => $paymentMethods->currentPage(),
                    'last_page' => $paymentMethods->lastPage(),
                    'from' => $paymentMethods->firstItem(),
                    'to' => $paymentMethods->lastItem(),
                    'total' => $paymentMethods->total(),
                ]);
            }
            
            return view('payment-methods.list');

        } catch (\Exception $e) {
            Log::error('Payment method index error: ' . $e->getMessage());
            
            return $request->ajax()
                ? response()->json(['error' => 'Failed to load payment methods'], Response::HTTP_INTERNAL_SERVER_ERROR)
                : redirect()->back()->with('error', 'Failed to load payment methods. Please try again.');
        }
    }

    public function create()
    {
        try {
            return view('payment-methods.create');
        } catch (\Exception $e) {
            Log::error('Payment method create form error: ' . $e->getMessage());
            return redirect()->route('payment-methods.index')
                ->with('error', 'Failed to load payment method creation form. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validatePaymentMethodRequest($request);

            $paymentMethod = new PaymentMethod();
            $paymentMethod->mode_of_payment_name = $validated['mode_of_payment_name'];
            $paymentMethod->account_name = $validated['account_name'];
            $paymentMethod->account_number = $validated['account_number'];
            $paymentMethod->is_published = $validated['is_published'] ?? true;


            if ($request->hasFile('mode_of_payment_qr_image')) {
                $this->storeQRImage($paymentMethod, $request->file('mode_of_payment_qr_image'));
            }

            $paymentMethod->save();

            return redirect()->route('payment-methods.index')
                ->with('success', 'Payment method created successfully');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error('Payment method store error: ' . $e->getMessage());
            return redirect()->route('payment-methods.create')
                ->withInput()
                ->with('error', 'Failed to create payment method. Please try again.');
        }
    }

    public function edit($id)
    {
        try {
            $paymentMethod = PaymentMethod::findOrFail($id);
            
            return view('payment-methods.edit', compact('paymentMethod'));

        } catch (ModelNotFoundException $e) {
            Log::warning("Payment method not found for editing: {$id}");
            return redirect()->route('payment-methods.index')
                ->with('error', 'Payment method not found.');

        } catch (\Exception $e) {
            Log::error("Payment method edit form error for ID {$id}: " . $e->getMessage());
            return redirect()->route('payment-methods.index')
                ->with('error', 'Failed to load payment method edit form. Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $paymentMethod = PaymentMethod::findOrFail($id);
            $validated = $this->validatePaymentMethodRequest($request);

            $paymentMethod->mode_of_payment_name = $validated['mode_of_payment_name'];
            $paymentMethod->account_name = $validated['account_name'];
            $paymentMethod->account_number = $validated['account_number'];
            $paymentMethod->is_published = $validated['is_published'] ?? $paymentMethod->is_published;


            if ($request->hasFile('mode_of_payment_qr_image')) {
                $this->deleteQRImage($paymentMethod);
                $this->storeQRImage($paymentMethod, $request->file('mode_of_payment_qr_image'));
            }

            $paymentMethod->save();

            return redirect()->route('payment-methods.index')
                ->with('success', 'Payment method updated successfully');

        } catch (ModelNotFoundException $e) {
            Log::warning("Payment method not found for update: {$id}");
            return redirect()->route('payment-methods.index')
                ->with('error', 'Payment method not found.');

        } catch (ValidationException $e) {
            throw $e;

        } catch (\Exception $e) {
            Log::error("Payment method update error for ID {$id}: " . $e->getMessage());
            return redirect()->route('payment-methods.edit', $id)
                ->withInput()
                ->with('error', 'Failed to update payment method. Please try again.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $paymentMethod = PaymentMethod::findOrFail($request->id);
            $this->deleteQRImage($paymentMethod);
            $paymentMethod->delete();

            return response()->json([
                'status' => true,
                'message' => 'Payment method deleted successfully.'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::warning("Payment method not found for deletion: {$request->id}");
            return response()->json([
                'status' => false,
                'message' => 'Payment method not found.'
            ], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {
            Log::error("Payment method deletion error for ID {$request->id}: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete payment method. Please try again.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

public function view($id)
{
    try {
        $paymentMethod = PaymentMethod::findOrFail($id);
        
        return view('payment-methods.view', compact('paymentMethod'));

    } catch (ModelNotFoundException $e) {
        Log::warning("Payment method not found for viewing: {$id}");
        return redirect()->route('payment-methods.index')
            ->with('error', 'Payment method not found.');

    } catch (\Exception $e) {
        Log::error("Payment method view error for ID {$id}: " . $e->getMessage());
        return redirect()->route('payment-methods.index')
            ->with('error', 'Failed to load payment method. Please try again.');
    }
}

    /**
     * Validate payment method request data
     */
    protected function validatePaymentMethodRequest(Request $request): array
    {
        $rules = [
            'mode_of_payment_name' => 'required|string|min:2|max:255',
            'account_name' => 'required|string|min:2|max:100',
            'account_number' => 'required|string|min:2|max:100',
            'is_published' => 'sometimes|boolean',
            'mode_of_payment_qr_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        return $request->validate($rules);
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
            case 'mode_of_payment_name':
                $query->orderBy('mode_of_payment_name', $direction);
                break;
                
            case 'account_name':
                $query->orderBy('account_name', $direction);
                break;
                
            case 'account_number':
                $query->orderBy('account_number', $direction);
                break;
                
            case 'created':
            case 'created_at':
                $query->orderBy('created_at', $direction);
                break;
                
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
    }

    /**
     * Store QR image and update payment method attributes
     */
    protected function storeQRImage(PaymentMethod $paymentMethod, $file): void
    {
        $path = $file->store('payment-methods', 'public');
        $paymentMethod->mode_of_payment_qr_image = $path;
    }

    /**
     * Delete QR image if exists
     */
    protected function deleteQRImage(PaymentMethod $paymentMethod): void
    {
        if ($paymentMethod->mode_of_payment_qr_image && Storage::disk('public')->exists($paymentMethod->mode_of_payment_qr_image)) {
            Storage::disk('public')->delete($paymentMethod->mode_of_payment_qr_image);
        }
    }
}