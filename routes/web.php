<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MuzakkiController;
use App\Http\Controllers\MustahikController;
use App\Http\Controllers\ZakatPaymentController;
use App\Http\Controllers\ZakatDistributionController;
use App\Http\Controllers\ZakatCalculatorController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\TestMidtransController;
use App\Http\Controllers\ReportsController;
use Barryvdh\DomPDF\Facade\Pdf;

// Public routes
Route::group(['prefix' => ''], function () {
    Route::get('/', function () {
        return view('pages.home');
    })->name('home');

    Route::get('/program', function () {
        return view('pages.program');
    })->name('program');

    // Program detail routes
    Route::get('/program/pendidikan', function () {
        $zakatTypes = \App\Models\ZakatType::active()->get();
        return view('programs.pendidikan', compact('zakatTypes'));
    })->name('program.pendidikan');

    Route::get('/program/kesehatan', function () {
        $zakatTypes = \App\Models\ZakatType::active()->get();
        return view('programs.kesehatan', compact('zakatTypes'));
    })->name('program.kesehatan');

    Route::get('/program/ekonomi', function () {
        $zakatTypes = \App\Models\ZakatType::active()->get();
        return view('programs.ekonomi', compact('zakatTypes'));
    })->name('program.ekonomi');

    Route::get('/program/sosial-dakwah', function () {
        $zakatTypes = \App\Models\ZakatType::active()->get();
        return view('programs.sosial-dakwah', compact('zakatTypes'));
    })->name('program.sosial-dakwah');

    Route::get('/program/kemanusiaan', function () {
        $zakatTypes = \App\Models\ZakatType::active()->get();
        return view('programs.kemanusiaan', compact('zakatTypes'));
    })->name('program.kemanusiaan');

    Route::get('/program/lingkungan', function () {
        $zakatTypes = \App\Models\ZakatType::active()->get();
        return view('programs.lingkungan', compact('zakatTypes'));
    })->name('program.lingkungan');

    // Program donation routes
    Route::get('/program/pendidikan/donasi', function () {
        $zakatTypes = \App\Models\ZakatType::active()->get();
        $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('pendidikan')->sum('paid_amount');
        return view('programs.donasi-pendidikan', compact('zakatTypes', 'collectedAmount'));
    })->name('program.pendidikan.donasi');

    Route::get('/program/kesehatan/donasi', function () {
        $zakatTypes = \App\Models\ZakatType::active()->get();
        $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('kesehatan')->sum('paid_amount');
        return view('programs.donasi-kesehatan', compact('zakatTypes', 'collectedAmount'));
    })->name('program.kesehatan.donasi');

    Route::get('/program/ekonomi/donasi', function () {
        $zakatTypes = \App\Models\ZakatType::active()->get();
        $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('ekonomi')->sum('paid_amount');
        return view('programs.donasi-ekonomi', compact('zakatTypes', 'collectedAmount'));
    })->name('program.ekonomi.donasi');

    Route::get('/program/sosial-dakwah/donasi', function () {
        $zakatTypes = \App\Models\ZakatType::active()->get();
        $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('sosial-dakwah')->sum('paid_amount');
        return view('programs.donasi-sosial-dakwah', compact('zakatTypes', 'collectedAmount'));
    })->name('program.sosial-dakwah.donasi');

    Route::get('/program/kemanusiaan/donasi', function () {
        $zakatTypes = \App\Models\ZakatType::active()->get();
        $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('kemanusiaan')->sum('paid_amount');
        return view('programs.donasi-kemanusiaan', compact('zakatTypes', 'collectedAmount'));
    })->name('program.kemanusiaan.donasi');

    Route::get('/program/lingkungan/donasi', function () {
        $zakatTypes = \App\Models\ZakatType::active()->get();
        $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('lingkungan')->sum('paid_amount');
        return view('programs.donasi-lingkungan', compact('zakatTypes', 'collectedAmount'));
    })->name('program.lingkungan.donasi');

    Route::get('/tentang', function () {
        return view('pages.tentang');
    })->name('tentang');

    
    Route::get('/berita', [NewsController::class, 'index'])->name('berita');
    Route::get('/news', [NewsController::class, 'all'])->name('news.all');
    Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
    
    // Artikel routes
    Route::get('/artikel', [ArtikelController::class, 'publicIndex'])->name('artikel.index');
    Route::get('/artikel/all', [ArtikelController::class, 'publicIndex'])->name('artikel.all');
    Route::get('/artikel/{slug}', [ArtikelController::class, 'publicShow'])->name('artikel.show');
    
    // Test Midtrans routes
    Route::get('/test/midtrans/config', function () {
        return response()->json([
            'server_key' => config('midtrans.server_key') ? substr(config('midtrans.server_key'), 0, 10) . '...' : null,
            'client_key' => config('midtrans.client_key') ? substr(config('midtrans.client_key'), 0, 10) . '...' : null,
            'is_production' => config('midtrans.is_production', false),
            'is_sanitized' => config('midtrans.is_sanitized', true),
            'is_3ds' => config('midtrans.is_3ds', true),
        ]);
    })->name('test.midtrans.config');

    // Test PDF route
    Route::get('/test-pdf', function () {
        $pdf = Pdf::loadView('reports.exports.incoming-pdf', [
            'title' => 'Test PDF',
            'date' => date('d/m/Y'),
            'payments' => [],
            'total_amount' => 0,
            'total_count' => 0
        ]);
        return $pdf->download('test.pdf');
    });

    // Test dropdown route
    Route::get('/test-dropdown', function () {
        return view('test-dropdown');
    });

});




// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public zakat calculator
Route::get('/calculator', [ZakatCalculatorController::class, 'index'])->name('calculator.index');
Route::post('/calculator/calculate', [ZakatCalculatorController::class, 'calculate'])->name('calculator.calculate');
Route::get('/calculator/guide', [ZakatCalculatorController::class, 'guide'])->name('calculator.guide');
Route::get('/calculator/gold-price', [ZakatCalculatorController::class, 'getGoldPrice'])->name('calculator.gold-price');

// Guest payment routes (no login required)
Route::prefix('donasi')->name('guest.payment.')->group(function () {
    Route::get('/', [ZakatPaymentController::class, 'guestCreate'])->name('create');
    Route::post('/store', [ZakatPaymentController::class, 'guestStore'])->name('store');
    Route::get('/summary/{paymentCode}', [ZakatPaymentController::class, 'guestSummary'])->name('summary');
    Route::get('/success/{paymentCode}', [ZakatPaymentController::class, 'guestSuccess'])->name('success');
    Route::post('/get-token/{paymentCode}', [ZakatPaymentController::class, 'getSnapToken'])->name('getToken');
    Route::get('/{payment}/receipt', [ZakatPaymentController::class, 'guestReceipt'])->name('receipt');
});

Route::post('/midtrans/callback', [ZakatPaymentController::class, 'midtransCallback'])->name('midtrans.callback');

// Protected routes
Route::middleware('auth')->group(function () {

    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');

    // Muzakki dashboard (for muzakki role)
    Route::get('/muzakki/dashboard', [DashboardController::class, 'index'])->name('muzakki.dashboard');

    // Admin and Staff only routes
    Route::middleware('role:admin,staff')->group(function () {

        // Muzakki management
        Route::resource('muzakki', MuzakkiController::class);
        Route::patch('/muzakki/{muzakki}/toggle-status', [MuzakkiController::class, 'toggleStatus'])->name('muzakki.toggle-status');
        Route::get('/api/muzakki/search', [MuzakkiController::class, 'search'])->name('api.muzakki.search');

        // Mustahik management
        Route::resource('mustahik', MustahikController::class);
        Route::patch('/mustahik/{mustahik}/verify', [MustahikController::class, 'verify'])->name('mustahik.verify');
        Route::patch('/mustahik/{mustahik}/toggle-status', [MustahikController::class, 'toggleStatus'])->name('mustahik.toggle-status');
        Route::get('/api/mustahik/by-category', [MustahikController::class, 'getByCategory'])->name('api.mustahik.by-category');
        Route::get('/api/mustahik/search', [MustahikController::class, 'search'])->name('api.mustahik.search');

        // Zakat payments management (Admin/Staff can manage all)
        Route::resource('payments', ZakatPaymentController::class)->except(['create', 'store']);
        Route::get('/api/payments/search', [ZakatPaymentController::class, 'search'])->name('api.payments.search');

        // Zakat distributions management
        Route::resource('distributions', ZakatDistributionController::class);
        Route::patch('/distributions/{distribution}/mark-received', [ZakatDistributionController::class, 'markAsReceived'])->name('distributions.mark-received');
        Route::get('/distributions-report/category', [ZakatDistributionController::class, 'reportByCategory'])->name('distributions.report.category');
        Route::get('/api/distributions/mustahik-by-category', [ZakatDistributionController::class, 'getMustahikByCategory'])->name('api.distributions.mustahik-by-category');
        Route::get('/api/distributions/search', [ZakatDistributionController::class, 'search'])->name('api.distributions.search');

        // Receipt generation
        Route::get('/payments/{payment}/receipt', [ZakatPaymentController::class, 'receipt'])->name('payments.receipt');
        Route::get('/distributions/{distribution}/receipt', [ZakatDistributionController::class, 'receipt'])->name('distributions.receipt');

        // Reports routes
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/incoming', [ReportsController::class, 'incoming'])->name('incoming');
            
            Route::get('/outgoing', [ReportsController::class, 'outgoing'])->name('outgoing');
        });

        // News management
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/news', [NewsController::class, 'adminIndex'])->name('news.index');
            Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
            Route::post('/news', [NewsController::class, 'store'])->name('news.store');
            Route::get('/news/{news}', [NewsController::class, 'adminShow'])->name('news.show');
            Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
            Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
            Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
            Route::patch('/news/{news}/toggle-publish', [NewsController::class, 'togglePublish'])->name('news.toggle-publish');
            
            // Artikel management
            Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
            Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
            Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
            Route::get('/artikel/{artikel}', [ArtikelController::class, 'show'])->name('artikel.show');
            Route::get('/artikel/{artikel}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
            Route::put('/artikel/{artikel}', [ArtikelController::class, 'update'])->name('artikel.update');
            Route::delete('/artikel/{artikel}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');
            Route::patch('/artikel/{artikel}/toggle-publish', [ArtikelController::class, 'togglePublish'])->name('artikel.toggle-publish');
        });
    });

    // Muzakki-specific routes (for muzakki role users)
    Route::middleware('role:muzakki')->prefix('muzakki')->name('muzakki.')->group(function () {
        // Muzakki payments
        Route::get('/payments', [ZakatPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/create', [ZakatPaymentController::class, 'create'])->name('payments.create');
        Route::post('/payments', [ZakatPaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments/{payment}', [ZakatPaymentController::class, 'show'])->name('payments.show');
        Route::get('/payments/{payment}/receipt', [ZakatPaymentController::class, 'receipt'])->name('payments.receipt');
        
        // Muzakki profile management
        Route::get('/profile/edit', [MuzakkiController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [MuzakkiController::class, 'update'])->name('profile.update');
        
        // Muzakki calculator (same as public calculator but with muzakki context)
        Route::get('/calculator', [ZakatCalculatorController::class, 'index'])->name('calculator');
    });

    // Routes accessible by all authenticated users (including muzakki)
    Route::group([], function () {

        // Zakat payments (Muzakki can create their own payments)
        Route::get('/payments/create', [ZakatPaymentController::class, 'create'])->name('payments.create');
        Route::post('/payments', [ZakatPaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments/{payment}', [ZakatPaymentController::class, 'show'])->name('payments.show');
        Route::get('/payments/{payment}/receipt', [ZakatPaymentController::class, 'receipt'])->name('payments.receipt');

        // Zakat calculator for authenticated users
        Route::get('/my-calculator', [ZakatCalculatorController::class, 'index'])->name('my-calculator');
    });

    // Admin only routes
    Route::middleware('role:admin')->group(function () {

        // User management routes would go here
        // Settings and configuration routes would go here

    });
});