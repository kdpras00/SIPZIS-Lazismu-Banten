<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Muzakki;
use App\Models\Mustahik;
use App\Models\ZakatPayment;
use App\Models\ZakatDistribution;
use App\Models\ZakatType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Middleware is applied in routes

    public function index()
    {
        $user = Auth::user();

        // Ensure only admin/staff can access admin dashboard
        if ($user->role === 'admin' || $user->role === 'staff') {
            return $this->adminDashboard();
        }

        // Ensure only muzakki can access muzakki dashboard
        if ($user->role === 'muzakki') {
            return $this->muzakkiDashboard();
        }

        // If user has no recognized role, redirect to appropriate page
        Auth::logout();
        return redirect('/');
    }

    private function adminDashboard()
    {
        // Get current year and month
        $currentYear = date('Y');
        $currentMonth = date('m');

        // Dashboard statistics
        $stats = [
            'total_muzakki' => Muzakki::active()->count(),
            'total_mustahik' => Mustahik::active()->count(),
            'total_payments_this_year' => ZakatPayment::completed()->byYear($currentYear)->sum('paid_amount'),
            'total_distributions_this_year' => ZakatDistribution::byYear($currentYear)->sum('amount'),
            'pending_mustahik' => Mustahik::pending()->count(),
            'total_payments_this_month' => ZakatPayment::completed()->byMonth($currentMonth)->sum('paid_amount'),
            'total_distributions_this_month' => ZakatDistribution::byYear($currentYear)->whereMonth('distribution_date', $currentMonth)->sum('amount'),
        ];

        // Recent payments
        $recentPayments = ZakatPayment::with(['muzakki', 'programType'])
            ->completed()
            ->latest('payment_date')
            ->take(5)
            ->get();

        // Recent distributions
        $recentDistributions = ZakatDistribution::with(['mustahik'])
            ->latest('distribution_date')
            ->take(5)
            ->get();

        // Monthly payment chart data
        $monthlyPayments = ZakatPayment::completed()
            ->byYear($currentYear)
            ->selectRaw('MONTH(payment_date) as month, SUM(paid_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Fill missing months with 0
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyPayments[$i] ?? 0;
        }

        // Zakat type distribution
        $programTypeStats = ZakatPayment::completed()
            ->byYear($currentYear)
            ->selectRaw('program_type_id, SUM(paid_amount) as total')
            ->groupBy('program_type_id')
            ->with('programType')
            ->get();

        // Mustahik category distribution
        $mustahikCategoryStats = Mustahik::selectRaw('category, COUNT(*) as count')
            ->verified()
            ->groupBy('category')
            ->get();

        return view('dashboard.admin', compact(
            'stats',
            'recentPayments',
            'recentDistributions',
            'chartData',
            'programTypeStats',
            'mustahikCategoryStats'
        ));
    }

    private function muzakkiDashboard()
    {
        $user = Auth::user();
        $muzakki = $user->muzakki;

        if (!$muzakki) {
            return redirect()->route('profile.create')->with('info', 'Silakan lengkapi profil muzakki Anda.');
        }

        // Get current year
        $currentYear = date('Y');

        // Muzakki statistics
        $stats = [
            'total_zakat_paid' => $muzakki->zakatPayments()->completed()->sum('paid_amount'),
            'zakat_this_year' => $muzakki->zakatPayments()->completed()->byYear($currentYear)->sum('paid_amount'),
            'payment_count' => $muzakki->zakatPayments()->completed()->count(),
            'last_payment' => $muzakki->zakatPayments()->completed()->latest('payment_date')->first(),
        ];

        // Recent payments
        $recentPayments = $muzakki->zakatPayments()
            ->with('programType')
            ->completed()
            ->latest('payment_date')
            ->take(5)
            ->get();

        // Yearly payment summary
        $yearlyPayments = $muzakki->zakatPayments()
            ->completed()
            ->selectRaw('YEAR(payment_date) as year, SUM(paid_amount) as total')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->take(5)
            ->get();

        // Zakat types available
        $zakatTypes = ZakatType::active()->get();

        // Calculate profile completeness
        $profileCompleteness = $muzakki->profile_completeness;

        return view('dashboard.muzakki', compact(
            'muzakki',
            'stats',
            'recentPayments',
            'yearlyPayments',
            'zakatTypes',
            'profileCompleteness'
        ));
    }

    public function stats()
    {
        // API endpoint for dashboard statistics
        $currentYear = date('Y');
        $currentMonth = date('m');

        $data = [
            'payments' => [
                'total_this_year' => ZakatPayment::completed()->byYear($currentYear)->sum('paid_amount'),
                'total_this_month' => ZakatPayment::completed()->byMonth($currentMonth)->sum('paid_amount'),
                'count_this_year' => ZakatPayment::completed()->byYear($currentYear)->count(),
            ],
            'distributions' => [
                'total_this_year' => ZakatDistribution::byYear($currentYear)->sum('amount'),
                'total_this_month' => ZakatDistribution::byYear($currentYear)->whereMonth('distribution_date', $currentMonth)->sum('amount'),
                'count_this_year' => ZakatDistribution::byYear($currentYear)->count(),
            ],
            'balance' => ZakatPayment::completed()->sum('paid_amount') - ZakatDistribution::sum('amount'),
        ];

        return response()->json($data);
    }

    // Muzakki dashboard section methods
    public function transactions()
    {
        $user = Auth::user();
        $muzakki = $user->muzakki;

        if (!$muzakki) {
            return redirect()->route('profile.create')->with('info', 'Silakan lengkapi profil muzakki Anda.');
        }

        $payments = $muzakki->zakatPayments()
            ->with('programType')
            ->latest('payment_date')
            ->paginate(10);

        return view('muzakki.dashboard.transactions', compact('muzakki', 'payments'));
    }

    public function recurringDonations()
    {
        $user = Auth::user();
        $muzakki = $user->muzakki;

        if (!$muzakki) {
            return redirect()->route('profile.create')->with('info', 'Silakan lengkapi profil muzakki Anda.');
        }

        // For now, we're just returning the view
        // In a real implementation, this would fetch recurring donations
        return view('muzakki.dashboard.recurring-donations', compact('muzakki'));
    }

    public function bankAccounts()
    {
        $user = Auth::user();
        $muzakki = $user->muzakki;

        if (!$muzakki) {
            return redirect()->route('profile.create')->with('info', 'Silakan lengkapi profil muzakki Anda.');
        }

        // For now, we're just returning the view
        // In a real implementation, this would fetch bank accounts
        return view('muzakki.dashboard.bank-accounts', compact('muzakki'));
    }

    public function accountManagement()
    {
        $user = Auth::user();
        $muzakki = $user->muzakki;

        if (!$muzakki) {
            return redirect()->route('profile.create')->with('info', 'Silakan lengkapi profil muzakki Anda.');
        }

        return view('muzakki.dashboard.account-management', compact('muzakki'));
    }
}
