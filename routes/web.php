<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ZakatPaymentController;
use App\Http\Controllers\MuzakkiController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ZakatCalculatorController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MustahikController;
use App\Http\Controllers\ZakatDistributionController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ChatbotController;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Chatbot route
Route::post('/chatbot', [ChatbotController::class, 'ask'])->name('chatbot.ask');

// Redirect /admin to admin login page
Route::get('/admin', function () {
    return redirect()->route('admin.login');
});



Route::get('/payment/{paymentCode}/failed', [ZakatPaymentController::class, 'guestFailed'])
    ->name('guest.payment.failed');



Route::get('/guest/payment/check-status/{paymentCode}', [ZakatPaymentController::class, 'checkStatus'])->name('guest.payment.checkStatus');

// Route::get('/program/{slug}', [ProgramController::class, 'show'])->name('program.show');


Route::get('/program', function () {
    // Fetch all programs grouped by category for the main program page
    $zakatPrograms = \App\Models\Program::where('category', 'like', 'zakat-%')->active()->get();
    $infaqPrograms = \App\Models\Program::where('category', 'like', 'infaq-%')->active()->get();
    $shadaqahPrograms = \App\Models\Program::where('category', 'like', 'shadaqah-%')->active()->get();
    $pilarPrograms = \App\Models\Program::whereIn('category', ['pendidikan', 'kesehatan', 'ekonomi', 'sosial-dakwah', 'kemanusiaan', 'lingkungan'])->active()->get();

    return view('pages.program', compact('zakatPrograms', 'infaqPrograms', 'shadaqahPrograms', 'pilarPrograms'));
})->name('program');

// Tab-specific routes for program categories
Route::get('/program/zakat', function () {
    $zakatPrograms = \App\Models\Program::where('category', 'like', 'zakat-%')->active()->get();
    $infaqPrograms = \App\Models\Program::where('category', 'like', 'infaq-%')->active()->get();
    $shadaqahPrograms = \App\Models\Program::where('category', 'like', 'shadaqah-%')->active()->get();
    $pilarPrograms = \App\Models\Program::whereIn('category', ['pendidikan', 'kesehatan', 'ekonomi', 'sosial-dakwah', 'kemanusiaan', 'lingkungan'])->active()->get();

    return view('pages.program', [
        'activeTab' => 'zakat',
        'zakatPrograms' => $zakatPrograms,
        'infaqPrograms' => $infaqPrograms,
        'shadaqahPrograms' => $shadaqahPrograms,
        'pilarPrograms' => $pilarPrograms
    ]);
})->name('program.zakat');

Route::get('/program/infaq', function () {
    $zakatPrograms = \App\Models\Program::where('category', 'like', 'zakat-%')->active()->get();
    $infaqPrograms = \App\Models\Program::where('category', 'like', 'infaq-%')->active()->get();
    $shadaqahPrograms = \App\Models\Program::where('category', 'like', 'shadaqah-%')->active()->get();
    $pilarPrograms = \App\Models\Program::whereIn('category', ['pendidikan', 'kesehatan', 'ekonomi', 'sosial-dakwah', 'kemanusiaan', 'lingkungan'])->active()->get();

    return view('pages.program', [
        'activeTab' => 'infaq',
        'zakatPrograms' => $zakatPrograms,
        'infaqPrograms' => $infaqPrograms,
        'shadaqahPrograms' => $shadaqahPrograms,
        'pilarPrograms' => $pilarPrograms
    ]);
})->name('program.infaq');

Route::get('/program/shadaqah', function () {
    $zakatPrograms = \App\Models\Program::where('category', 'like', 'zakat-%')->active()->get();
    $infaqPrograms = \App\Models\Program::where('category', 'like', 'infaq-%')->active()->get();
    $shadaqahPrograms = \App\Models\Program::where('category', 'like', 'shadaqah-%')->active()->get();
    $pilarPrograms = \App\Models\Program::whereIn('category', ['pendidikan', 'kesehatan', 'ekonomi', 'sosial-dakwah', 'kemanusiaan', 'lingkungan'])->active()->get();

    return view('pages.program', [
        'activeTab' => 'shadaqah',
        'zakatPrograms' => $zakatPrograms,
        'infaqPrograms' => $infaqPrograms,
        'shadaqahPrograms' => $shadaqahPrograms,
        'pilarPrograms' => $pilarPrograms
    ]);
})->name('program.shadaqah');

Route::get('/program/pilar', function () {
    $zakatPrograms = \App\Models\Program::where('category', 'like', 'zakat-%')->active()->get();
    $infaqPrograms = \App\Models\Program::where('category', 'like', 'infaq-%')->active()->get();
    $shadaqahPrograms = \App\Models\Program::where('category', 'like', 'shadaqah-%')->active()->get();
    $pilarPrograms = \App\Models\Program::whereIn('category', ['pendidikan', 'kesehatan', 'ekonomi', 'sosial-dakwah', 'kemanusiaan', 'lingkungan'])->active()->get();

    return view('pages.program', [
        'activeTab' => 'pilar',
        'zakatPrograms' => $zakatPrograms,
        'infaqPrograms' => $infaqPrograms,
        'shadaqahPrograms' => $shadaqahPrograms,
        'pilarPrograms' => $pilarPrograms
    ]);
})->name('program.pilar');

Route::get('/program/pendidikan', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $program = \App\Models\Program::byCategory('pendidikan')->first();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('pendidikan')->sum('paid_amount');
    $totalTarget = $program ? $program->total_target : 0;
    return view('programs.pendidikan', compact('zakatTypes', 'collectedAmount', 'totalTarget'));
})->name('program.pendidikan');

Route::get('/program/kesehatan', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $program = \App\Models\Program::byCategory('kesehatan')->first();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('kesehatan')->sum('paid_amount');
    $totalTarget = $program ? $program->total_target : 0;
    return view('programs.kesehatan', compact('zakatTypes', 'collectedAmount', 'totalTarget'));
})->name('program.kesehatan');

Route::get('/program/ekonomi', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $program = \App\Models\Program::byCategory('ekonomi')->first();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('ekonomi')->sum('paid_amount');
    $totalTarget = $program ? $program->total_target : 0;
    return view('programs.ekonomi', compact('zakatTypes', 'collectedAmount', 'totalTarget'));
})->name('program.ekonomi');

Route::get('/program/sosial-dakwah', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $program = \App\Models\Program::byCategory('sosial-dakwah')->first();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('sosial-dakwah')->sum('paid_amount');
    $totalTarget = $program ? $program->total_target : 0;
    return view('programs.sosial-dakwah', compact('zakatTypes', 'collectedAmount', 'totalTarget'));
})->name('program.sosial-dakwah');

Route::get('/program/kemanusiaan', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $program = \App\Models\Program::byCategory('kemanusiaan')->first();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('kemanusiaan')->sum('paid_amount');
    $totalTarget = $program ? $program->total_target : 0;
    return view('programs.kemanusiaan', compact('zakatTypes', 'collectedAmount', 'totalTarget'));
})->name('program.kemanusiaan');

Route::get('/program/lingkungan', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $program = \App\Models\Program::byCategory('lingkungan')->first();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('lingkungan')->sum('paid_amount');
    $totalTarget = $program ? $program->total_target : 0;
    return view('programs.lingkungan', compact('zakatTypes', 'collectedAmount', 'totalTarget'));
})->name('program.lingkungan');

// Program donation routes
Route::get('/program/pendidikan/donasi', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('pendidikan')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('pendidikan')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'pendidikan';
    return view('programs.donasi-pendidikan', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.pendidikan.donasi');

Route::get('/program/kesehatan/donasi', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('kesehatan')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('kesehatan')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'kesehatan';
    return view('programs.donasi-kesehatan', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.kesehatan.donasi');

Route::get('/program/ekonomi/donasi', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('ekonomi')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('ekonomi')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'ekonomi';
    return view('programs.donasi-ekonomi', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.ekonomi.donasi');

Route::get('/program/sosial-dakwah/donasi', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('sosial-dakwah')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('sosial-dakwah')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'sosial-dakwah';
    return view('programs.donasi-sosial-dakwah', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.sosial-dakwah.donasi');

Route::get('/program/kemanusiaan/donasi', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('kemanusiaan')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('kemanusiaan')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'kemanusiaan';
    return view('programs.donasi-kemanusiaan', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.kemanusiaan.donasi');

Route::get('/program/lingkungan/donasi', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('lingkungan')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('lingkungan')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'lingkungan';
    return view('programs.donasi-lingkungan', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.lingkungan.donasi');

// Zakat program routes
Route::get('/program/zakat-mal', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('zakat-mal')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('zakat-mal')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'zakat-mal';
    return view('programs.zakat-mal', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.zakat-mal');

Route::get('/program/zakat-fitrah', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('zakat-fitrah')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('zakat-fitrah')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'zakat-fitrah';
    return view('programs.zakat-fitrah', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.zakat-fitrah');

Route::get('/program/zakat-profesi', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('zakat-profesi')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('zakat-profesi')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'zakat-profesi';
    return view('programs.zakat-profesi', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.zakat-profesi');

Route::get('/program/zakat-pertanian', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('zakat-pertanian')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('zakat-pertanian')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'zakat-pertanian';
    return view('programs.zakat-pertanian', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.zakat-pertanian');

Route::get('/program/zakat-perdagangan', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('zakat-perdagangan')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('zakat-perdagangan')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'zakat-perdagangan';
    return view('programs.zakat-perdagangan', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.zakat-perdagangan');

// Infaq program routes
Route::get('/program/infaq-masjid', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('infaq-masjid')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('infaq-masjid')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'infaq-masjid';
    return view('programs.infaq-masjid', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.infaq-masjid');

Route::get('/program/infaq-pendidikan', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('infaq-pendidikan')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('infaq-pendidikan')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'infaq-pendidikan';
    return view('programs.infaq-pendidikan', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.infaq-pendidikan');

Route::get('/program/infaq-kemanusiaan', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('infaq-kemanusiaan')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('infaq-kemanusiaan')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'infaq-kemanusiaan';
    return view('programs.infaq-kemanusiaan', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.infaq-kemanusiaan');

Route::get('/program/infaq-bencana', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('infaq-bencana')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('infaq-bencana')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'infaq-bencana';
    return view('programs.infaq-bencana', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.infaq-bencana');

Route::get('/program/infaq-sosial', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('infaq-sosial')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('infaq-sosial')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'infaq-sosial';
    return view('programs.infaq-sosial', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.infaq-sosial');

// Shadaqah program routes
Route::get('/program/shadaqah-rutin', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('shadaqah-rutin')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('shadaqah-rutin')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'shadaqah-rutin';
    return view('programs.shadaqah-rutin', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.shadaqah-rutin');

Route::get('/program/shadaqah-jariyah', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('shadaqah-jariyah')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('shadaqah-jariyah')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'shadaqah-jariyah';
    return view('programs.shadaqah-jariyah', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.shadaqah-jariyah');

Route::get('/program/fidyah', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('fidyah')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('fidyah')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'fidyah';
    return view('programs.fidyah', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.fidyah');

Route::get('/program/shadaqah-tetangga', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('shadaqah-tetangga')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('shadaqah-tetangga')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'shadaqah-tetangga';
    return view('programs.shadaqah-tetangga', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.shadaqah-tetangga');

Route::get('/program/shadaqah-pakaian', function () {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory('shadaqah-pakaian')->sum('paid_amount');
    $program = \App\Models\Program::byCategory('shadaqah-pakaian')->first();
    $totalTarget = $program ? $program->total_target : 0;
    $category = 'shadaqah-pakaian';
    return view('programs.shadaqah-pakaian', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('program.shadaqah-pakaian');

// Campaign routes
Route::get('/campaigns/{category}', [CampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaigns/{category}/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');

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

// Test Guest Receipt PDF
Route::get('/test-guest-receipt-pdf/{paymentCode}', function ($paymentCode) {
    $payment = \App\Models\ZakatPayment::where('payment_code', $paymentCode)
        ->where('is_guest_payment', true)
        ->firstOrFail();

    $payment->load(['muzakki', 'zakatType']);

    $pdf = Pdf::loadView('payments.guest-receipt-pdf', compact('payment'));
    return $pdf->download('kwitansi-' . $paymentCode . '.pdf');
})->name('test.guest.receipt.pdf');

// Image serving route to avoid 403 errors
Route::get('/images/{path}', function ($path) {
    // Security check to prevent directory traversal
    if (strpos($path, '..') !== false) {
        abort(404);
    }

    // Define the storage path
    $storagePath = storage_path('app/public/' . $path);

    // Check if file exists
    if (!file_exists($storagePath)) {
        abort(404);
    }

    // Get file mime type
    $mimeType = mime_content_type($storagePath);

    // Return the file with proper headers
    return response()->file($storagePath, [
        'Content-Type' => $mimeType,
        'Cache-Control' => 'public, max-age=31536000' // Cache for 1 year
    ]);
})->where('path', '.*')->name('image.serve');

// Test dropdown route
Route::get('/test-dropdown', function () {
    return view('test-dropdown');
});

// Test route to verify dynamic calculation
Route::get('/test-calculation', function () {
    $category = 'pendidikan';
    $campaignCollected = \App\Models\Campaign::published()->byCategory($category)->get()->sum(function ($campaign) {
        return $campaign->zakatPayments()->sum('paid_amount');
    });

    $directCollected = \App\Models\ZakatPayment::completed()->byProgramCategory($category)->sum('paid_amount');

    return response()->json([
        'campaign_based_calculation' => $campaignCollected,
        'direct_calculation' => $directCollected,
        'campaigns' => \App\Models\Campaign::published()->byCategory($category)->get()->map(function ($campaign) {
            return [
                'title' => $campaign->title,
                'collected' => $campaign->zakatPayments()->sum('paid_amount')
            ];
        })
    ]);
});

// Test route to verify program totals
Route::get('/test-program-totals', function () {
    $programs = \App\Models\Program::all();

    $results = [];
    foreach ($programs as $program) {
        $results[] = [
            'program' => $program->name,
            'category' => $program->category,
            'total_collected' => $program->total_collected,
            'total_target' => $program->total_target,
            'progress_percentage' => $program->progress_percentage
        ];
    }

    return response()->json($results);
});

// Test route to verify target amounts
Route::get('/test-target-amounts', function () {
    $programs = \App\Models\Program::all();
    $results = [];

    foreach ($programs as $program) {
        $results[] = [
            'name' => $program->name,
            'category' => $program->category,
            'target_amount' => $program->target_amount,
            'total_target' => $program->total_target,
            'collected_amount' => $program->total_collected,
            'progress_percentage' => $program->progress_percentage
        ];
    }

    return response()->json($results);
});

// Test route to verify program type fix
Route::get('/test-program-type-fix', function () {
    // Get a sample guest payment
    $payment = \App\Models\ZakatPayment::where('is_guest_payment', true)->latest()->first();

    if (!$payment) {
        return response()->json(['message' => 'No guest payments found']);
    }

    return response()->json([
        'payment_code' => $payment->payment_code,
        'program_category' => $payment->program_category,
        'program_type_id' => $payment->program_type_id,
        'program_type_name' => $payment->programType ? $payment->programType->name : null,
        'program_type_category' => $payment->programType ? $payment->programType->category : null,
    ]);
});

// Test route to check program types
Route::get('/test-program-types', function () {
    $types = \App\Models\ProgramType::all();
    return response()->json($types);
});

// Test route to create a guest payment with program type
Route::get('/test-create-guest-payment', function () {
    // Get a sample program type
    $programType = \App\Models\ProgramType::first();

    if (!$programType) {
        return response()->json(['message' => 'No program types found']);
    }

    // Create a test muzakki
    $muzakki = \App\Models\Muzakki::firstOrCreate(
        ['email' => 'test@example.com'],
        [
            'name' => 'Test Donor',
            'phone' => '08123456789',
            'is_active' => true,
        ]
    );

    // Create a payment with program type
    $payment = \App\Models\ZakatPayment::create([
        'payment_code' => \App\Models\ZakatPayment::generatePaymentCode(),
        'muzakki_id' => $muzakki->id,
        'program_type_id' => $programType->id,
        'program_category' => $programType->category,
        'paid_amount' => 50000,
        'payment_date' => now(),
        'status' => 'pending',
        'is_guest_payment' => true,
        'receipt_number' => \App\Models\ZakatPayment::generateReceiptNumber(),
    ]);

    return response()->json([
        'message' => 'Payment created successfully',
        'payment_code' => $payment->payment_code,
        'program_category' => $payment->program_category,
        'program_type_id' => $payment->program_type_id,
        'program_type_name' => $payment->programType ? $payment->programType->name : null,
    ]);
});

// Test route to check program category display
Route::get('/test-program-category-display/{paymentCode}', function ($paymentCode) {
    $payment = \App\Models\ZakatPayment::where('payment_code', $paymentCode)
        ->where('is_guest_payment', true)
        ->firstOrFail();

    $payment->load(['muzakki', 'programType']);

    // Test the logic
    $programName = $payment->programType ? $payment->programType->name : ($payment->program_category ? ucfirst(str_replace('-', ' ', $payment->program_category)) : 'Donasi Umum');

    return response()->json([
        'payment_code' => $payment->payment_code,
        'program_type_id' => $payment->program_type_id,
        'program_category' => $payment->program_category,
        'program_type_name' => $payment->programType ? $payment->programType->name : null,
        'computed_name' => $programName,
        'program_category_exists' => !empty($payment->program_category),
        'program_category_length' => strlen($payment->program_category ?? ''),
        'program_category_value' => var_export($payment->program_category, true)
    ]);
})->name('test.program.category.display');

// Authentication routes
// Admin login route
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

// Muzakki login route
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
    Route::post('/{paymentCode}/get-token-custom', [ZakatPaymentController::class, 'getTokenCustom'])->name('getTokenCustom');
    Route::get('/{paymentCode}/receipt', [ZakatPaymentController::class, 'guestReceiptByCode'])->name('receipt');
    Route::get('/{paymentCode}/receipt/download', [ZakatPaymentController::class, 'downloadGuestReceipt'])->name('receipt.download');
    Route::post('/leave-page/{paymentCode}', [ZakatPaymentController::class, 'guestLeavePage'])->name('leavePage');
    Route::get('/check-status/{paymentCode}', [ZakatPaymentController::class, 'guestCheckStatus'])->name('checkStatus');
});




// Protected routes
Route::middleware('auth')->group(function () {

    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');

    // Muzakki dashboard (for muzakki role)
    Route::get('/muzakki/dashboard', [DashboardController::class, 'index'])->name('muzakki.dashboard');

    // Muzakki dashboard sections
    Route::middleware('role:muzakki')->prefix('muzakki/dashboard')->name('muzakki.dashboard.')->group(function () {
        Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
        Route::get('/recurring', [DashboardController::class, 'recurringDonations'])->name('recurring');
        Route::get('/bank-accounts', [DashboardController::class, 'bankAccounts'])->name('bank-accounts');
        Route::get('/management', [DashboardController::class, 'accountManagement'])->name('management');
    });

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

            // Campaign management
            Route::get('/campaigns', [CampaignController::class, 'adminIndex'])->name('campaigns.index');
            Route::get('/campaigns/create', [CampaignController::class, 'adminCreate'])->name('campaigns.create');
            Route::post('/campaigns', [CampaignController::class, 'adminStore'])->name('campaigns.store');
            Route::get('/campaigns/{campaign}/edit', [CampaignController::class, 'adminEdit'])->name('campaigns.edit');
            Route::put('/campaigns/{campaign}', [CampaignController::class, 'adminUpdate'])->name('campaigns.update');
            Route::delete('/campaigns/{campaign}', [CampaignController::class, 'adminDestroy'])->name('campaigns.destroy');
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

        // Muzakki notifications
        Route::get('/notifications', [ZakatPaymentController::class, 'notifications'])->name('notifications.index');
        Route::get('/notifications/ajax', [ZakatPaymentController::class, 'ajaxNotifications'])->name('notifications.ajax');
        Route::post('/notifications/mark-as-read', [ZakatPaymentController::class, 'markNotificationsAsRead'])
            ->name('notifications.markAsRead');


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

        // Dedicated profile routes for all authenticated users
        Route::get('/profile', [MuzakkiController::class, 'edit'])->name('profile.show');
        Route::put('/profile', [MuzakkiController::class, 'update'])->name('profile.update');
    });

    // Admin only routes
    Route::middleware('role:admin')->group(function () {

        // User management routes would go here
        // Settings and configuration routes would go here

        // Program management routes
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/programs', [ProgramController::class, 'adminIndex'])->name('programs.index');
            Route::get('/programs/create', [ProgramController::class, 'adminCreate'])->name('programs.create');
            Route::get('/programs/bulk-create', [ProgramController::class, 'adminBulkCreate'])->name('programs.bulk-create');
            Route::post('/programs', [ProgramController::class, 'adminStore'])->name('programs.store');
            Route::post('/programs/bulk', [ProgramController::class, 'adminStoreBulk'])->name('programs.store.bulk');
            Route::get('/programs/{program}/edit', [ProgramController::class, 'adminEdit'])->name('programs.edit');
            Route::put('/programs/{program}', [ProgramController::class, 'adminUpdate'])->name('programs.update');
            Route::delete('/programs/{program}', [ProgramController::class, 'adminDestroy'])->name('programs.destroy');
        });
    });
});



// Test route for 404 page
Route::get('/test-404', function () {
    return response()->view('errors.404', [], 404);
});

// Test route to check if routing is working
Route::get('/test-donasi-redirect', function () {
    return redirect()->route('program');
});

// routes/web.php
Route::get('/payment/finish', [ZakatPaymentController::class, 'finish']);
Route::get('/payment/unfinish', [ZakatPaymentController::class, 'unfinish']);
Route::get('/payment/error', [ZakatPaymentController::class, 'error']);

// Midtrans Notification Route
Route::post('/midtrans/notification', [ZakatPaymentController::class, 'handleNotification']);

// Test route to verify our guest donation implementation

// Test route to verify relationships and data flow
Route::get('/test-data-flow', function () {
    // Get a program
    $program = \App\Models\Program::first();

    if (!$program) {
        return response()->json(['error' => 'No program found']);
    }

    // Get campaigns for this program
    $campaigns = $program->campaigns;

    // Calculate collected amount through campaigns
    $totalCollectedThroughCampaigns = 0;
    foreach ($campaigns as $campaign) {
        $totalCollectedThroughCampaigns += $campaign->zakatPayments()->completed()->sum('paid_amount');
    }

    // Calculate collected amount directly from program
    $totalCollectedFromProgram = $program->total_collected;

    // Get target amount from program
    $targetAmount = $program->total_target;

    return response()->json([
        'program' => $program->name,
        'program_category' => $program->category,
        'campaigns_count' => $campaigns->count(),
        'collected_through_campaigns' => $totalCollectedThroughCampaigns,
        'collected_from_program' => $totalCollectedFromProgram,
        'target_amount' => $targetAmount,
        'progress_percentage' => $program->progress_percentage
    ]);
});

// Debug route for testing collected amount display
Route::get('/debug-collected-amount/{category?}', function ($category = 'ekonomi') {
    $zakatTypes = \App\Models\ZakatType::active()->get();
    $collectedAmount = \App\Models\ZakatPayment::completed()->byProgramCategory($category)->sum('paid_amount');
    $program = \App\Models\Program::byCategory($category)->first();
    $totalTarget = $program ? $program->total_target : 0;

    return view('test-debug', compact('zakatTypes', 'collectedAmount', 'totalTarget', 'category'));
})->name('debug.collected.amount');

// Test route to debug Program model accessors
Route::get('/test-program-accessors/{category?}', function ($category = 'ekonomi') {
    $program = \App\Models\Program::byCategory($category)->first();

    if (!$program) {
        return response()->json(['error' => 'Program not found for category: ' . $category]);
    }

    return response()->json([
        'program_name' => $program->name,
        'category' => $program->category,
        'target_amount' => $program->target_amount,
        'total_collected' => $program->total_collected,
        'total_target' => $program->total_target,
        'progress_percentage' => $program->progress_percentage,
        'formatted_total_collected' => $program->formatted_total_collected,
        'formatted_total_target' => $program->formatted_total_target,
        'type_of_formatted_total_collected' => gettype($program->formatted_total_collected),
        'type_of_total_collected' => gettype($program->total_collected)
    ]);
})->name('test.program.accessors');

// Test route to check if views can be rendered
Route::get('/test-payment-views', function () {
    // Try to create a test payment
    $payment = \App\Models\ZakatPayment::first();

    if (!$payment) {
        return 'No payments found in database';
    }

    try {
        // Test if we can render the edit view
        $editView = view('payments.edit', compact('payment'))->render();

        // Test if we can render the receipt view
        $receiptView = view('payments.receipt', compact('payment'))->render();

        return 'Both views rendered successfully';
    } catch (\Exception $e) {
        return 'Error rendering views: ' . $e->getMessage();
    }
});

// Test route to check registration with minimal data
Route::get('/test-minimal-registration', function () {
    try {
        // Test registration with minimal data
        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'testuser' . time() . '@example.com',
            'password' => bcrypt('password'),
            'role' => 'muzakki',
            'is_active' => true,
        ]);

        // Create muzakki profile with nullable fields
        $muzakki = \App\Models\Muzakki::create([
            'name' => 'Test User',
            'email' => 'testuser' . time() . '@example.com',
            'phone' => null,
            'nik' => null,
            'gender' => null,
            'address' => null,
            'city' => null,
            'province' => null,
            'occupation' => null,
            'monthly_income' => null,
            'date_of_birth' => null,
            'user_id' => $user->id,
            'is_active' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registration test successful!',
            'user_id' => $user->id,
            'muzakki_id' => $muzakki->id
        ]);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Test failed with error: ' . $e->getMessage()
        ], 500);
    }
});

// Add this route for Firebase login
Route::post('/firebase-login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'name' => 'required|string',
        'firebase_uid' => 'required|string',
    ]);

    try {
        // Check if user already exists
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            // Create new user if doesn't exist
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt(uniqid()), // Generate a random password for Firebase users
                'role' => 'muzakki',
                'is_active' => true,
            ]);
        } else {
            // Update existing user's name if needed
            $user->update(['name' => $request->name]);
        }

        // Use findOrCreate method to handle muzakki profile
        $muzakkiData = [
            'name' => $request->name,
            'email' => $request->email,
            'user_id' => $user->id,
            'is_active' => true,
        ];

        \App\Models\Muzakki::findOrCreate($muzakkiData);

        // Log in the user
        Auth::login($user);

        return response()->json([
            'success' => true,
            'redirect' => '/',
            'message' => 'Login successful'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Authentication failed: ' . $e->getMessage()
        ], 500);
    }
})->name('firebase.login');
