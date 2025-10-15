<?php

namespace App\Http\Controllers;

use App\Models\ZakatDistribution;
use App\Models\Mustahik;
use App\Models\ZakatPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ZakatDistributionController extends Controller
{
    /**
     * Hitung saldo zakat yang tersedia (uang).
     * Mengembalikan 0 jika hasil negatif.
     */
    public static function availableBalance(): float
    {
        $paid = ZakatPayment::completed()->sum('paid_amount');
        $distributed = ZakatDistribution::where('distribution_type', 'cash')->sum('amount');
        $balance = $paid - $distributed;
        return $balance > 0 ? $balance : 0;
    }

    /**
     * Tampilkan daftar distribusi zakat dengan filter & statistik.
     */
    public function index(Request $request)
    {
        $query = ZakatDistribution::with(['mustahik', 'distributedBy']);

        // Filter pencarian umum
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('distribution_code', 'like', "%{$search}%")
                    ->orWhere('program_name', 'like', "%{$search}%")
                    ->orWhereHas('mustahik', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        // Filter kategori mustahik
        if ($category = $request->get('category')) {
            $query->whereHas('mustahik', fn($q) => $q->where('category', $category));
        }

        // Filter jenis distribusi
        if ($type = $request->get('distribution_type')) {
            $query->where('distribution_type', $type);
        }

        // Filter program zakat
        if ($program = $request->get('program')) {
            $query->where('program_name', 'like', "%{$program}%");
        }

        // Filter status penerimaan
        if ($request->has('received_status')) {
            $query->where('is_received', $request->received_status === 'received');
        }

        // Filter tanggal distribusi
        if ($from = $request->get('date_from')) {
            $query->whereDate('distribution_date', '>=', $from);
        }
        if ($to = $request->get('date_to')) {
            $query->whereDate('distribution_date', '<=', $to);
        }

        $distributions = $query->latest('distribution_date')->paginate(15)->withQueryString();

        // Data tambahan
        $categories = array_keys(Mustahik::CATEGORIES);
        $programs = ZakatDistribution::select('program_name')
            ->distinct()
            ->whereNotNull('program_name')
            ->pluck('program_name');

        // Statistik utama
        $stats = [
            'total_amount' => ZakatDistribution::sum('amount'),
            'total_count' => ZakatDistribution::count(),
            'this_month' => ZakatDistribution::whereMonth('distribution_date', date('m'))->sum('amount'),
            'pending_receipt' => ZakatDistribution::where('is_received', false)->count(),
            'available_balance' => self::availableBalance(),
        ];

        return view('distributions.index', compact('distributions', 'categories', 'programs', 'stats'));
    }

    /**
     * Form tambah distribusi baru.
     */
    public function create(Request $request)
    {
        $mustahikId = $request->get('mustahik_id');
        $mustahik = $mustahikId ? Mustahik::verified()->findOrFail($mustahikId) : null;

        $allMustahik = Mustahik::verified()->active()->orderBy('name')->get();
        $categories = array_keys(Mustahik::CATEGORIES);
        $availableBalance = self::availableBalance();

        return view('distributions.create', compact('mustahik', 'allMustahik', 'categories', 'availableBalance'));
    }

    /**
     * Simpan distribusi zakat baru.
     * Menghindari saldo minus.
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

        $mustahik = Mustahik::verified()->active()->findOrFail($request->mustahik_id);

        return DB::transaction(function () use ($request, $mustahik) {

            // Lock database agar saldo akurat saat concurrent
            $paid = ZakatPayment::completed()->lockForUpdate()->sum('paid_amount');
            $distributed = ZakatDistribution::where('distribution_type', 'cash')
                ->lockForUpdate()
                ->sum('amount');
            $available = max(0, $paid - $distributed);

            if ($request->distribution_type === 'cash' && $request->amount > $available) {
                return back()->withInput()->with('error', 'Saldo zakat tidak mencukupi.');
            }

            $distributionCode = ZakatDistribution::generateDistributionCode();

            ZakatDistribution::create([
                'distribution_code' => $distributionCode,
                'mustahik_id' => $mustahik->id,
                'amount' => $request->amount,
                'distribution_type' => $request->distribution_type,
                'goods_description' => $request->goods_description,
                'distribution_date' => $request->distribution_date,
                'notes' => $request->notes,
                'program_name' => $request->program_name,
                'distributed_by' => Auth::id(),
                'location' => $request->location,
                'is_received' => false,
            ]);

            return redirect()->route('distributions.index')->with('success', 'Distribusi zakat berhasil dicatat.');
        });
    }

    /**
     * Update distribusi zakat yang ada.
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

        return DB::transaction(function () use ($request, $distribution) {

            // Hitung ulang saldo tanpa menghitung distribusi yang sedang diubah
            $paid = ZakatPayment::completed()->lockForUpdate()->sum('paid_amount');
            $distributed = ZakatDistribution::where('id', '!=', $distribution->id)
                ->where('distribution_type', 'cash')
                ->lockForUpdate()
                ->sum('amount');

            $available = max(0, $paid - $distributed);

            if ($request->distribution_type === 'cash' && $request->amount > $available) {
                return back()->withInput()->with('error', 'Saldo zakat tidak mencukupi.');
            }

            $distribution->update($request->all());
            return redirect()->route('distributions.index')->with('success', 'Distribusi zakat berhasil diperbarui.');
        });
    }

    /**
     * Hapus distribusi zakat.
     * Tidak bisa dihapus jika sudah diterima.
     */
    public function destroy(ZakatDistribution $distribution)
    {
        if ($distribution->is_received) {
            return back()->with('error', 'Distribusi yang sudah diterima tidak dapat dihapus.');
        }

        $distribution->delete();
        return redirect()->route('distributions.index')->with('success', 'Data distribusi berhasil dihapus.');
    }
}
