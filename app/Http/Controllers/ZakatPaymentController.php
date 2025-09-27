<?php

namespace App\Http\Controllers;

use App\Models\ZakatPayment;
use App\Models\Muzakki;
use App\Models\ZakatType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class ZakatPaymentController extends Controller
{
    // Middleware is applied in routes

    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
        
        // Log the configuration for debugging
        Log::info('Midtrans Configuration:', [
            'serverKey' => Config::$serverKey,
            'isProduction' => Config::$isProduction,
            'isSanitized' => Config::$isSanitized,
            'is3ds' => Config::$is3ds
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ZakatPayment::with(['muzakki', 'zakatType', 'receivedBy']);

        // Filter by user role - muzakki can only see their own payments
        if (Auth::check() && Auth::user()->role === 'muzakki') {
            $muzakki = Auth::user()->muzakki;
            if (!$muzakki) {
                abort(404, 'Profil muzakki tidak ditemukan.');
            }
            $query->where('muzakki_id', $muzakki->id);
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('payment_code', 'like', "%{$search}%")
                    ->orWhere('receipt_number', 'like', "%{$search}%")
                    ->orWhereHas('muzakki', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by zakat type
        if ($request->has('zakat_type') && $request->zakat_type != '') {
            $query->where('zakat_type_id', $request->zakat_type);
        }

        // Filter by payment method
        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        $payments = $query->latest('payment_date')->paginate(15)->withQueryString();

        // Get filter options and stats based on user role
        $zakatTypes = ZakatType::active()->get();
        if (Auth::check() && Auth::user()->role === 'muzakki') {
            $muzakki = Auth::user()->muzakki;
            $stats = [
                'total_amount' => $muzakki->zakatPayments()->completed()->sum('paid_amount'),
                'total_count' => $muzakki->zakatPayments()->completed()->count(),
                'this_month' => $muzakki->zakatPayments()->completed()->whereMonth('payment_date', date('m'))->sum('paid_amount'),
                'pending' => $muzakki->zakatPayments()->where('status', 'pending')->count(),
            ];
        } else {
            $stats = [
                'total_amount' => ZakatPayment::completed()->sum('paid_amount'),
                'total_count' => ZakatPayment::completed()->count(),
                'this_month' => ZakatPayment::completed()->whereMonth('payment_date', date('m'))->sum('paid_amount'),
                'pending' => ZakatPayment::where('status', 'pending')->count(),
            ];
        }

        return view('payments.index', compact('payments', 'zakatTypes', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $zakatTypeId = $request->get('type') ?: $request->get('zakat_type_id');
        $selectedZakatType = $zakatTypeId ? ZakatType::findOrFail($zakatTypeId) : null;
        $zakatTypes = ZakatType::active()->get();
        
        if (Auth::check() && Auth::user()->role === 'muzakki') {
            // For muzakki users, automatically set their own muzakki profile
            $muzakki = Auth::user()->muzakki;
            if (!$muzakki) {
                abort(404, 'Profil muzakki tidak ditemukan.');
            }
            $allMuzakki = collect([$muzakki]); // Only show current user
        } else {
            // For admin/staff, allow selecting any muzakki
            $muzakkiId = $request->get('muzakki_id');
            $muzakki = $muzakkiId ? Muzakki::findOrFail($muzakkiId) : null;
            $allMuzakki = Muzakki::active()->orderBy('name')->get();
        }

        return view('payments.create', compact('muzakki', 'selectedZakatType', 'zakatTypes', 'allMuzakki'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'muzakki_id' => 'required|exists:muzakki,id',
            'zakat_type_id' => 'required|exists:zakat_types,id',
            'wealth_amount' => 'nullable|numeric|min:0',
            'zakat_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,check,online',
            'payment_reference' => 'nullable|string|max:255',
            'payment_date' => 'required|date',
            'hijri_year' => 'nullable|integer|min:1400|max:1500',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $paymentCode = ZakatPayment::generatePaymentCode();
            $receiptNumber = ZakatPayment::generateReceiptNumber();

            $payment = ZakatPayment::create([
                'payment_code' => $paymentCode,
                'muzakki_id' => $request->muzakki_id,
                'zakat_type_id' => $request->zakat_type_id,
                'wealth_amount' => $request->wealth_amount,
                'zakat_amount' => $request->zakat_amount,
                'paid_amount' => $request->paid_amount,
                'payment_method' => $request->payment_method,
                'payment_reference' => $request->payment_reference,
                'payment_date' => $request->payment_date,
                'hijri_year' => $request->hijri_year,
                'notes' => $request->notes,
                'status' => 'completed',
                'receipt_number' => $receiptNumber,
                'received_by' => Auth::check() ? Auth::id() : 1, // Default to admin user if not authenticated
            ]);

            DB::commit();

            $redirectRoute = Auth::check() && Auth::user()->role === 'muzakki' ? 'muzakki.dashboard' : 'payments.index';
            return redirect()->route($redirectRoute)->with('success', 'Pembayaran zakat berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Terjadi kesalahan dalam memproses pembayaran.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ZakatPayment $payment)
    {
        $payment->load(['muzakki', 'zakatType', 'receivedBy']);

        // Check permission for muzakki role
        if (Auth::check() && Auth::user()->role === 'muzakki') {
            if ($payment->muzakki->user_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses ke pembayaran ini.');
            }
        }

        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ZakatPayment $payment)
    {
        $zakatTypes = ZakatType::active()->get();
        $allMuzakki = Muzakki::active()->orderBy('name')->get();

        return view('payments.edit', compact('payment', 'zakatTypes', 'allMuzakki'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ZakatPayment $payment)
    {
        $request->validate([
            'muzakki_id' => 'required|exists:muzakki,id',
            'zakat_type_id' => 'required|exists:zakat_types,id',
            'wealth_amount' => 'nullable|numeric|min:0',
            'zakat_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,check,online',
            'payment_reference' => 'nullable|string|max:255',
            'payment_date' => 'required|date',
            'hijri_year' => 'nullable|integer|min:1400|max:1500',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $payment->update($request->all());

        return redirect()->route('payments.index')->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ZakatPayment $payment)
    {
        // Only allow deletion if payment is pending or cancelled
        if ($payment->status === 'completed') {
            return redirect()->route('payments.index')->with('error', 'Pembayaran yang sudah selesai tidak dapat dihapus.');
        }

        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Data pembayaran berhasil dihapus.');
    }

    /**
     * Generate receipt PDF
     */
    public function receipt(ZakatPayment $payment)
    {
        $payment->load(['muzakki', 'zakatType', 'receivedBy']);

        // Check permission for muzakki role
        if (Auth::check() && Auth::user()->role === 'muzakki') {
            if ($payment->muzakki->user_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki akses ke kwitansi ini.');
            }
        }

        return view('payments.receipt', compact('payment'));
    }

    /**
     * Test database connection and required data
     */
    public function testData()
    {
        try {
            $zakatTypes = ZakatType::count();
            $muzakkiCount = Muzakki::count();
            
            return response()->json([
                'database_connection' => 'ok',
                'zakat_types_count' => $zakatTypes,
                'muzakki_count' => $muzakkiCount,
                'message' => 'Database connection successful'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'database_connection' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test Midtrans configuration
     */
    public function testMidtrans()
    {
        return response()->json([
            'midtrans_configured' => !empty(config('midtrans.server_key')),
            'server_key' => config('midtrans.server_key') ? 'configured' : 'missing',
            'client_key' => config('midtrans.client_key') ? 'configured' : 'missing',
            'is_production' => config('midtrans.is_production', false),
            'is_sanitized' => config('midtrans.is_sanitized', true),
            'is_3ds' => config('midtrans.is_3ds', true),
        ]);
    }

    /**
     * Show guest payment form (no login required)
     */
    public function guestCreate(Request $request)
    {
        $zakatTypes = ZakatType::active()->get();
        $programCategory = $request->query('category', 'umum');
        return view('payments.guest-create', compact('zakatTypes', 'programCategory'));
    }

    public function guestStore(Request $request)
    {
        // VALIDASI YANG SUDAH DIPERBAIKI DAN DISESUAIKAN DENGAN FORM
        $validatedData = $request->validate([
            'program_category' => 'nullable|string|max:255',
            'paid_amount'      => 'required|numeric|min:1000',
            'payment_method'   => 'required|string', // Aturan ini sebelumnya hilang
            'donor_name'       => 'nullable|string|max:255',
            'donor_phone'      => 'nullable|string|max:20',
            'donor_email'      => 'nullable|email|max:255',
            'notes'            => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $donorName = $request->donor_name ?: 'Hamba Allah';
            $donorEmail = $request->donor_email ?: 'guest_' . time() . '@anonymous.com';

            $muzakki = Muzakki::firstOrCreate(
                ['email' => $donorEmail],
                [
                    'name'  => $donorName,
                    'phone' => $request->donor_phone,
                    'is_active' => true,
                ]
            );

            $payment = ZakatPayment::create([
                'payment_code'     => ZakatPayment::generatePaymentCode(), // Use the correct method name
                'muzakki_id'       => $muzakki->id,
                'zakat_amount'     => 0, // Provide default value for zakat_amount
                'paid_amount'      => $request->paid_amount,
                'payment_method'   => 'midtrans',
                'payment_date'     => now(),
                'status'           => 'pending',
                'program_category' => $request->program_category,
                'notes'            => $request->notes,
                'is_guest_payment' => true,
                'receipt_number'   => ZakatPayment::generateReceiptNumber(), // Use the existing method
            ]);

            DB::commit();

            return response()->json([
                'success'      => true,
                'redirect_url' => route('guest.payment.summary', $payment->payment_code)
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Guest Store Error: ' . $e->getMessage(), $e->getTrace());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan internal. Silakan coba lagi nanti.'
            ], 500);
        }
    }

    public function guestSummary($paymentCode)
    {
        $payment = ZakatPayment::where('payment_code', $paymentCode)
            ->where('status', 'pending')
            ->firstOrFail();
            
        return view('payments.guest-summary', compact('payment'));
    }

    /**
     * Get Snap Token for a specific payment via AJAX.
     */
    public function getSnapToken($paymentCode)
    {
        $payment = ZakatPayment::with('muzakki')->where('payment_code', $paymentCode)->firstOrFail();

        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $midtransParams = [
            'transaction_details' => [
                'order_id' => $payment->payment_code,
                'gross_amount' => (int) $payment->paid_amount,
            ],
            'customer_details' => [
                'first_name' => $payment->muzakki->name,
                'email' => $payment->muzakki->email,
                'phone' => $payment->muzakki->phone,
            ],
            'item_details' => [[
                'id' => 'DONATION-' . $payment->id,
                'price' => (int) $payment->paid_amount,
                'quantity' => 1,
                'name' => 'Donasi Program ' . ucfirst($payment->program_category ?? 'Umum'),
            ]],
            'callbacks' => [
                'finish' => route('guest.payment.success', $payment->payment_code)
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($midtransParams);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal memproses pembayaran.'], 500);
        }
    }
    

    /**
     * Show guest payment success page
     */
    public function guestSuccess($paymentCode)
    {
        $payment = ZakatPayment::where('payment_code', $paymentCode)
                              ->where('is_guest_payment', true)
                              ->with(['muzakki', 'zakatType'])
                              ->firstOrFail();
        
        return view('payments.guest-success', compact('payment'));
    }

    /**
     * Generate guest receipt (no login required)
     */
    public function guestReceipt(ZakatPayment $payment)
    {
        // Only allow access to guest payments
        if (!$payment->is_guest_payment) {
            abort(404);
        }

        $payment->load(['muzakki', 'zakatType']);
        return view('payments.guest-receipt', compact('payment'));
    }

    /**
     * Handle Midtrans notification callback
     */
    public function midtransCallback(Request $request)
    {
        try {
            $notification = new Notification();
            
            $transactionStatus = $notification->transaction_status;
            $paymentType = $notification->payment_type;
            $orderId = $notification->order_id;
            $fraudStatus = $notification->fraud_status;

            // Find the payment by order_id (payment_code)
            $payment = ZakatPayment::where('payment_code', $orderId)->first();
            
            if (!$payment) {
                return response()->json(['status' => 'error', 'message' => 'Payment not found'], 404);
            }

            // Handle transaction status
            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $payment->update([
                            'status' => 'pending',
                            'payment_reference' => $notification->transaction_id
                        ]);
                    } else {
                        $payment->update([
                            'status' => 'completed',
                            'payment_reference' => $notification->transaction_id
                        ]);
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                $payment->update([
                    'status' => 'completed',
                    'payment_reference' => $notification->transaction_id
                ]);
            } elseif ($transactionStatus == 'pending') {
                $payment->update([
                    'status' => 'pending',
                    'payment_reference' => $notification->transaction_id
                ]);
            } elseif ($transactionStatus == 'deny') {
                $payment->update([
                    'status' => 'cancelled',
                    'payment_reference' => $notification->transaction_id
                ]);
            } elseif ($transactionStatus == 'expire') {
                $payment->update([
                    'status' => 'cancelled',
                    'payment_reference' => $notification->transaction_id
                ]);
            } elseif ($transactionStatus == 'cancel') {
                $payment->update([
                    'status' => 'cancelled',
                    'payment_reference' => $notification->transaction_id
                ]);
            }

            return response()->json(['status' => 'success']);
            
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * AJAX search endpoint for real-time search
     */
    public function search(Request $request)
    {
        $query = ZakatPayment::with(['muzakki', 'zakatType', 'receivedBy']);

        // Filter by user role - muzakki can only see their own payments
        if (Auth::check() && Auth::user()->role === 'muzakki') {
            $muzakki = Auth::user()->muzakki;
            if (!$muzakki) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil muzakki tidak ditemukan.'
                ], 404);
            }
            $query->where('muzakki_id', $muzakki->id);
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('payment_code', 'like', "%{$search}%")
                    ->orWhere('receipt_number', 'like', "%{$search}%")
                    ->orWhereHas('muzakki', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by zakat type
        if ($request->has('zakat_type') && $request->zakat_type != '') {
            $query->where('zakat_type_id', $request->zakat_type);
        }

        // Filter by payment method
        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        $payments = $query->latest('payment_date')->paginate(15);

        // Calculate statistics based on current user role
        if (Auth::check() && Auth::user()->role === 'muzakki') {
            $muzakki = Auth::user()->muzakki;
            $totalQuery = $muzakki->zakatPayments();
            $completedQuery = $muzakki->zakatPayments()->completed();
            $thisMonthQuery = $muzakki->zakatPayments()->completed()->whereMonth('payment_date', date('m'));
            $pendingQuery = $muzakki->zakatPayments()->where('status', 'pending');
        } else {
            $totalQuery = ZakatPayment::query();
            $completedQuery = ZakatPayment::completed();
            $thisMonthQuery = ZakatPayment::completed()->whereMonth('payment_date', date('m'));
            $pendingQuery = ZakatPayment::where('status', 'pending');
        }

        // Apply same filters to statistics calculations
        if ($request->has('search') && $request->search != '') {
            $search = $request->get('search');
            foreach ([$totalQuery, $completedQuery, $thisMonthQuery, $pendingQuery] as $statQuery) {
                $statQuery->where(function ($q) use ($search) {
                    $q->where('payment_code', 'like', "%{$search}%")
                        ->orWhere('receipt_number', 'like', "%{$search}%")
                        ->orWhereHas('muzakki', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            }
        }

        if ($request->has('zakat_type') && $request->zakat_type != '') {
            foreach ([$totalQuery, $completedQuery, $thisMonthQuery, $pendingQuery] as $statQuery) {
                $statQuery->where('zakat_type_id', $request->zakat_type);
            }
        }

        if ($request->has('payment_method') && $request->payment_method != '') {
            foreach ([$totalQuery, $completedQuery, $thisMonthQuery, $pendingQuery] as $statQuery) {
                $statQuery->where('payment_method', $request->payment_method);
            }
        }

        if ($request->has('date_from') && $request->date_from != '') {
            foreach ([$totalQuery, $completedQuery, $thisMonthQuery, $pendingQuery] as $statQuery) {
                $statQuery->whereDate('payment_date', '>=', $request->date_from);
            }
        }

        if ($request->has('date_to') && $request->date_to != '') {
            foreach ([$totalQuery, $completedQuery, $thisMonthQuery, $pendingQuery] as $statQuery) {
                $statQuery->whereDate('payment_date', '<=', $request->date_to);
            }
        }

        $statistics = [
            'total_amount' => $completedQuery->sum('paid_amount'),
            'total_count' => $totalQuery->count(),
            'this_month' => $thisMonthQuery->sum('paid_amount'),
            'pending' => $pendingQuery->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'payments' => $payments->items(),
                'statistics' => $statistics,
                'pagination' => [
                    'current_page' => $payments->currentPage(),
                    'last_page' => $payments->lastPage(),
                    'per_page' => $payments->perPage(),
                    'total' => $payments->total(),
                    'from' => $payments->firstItem(),
                    'to' => $payments->lastItem(),
                ],
            ]
        ]);
    }
}