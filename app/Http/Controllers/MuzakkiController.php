<?php

namespace App\Http\Controllers;

use App\Models\Muzakki;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MuzakkiController extends Controller
{
    // Middleware is applied in routes

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Muzakki::with('user');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by occupation
        if ($request->has('occupation') && $request->occupation != '') {
            $query->where('occupation', $request->occupation);
        }

        // Filter by city
        if ($request->has('city') && $request->city != '') {
            $query->where('city', 'like', "%{$request->city}%");
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('is_active', $request->status == 'active');
        }

        $muzakki = $query->latest()->paginate(15)->withQueryString();

        // Get filter options
        $occupations = Muzakki::select('occupation')->distinct()->whereNotNull('occupation')->pluck('occupation');
        $cities = Muzakki::select('city')->distinct()->whereNotNull('city')->pluck('city');

        return view('muzakki.index', compact('muzakki', 'occupations', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('muzakki.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:muzakki,email',
            'phone' => 'nullable|string|max:20',
            'nik' => 'nullable|string|max:20|unique:muzakki,nik',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'occupation' => 'nullable|in:employee,entrepreneur,civil_servant,teacher,doctor,farmer,trader,other',
            'monthly_income' => 'nullable|numeric|min:0',
            'date_of_birth' => 'nullable|date',
            'create_user_account' => 'boolean',
            'password' => 'required_if:create_user_account,1|nullable|string|min:8',
        ]);

        $user = null;

        // Create user account if requested
        if ($request->create_user_account && $request->email) {
            $request->validate([
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'muzakki',
                'is_active' => true,
                'phone' => $request->phone,
            ]);
        }

        $muzakki = Muzakki::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'nik' => $request->nik,
            'gender' => $request->gender,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'occupation' => $request->occupation,
            'monthly_income' => $request->monthly_income,
            'date_of_birth' => $request->date_of_birth,
            'user_id' => $user?->id,
            'is_active' => true,
        ]);

        return redirect()->route('muzakki.index')->with('success', 'Data muzakki berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Muzakki $muzakki)
    {
        $muzakki->load(['user', 'zakatPayments.zakatType']);

        $stats = [
            'total_zakat' => $muzakki->zakatPayments()->completed()->sum('paid_amount'),
            'payment_count' => $muzakki->zakatPayments()->completed()->count(),
            'last_payment' => $muzakki->zakatPayments()->completed()->latest('payment_date')->first(),
        ];

        $recentPayments = $muzakki->zakatPayments()
            ->with('zakatType')
            ->completed()
            ->latest('payment_date')
            ->take(10)
            ->get();

        return view('muzakki.show', compact('muzakki', 'stats', 'recentPayments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Muzakki $muzakki = null)
    {
        // If no muzakki is provided, get current user's muzakki profile (for profile editing)
        if (!$muzakki) {
            $muzakki = auth()->user()->muzakki;
            if (!$muzakki) {
                abort(404, 'Profil muzakki tidak ditemukan.');
            }
        }
        
        return view('muzakki.edit', compact('muzakki'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Muzakki $muzakki = null)
    {
        // If no muzakki is provided, get current user's muzakki profile (for profile update)
        if (!$muzakki) {
            $muzakki = auth()->user()->muzakki;
            if (!$muzakki) {
                abort(404, 'Profil muzakki tidak ditemukan.');
            }
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'email', Rule::unique('muzakki', 'email')->ignore($muzakki->id)],
            'phone' => 'nullable|string|max:20',
            'nik' => ['nullable', 'string', 'max:20', Rule::unique('muzakki', 'nik')->ignore($muzakki->id)],
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'occupation' => 'nullable|in:employee,entrepreneur,civil_servant,teacher,doctor,farmer,trader,other',
            'monthly_income' => 'nullable|numeric|min:0',
            'date_of_birth' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $muzakki->update($request->all());

        // Update related user account if exists
        if ($muzakki->user) {
            $muzakki->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'is_active' => $request->is_active ?? true,
            ]);
        }

        // Check if this is a profile update (no muzakki parameter) vs admin update
        if (request()->route()->hasParameter('muzakki')) {
            return redirect()->route('muzakki.index')->with('success', 'Data muzakki berhasil diperbarui.');
        } else {
            return redirect()->route('muzakki.dashboard')->with('success', 'Profil berhasil diperbarui.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Muzakki $muzakki)
    {
        // Check if muzakki has payments
        if ($muzakki->zakatPayments()->count() > 0) {
            return redirect()->route('muzakki.index')->with('error', 'Muzakki tidak dapat dihapus karena sudah memiliki riwayat pembayaran zakat.');
        }

        // Delete related user account if exists
        if ($muzakki->user) {
            $muzakki->user->delete();
        }

        $muzakki->delete();

        return redirect()->route('muzakki.index')->with('success', 'Data muzakki berhasil dihapus.');
    }

    /**
     * Toggle muzakki status
     */
    public function toggleStatus(Muzakki $muzakki)
    {
        $muzakki->update(['is_active' => !$muzakki->is_active]);

        // Update related user account if exists
        if ($muzakki->user) {
            $muzakki->user->update(['is_active' => $muzakki->is_active]);
        }

        $status = $muzakki->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('muzakki.index')->with('success', "Muzakki berhasil {$status}.");
    }

    /**
     * AJAX search endpoint for real-time search
     */
    public function search(Request $request)
    {
        $query = Muzakki::with('user');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by occupation
        if ($request->has('occupation') && $request->occupation != '') {
            $query->where('occupation', $request->occupation);
        }

        // Filter by city
        if ($request->has('city') && $request->city != '') {
            $query->where('city', 'like', "%{$request->city}%");
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status == 'active');
        }

        $muzakki = $query->latest()->paginate(15);

        // Calculate statistics
        $totalCount = Muzakki::count();
        $activeCount = Muzakki::where('is_active', true)->count();
        $inactiveCount = Muzakki::where('is_active', false)->count();
        $thisMonthCount = Muzakki::where('created_at', '>=', now()->startOfMonth())->count();

        return response()->json([
            'success' => true,
            'data' => [
                'muzakki' => $muzakki->items(),
                'pagination' => [
                    'current_page' => $muzakki->currentPage(),
                    'last_page' => $muzakki->lastPage(),
                    'per_page' => $muzakki->perPage(),
                    'total' => $muzakki->total(),
                    'from' => $muzakki->firstItem(),
                    'to' => $muzakki->lastItem(),
                ],
                'statistics' => [
                    'total' => $totalCount,
                    'active' => $activeCount,
                    'inactive' => $inactiveCount,
                    'this_month' => $thisMonthCount,
                ],
            ]
        ]);
    }
}
