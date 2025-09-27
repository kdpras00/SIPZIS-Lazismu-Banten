<?php

namespace App\Http\Controllers;

use App\Models\Mustahik;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MustahikController extends Controller
{
    // Middleware is applied in routes

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Mustahik::with(['verifiedBy', 'zakatDistributions']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by category (asnaf)
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by verification status
        if ($request->has('status') && $request->status != '') {
            $query->where('verification_status', $request->status);
        }

        // Filter by city
        if ($request->has('city') && $request->city != '') {
            $query->where('city', 'like', "%{$request->city}%");
        }

        $mustahik = $query->latest()->paginate(15)->withQueryString();

        // Get filter options
        $categories = array_keys(Mustahik::CATEGORIES);
        $cities = Mustahik::select('city')->distinct()->whereNotNull('city')->pluck('city');
        $stats = [
            'total' => Mustahik::count(),
            'verified' => Mustahik::verified()->count(),
            'pending' => Mustahik::pending()->count(),
            'rejected' => Mustahik::where('verification_status', 'rejected')->count(),
        ];

        return view('mustahik.index', compact('mustahik', 'categories', 'cities', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Mustahik::CATEGORIES;
        return view('mustahik.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20|unique:mustahik,nik',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'category' => 'required|in:fakir,miskin,amil,muallaf,riqab,gharim,fisabilillah,ibnu_sabil',
            'category_description' => 'nullable|string',
            'family_status' => 'nullable|in:single,married,divorced,widow/widower',
            'family_members' => 'required|integer|min:1',
            'monthly_income' => 'nullable|numeric|min:0',
            'income_source' => 'nullable|string',
            'verification_status' => 'required|in:pending,verified,rejected',
            'verification_notes' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->verification_status === 'verified') {
            $data['verified_at'] = now();
            $data['verified_by'] = auth()->id();
        }

        Mustahik::create($data);

        return redirect()->route('mustahik.index')->with('success', 'Data mustahik berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mustahik $mustahik)
    {
        $mustahik->load(['verifiedBy', 'zakatDistributions.distributedBy']);

        $stats = [
            'total_received' => $mustahik->zakatDistributions()->sum('amount'),
            'distribution_count' => $mustahik->zakatDistributions()->count(),
            'last_distribution' => $mustahik->zakatDistributions()->latest('distribution_date')->first(),
        ];

        $recentDistributions = $mustahik->zakatDistributions()
            ->with('distributedBy')
            ->latest('distribution_date')
            ->take(10)
            ->get();

        return view('mustahik.show', compact('mustahik', 'stats', 'recentDistributions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mustahik $mustahik)
    {
        $categories = Mustahik::CATEGORIES;
        return view('mustahik.edit', compact('mustahik', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mustahik $mustahik)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => ['nullable', 'string', 'max:20', Rule::unique('mustahik', 'nik')->ignore($mustahik->id)],
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'category' => 'required|in:fakir,miskin,amil,muallaf,riqab,gharim,fisabilillah,ibnu_sabil',
            'category_description' => 'nullable|string',
            'family_status' => 'nullable|in:single,married,divorced,widow/widower',
            'family_members' => 'required|integer|min:1',
            'monthly_income' => 'nullable|numeric|min:0',
            'income_source' => 'nullable|string',
            'verification_status' => 'required|in:pending,verified,rejected',
            'verification_notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        // Handle verification status changes
        if ($request->verification_status === 'verified' && $mustahik->verification_status !== 'verified') {
            $data['verified_at'] = now();
            $data['verified_by'] = auth()->id();
        } elseif ($request->verification_status !== 'verified') {
            $data['verified_at'] = null;
            $data['verified_by'] = null;
        }

        $mustahik->update($data);

        return redirect()->route('mustahik.index')->with('success', 'Data mustahik berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mustahik $mustahik)
    {
        // Check if mustahik has received distributions
        if ($mustahik->zakatDistributions()->count() > 0) {
            return redirect()->route('mustahik.index')->with('error', 'Mustahik tidak dapat dihapus karena sudah memiliki riwayat penerimaan zakat.');
        }

        $mustahik->delete();

        return redirect()->route('mustahik.index')->with('success', 'Data mustahik berhasil dihapus.');
    }

    /**
     * Verify mustahik
     */
    public function verify(Request $request, Mustahik $mustahik)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'notes' => 'nullable|string',
        ]);

        $data = [
            'verification_status' => $request->status,
            'verification_notes' => $request->notes,
        ];

        if ($request->status === 'verified') {
            $data['verified_at'] = now();
            $data['verified_by'] = auth()->id();
        } else {
            $data['verified_at'] = null;
            $data['verified_by'] = null;
        }

        $mustahik->update($data);

        $statusText = $request->status === 'verified' ? 'diverifikasi' : 'ditolak';
        return redirect()->route('mustahik.show', $mustahik)->with('success', "Mustahik berhasil {$statusText}.");
    }

    /**
     * Toggle mustahik status
     */
    public function toggleStatus(Mustahik $mustahik)
    {
        $mustahik->update(['is_active' => !$mustahik->is_active]);

        $status = $mustahik->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('mustahik.index')->with('success', "Mustahik berhasil {$status}.");
    }

    /**
     * Get mustahik by category for AJAX
     */
    public function getByCategory(Request $request)
    {
        $category = $request->get('category');
        $mustahik = Mustahik::verified()
            ->active()
            ->where('category', $category)
            ->select('id', 'name', 'category', 'address')
            ->get();

        return response()->json($mustahik);
    }

    /**
     * AJAX search endpoint for real-time search
     */
    public function search(Request $request)
    {
        $query = Mustahik::with(['verifiedBy', 'zakatDistributions']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by category (asnaf)
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by verification status
        if ($request->has('status') && $request->status != '') {
            $query->where('verification_status', $request->status);
        }

        // Filter by city
        if ($request->has('city') && $request->city != '') {
            $query->where('city', 'like', "%{$request->city}%");
        }

        $mustahik = $query->latest()->paginate(15);

        // Calculate statistics
        $totalCount = Mustahik::count();
        $verifiedCount = Mustahik::verified()->count();
        $pendingCount = Mustahik::pending()->count();
        $thisMonthCount = Mustahik::where('created_at', '>=', now()->startOfMonth())->count();

        return response()->json([
            'success' => true,
            'data' => [
                'mustahik' => $mustahik->items(),
                'pagination' => [
                    'current_page' => $mustahik->currentPage(),
                    'last_page' => $mustahik->lastPage(),
                    'per_page' => $mustahik->perPage(),
                    'total' => $mustahik->total(),
                    'from' => $mustahik->firstItem(),
                    'to' => $mustahik->lastItem(),
                ],
                'statistics' => [
                    'total' => $totalCount,
                    'verified' => $verifiedCount,
                    'pending' => $pendingCount,
                    'this_month' => $thisMonthCount,
                ],
            ]
        ]);
    }
}
