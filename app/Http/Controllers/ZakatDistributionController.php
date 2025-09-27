<?php

namespace App\Http\Controllers;

use App\Models\ZakatDistribution;
use App\Models\Mustahik;
use App\Models\ZakatPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ZakatDistributionController extends Controller
{
    // Middleware is applied in routes

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ZakatDistribution::with(['mustahik', 'distributedBy']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('distribution_code', 'like', "%{$search}%")
                    ->orWhere('program_name', 'like', "%{$search}%")
                    ->orWhereHas('mustahik', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by mustahik category
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('mustahik', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        // Filter by distribution type
        if ($request->has('distribution_type') && $request->distribution_type != '') {
            $query->where('distribution_type', $request->distribution_type);
        }

        // Filter by program
        if ($request->has('program') && $request->program != '') {
            $query->where('program_name', 'like', "%{$request->program}%");
        }

        // Filter by received status
        if ($request->has('received_status')) {
            $query->where('is_received', $request->received_status == 'received');
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('distribution_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('distribution_date', '<=', $request->date_to);
        }

        $distributions = $query->latest('distribution_date')->paginate(15)->withQueryString();

        // Get filter options and statistics
        $categories = array_keys(Mustahik::CATEGORIES);
        $programs = ZakatDistribution::select('program_name')->distinct()->whereNotNull('program_name')->pluck('program_name');

        $stats = [
            'total_amount' => ZakatDistribution::sum('amount'),
            'total_count' => ZakatDistribution::count(),
            'this_month' => ZakatDistribution::whereMonth('distribution_date', date('m'))->sum('amount'),
            'pending_receipt' => ZakatDistribution::where('is_received', false)->count(),
            'available_balance' => ZakatPayment::completed()->sum('paid_amount') - ZakatDistribution::sum('amount'),
        ];

        return view('distributions.index', compact('distributions', 'categories', 'programs', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $mustahikId = $request->get('mustahik_id');
        $mustahik = $mustahikId ? Mustahik::verified()->findOrFail($mustahikId) : null;

        $allMustahik = Mustahik::verified()->active()->orderBy('name')->get();
        $categories = array_keys(Mustahik::CATEGORIES);

        // Calculate available balance
        $availableBalance = ZakatPayment::completed()->sum('paid_amount') - ZakatDistribution::sum('amount');

        return view('distributions.create', compact('mustahik', 'allMustahik', 'categories', 'availableBalance'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mustahik_id' => 'required|exists:mustahik,id',
            'amount' => 'required|numeric|min:0',
            'distribution_type' => 'required|in:cash,goods,voucher,service',
            'goods_description' => 'required_if:distribution_type,goods,service|nullable|string',
            'distribution_date' => 'required|date',
            'notes' => 'nullable|string',
            'program_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        // Check available balance
        $availableBalance = ZakatPayment::completed()->sum('paid_amount') - ZakatDistribution::sum('amount');

        if ($request->distribution_type === 'cash' && $request->amount > $availableBalance) {
            return back()->withInput()->with('error', 'Saldo zakat tidak mencukupi. Saldo tersedia: Rp ' . number_format($availableBalance, 0, ',', '.'));
        }

        // Verify mustahik is verified and active
        $mustahik = Mustahik::verified()->active()->findOrFail($request->mustahik_id);

        DB::beginTransaction();
        try {
            $distributionCode = ZakatDistribution::generateDistributionCode();

            ZakatDistribution::create([
                'distribution_code' => $distributionCode,
                'mustahik_id' => $request->mustahik_id,
                'amount' => $request->amount,
                'distribution_type' => $request->distribution_type,
                'goods_description' => $request->goods_description,
                'distribution_date' => $request->distribution_date,
                'notes' => $request->notes,
                'program_name' => $request->program_name,
                'distributed_by' => auth()->user()->id,
                'location' => $request->location,
                'is_received' => false,
            ]);

            DB::commit();
            return redirect()->route('distributions.index')->with('success', 'Distribusi zakat berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Terjadi kesalahan dalam mencatat distribusi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ZakatDistribution $distribution)
    {
        $distribution->load(['mustahik', 'distributedBy']);
        return view('distributions.show', compact('distribution'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ZakatDistribution $distribution)
    {
        $allMustahik = Mustahik::verified()->active()->orderBy('name')->get();
        $categories = array_keys(Mustahik::CATEGORIES);

        // Calculate available balance (excluding current distribution amount)
        $availableBalance = ZakatPayment::completed()->sum('paid_amount') - ZakatDistribution::where('id', '!=', $distribution->id)->sum('amount');

        return view('distributions.edit', compact('distribution', 'allMustahik', 'categories', 'availableBalance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ZakatDistribution $distribution)
    {
        $request->validate([
            'mustahik_id' => 'required|exists:mustahik,id',
            'amount' => 'required|numeric|min:0',
            'distribution_type' => 'required|in:cash,goods,voucher,service',
            'goods_description' => 'required_if:distribution_type,goods,service|nullable|string',
            'distribution_date' => 'required|date',
            'notes' => 'nullable|string',
            'program_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        // Check available balance if amount changed and distribution type is cash
        if ($request->distribution_type === 'cash' && $request->amount != $distribution->amount) {
            $availableBalance = ZakatPayment::completed()->sum('paid_amount') - ZakatDistribution::where('id', '!=', $distribution->id)->sum('amount');

            if ($request->amount > $availableBalance) {
                return back()->withInput()->with('error', 'Saldo zakat tidak mencukupi. Saldo tersedia: Rp ' . number_format($availableBalance, 0, ',', '.'));
            }
        }

        $distribution->update($request->all());

        return redirect()->route('distributions.index')->with('success', 'Data distribusi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ZakatDistribution $distribution)
    {
        // Only allow deletion if not yet received
        if ($distribution->is_received) {
            return redirect()->route('distributions.index')->with('error', 'Distribusi yang sudah diterima tidak dapat dihapus.');
        }

        $distribution->delete();

        return redirect()->route('distributions.index')->with('success', 'Data distribusi berhasil dihapus.');
    }

    /**
     * Mark distribution as received
     */
    public function markAsReceived(Request $request, ZakatDistribution $distribution)
    {
        $request->validate([
            'received_by_name' => 'nullable|string|max:255',
            'received_notes' => 'nullable|string',
        ]);

        $distribution->update([
            'is_received' => true,
            'received_date' => now(),
            'received_by_name' => $request->received_by_name ?: $distribution->mustahik->name,
            'received_notes' => $request->received_notes,
        ]);

        return redirect()->route('distributions.show', $distribution)->with('success', 'Distribusi berhasil ditandai sebagai diterima.');
    }

    /**
     * Generate distribution report by category
     */
    public function reportByCategory(Request $request)
    {
        $year = $request->get('year', date('Y'));

        $distributions = ZakatDistribution::whereYear('distribution_date', $year)
            ->with('mustahik')
            ->get()
            ->groupBy('mustahik.category')
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'total_amount' => $group->sum('amount'),
                    'mustahik' => $group->pluck('mustahik')->unique('id'),
                ];
            });

        $categories = Mustahik::CATEGORIES;

        return view('distributions.report-category', compact('distributions', 'categories', 'year'));
    }

    /**
     * Get mustahik by category for AJAX
     */
    public function getMustahikByCategory(Request $request)
    {
        $category = $request->get('category');
        $mustahik = Mustahik::verified()
            ->active()
            ->where('category', $category)
            ->select('id', 'name', 'category', 'address', 'phone')
            ->get();

        return response()->json($mustahik);
    }

    /**
     * Generate distribution receipt
     */
    public function receipt(ZakatDistribution $distribution)
    {
        $distribution->load(['mustahik', 'distributedBy']);
        return view('distributions.receipt', compact('distribution'));
    }

    /**
     * AJAX search endpoint for real-time search
     */
    public function search(Request $request)
    {
        $query = ZakatDistribution::with(['mustahik', 'distributedBy']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('distribution_code', 'like', "%{$search}%")
                    ->orWhere('program_name', 'like', "%{$search}%")
                    ->orWhereHas('mustahik', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by mustahik category
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('mustahik', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        // Filter by distribution type
        if ($request->has('distribution_type') && $request->distribution_type != '') {
            $query->where('distribution_type', $request->distribution_type);
        }

        // Filter by program
        if ($request->has('program') && $request->program != '') {
            $query->where('program_name', 'like', "%{$request->program}%");
        }

        // Filter by received status
        if ($request->has('received_status') && $request->received_status != '') {
            $query->where('is_received', $request->received_status === 'received');
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('distribution_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('distribution_date', '<=', $request->date_to);
        }

        $distributions = $query->latest('distribution_date')->paginate(15);

        // Calculate statistics with current filters
        $statsQuery = ZakatDistribution::query();
        
        // Apply same filters to statistics
        if ($request->has('search') && $request->search != '') {
            $search = $request->get('search');
            $statsQuery->where(function ($q) use ($search) {
                $q->where('distribution_code', 'like', "%{$search}%")
                    ->orWhere('program_name', 'like', "%{$search}%")
                    ->orWhereHas('mustahik', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->has('category') && $request->category != '') {
            $statsQuery->whereHas('mustahik', function ($q) use ($request) {
                $q->where('category', $request->category);
            });
        }

        if ($request->has('distribution_type') && $request->distribution_type != '') {
            $statsQuery->where('distribution_type', $request->distribution_type);
        }

        if ($request->has('program') && $request->program != '') {
            $statsQuery->where('program_name', 'like', "%{$request->program}%");
        }

        if ($request->has('received_status') && $request->received_status != '') {
            $statsQuery->where('is_received', $request->received_status === 'received');
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $statsQuery->whereDate('distribution_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $statsQuery->whereDate('distribution_date', '<=', $request->date_to);
        }

        $thisMonthQuery = clone $statsQuery;
        $thisMonthQuery->whereMonth('distribution_date', date('m'));

        $pendingQuery = clone $statsQuery;
        $pendingQuery->where('is_received', false);

        $statistics = [
            'total_amount' => $statsQuery->sum('amount'),
            'total_count' => $statsQuery->count(),
            'this_month' => $thisMonthQuery->sum('amount'),
            'pending_receipt' => $pendingQuery->count(),
            'available_balance' => ZakatPayment::completed()->sum('paid_amount') - ZakatDistribution::sum('amount'),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'distributions' => $distributions->items(),
                'statistics' => $statistics,
                'pagination' => [
                    'current_page' => $distributions->currentPage(),
                    'last_page' => $distributions->lastPage(),
                    'per_page' => $distributions->perPage(),
                    'total' => $distributions->total(),
                    'from' => $distributions->firstItem(),
                    'to' => $distributions->lastItem(),
                ],
            ]
        ]);
    }
}
