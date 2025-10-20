<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\ProgramType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    /**
     * Display a listing of programs for admin management.
     */
    public function adminIndex()
    {
        $programs = Program::with('programType')
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $groupedPrograms = $programs->groupBy('category');

        return view('admin.programs.index', compact('groupedPrograms'));
    }

    /**
     * Show the form for creating a new program.
     */
    public function adminCreate()
    {
        $programTypes = ProgramType::active()->get();
        $categories = $this->getAvailableCategories();

        return view('admin.programs.create', compact('programTypes', 'categories'));
    }

    /**
     * Show the form for bulk creating programs.
     */
    public function adminBulkCreate()
    {
        $categories = $this->getAvailableCategories();

        return view('admin.programs.bulk-create', compact('categories'));
    }

    /**
     * Store a newly created program in storage.
     */
    public function adminStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|in:zakat,infaq,shadaqah,pilar',
            'target_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'target_amount', 'status']);
        $data['category'] = $this->resolveCategory($request->all());

        // Cek duplikasi nama + kategori
        if (Program::where('name', $data['name'])->where('category', $data['category'])->exists()) {
            return redirect()->back()->withInput()
                ->withErrors(['name' => 'Program dengan nama dan kategori ini sudah ada.']);
        }

        // Upload foto jika ada
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('programs', 'public');
        }

        Program::create($data);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program berhasil ditambahkan.');
    }

    /**
     * Store multiple programs at once.
     */
    public function adminStoreBulk(Request $request)
    {
        $request->validate([
            'programs' => 'required|array',
            'programs.*.name' => 'required|string|max:255',
            'programs.*.category' => 'required|string|in:zakat,infaq,shadaqah,pilar',
            'programs.*.target_amount' => 'nullable|numeric|min:0',
            'programs.*.status' => 'required|in:active,inactive',
        ]);

        foreach ($request->programs as $programData) {
            $data = [
                'name' => $programData['name'],
                'description' => $programData['description'] ?? '',
                'target_amount' => $programData['target_amount'] ?? 0,
                'status' => $programData['status'],
                'category' => $this->resolveCategory($programData),
            ];

            // Cek duplikasi
            if (Program::where('name', $data['name'])->where('category', $data['category'])->exists()) {
                return redirect()->back()->withInput()
                    ->withErrors([
                        'programs' => 'Program "' . $data['name'] . '" dengan kategori "' . $data['category'] . '" sudah ada.'
                    ]);
            }

            Program::create($data);
        }

        return redirect()->route('admin.programs.index')
            ->with('success', 'Semua program berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified program.
     */
    public function adminEdit(Program $program)
    {
        $programTypes = ProgramType::active()->get();
        $categories = $this->getAvailableCategories();

        $categoryType = 'pilar';
        $categorySubtype = $program->category;

        if (strpos($program->category, 'zakat-') === 0) {
            $categoryType = 'zakat';
            $categorySubtype = substr($program->category, 6);
        } elseif (strpos($program->category, 'infaq-') === 0) {
            $categoryType = 'infaq';
            $categorySubtype = substr($program->category, 6);
        } elseif (strpos($program->category, 'shadaqah-') === 0) {
            $categoryType = 'shadaqah';
            $categorySubtype = substr($program->category, 9);
        }

        return view('admin.programs.edit', compact('program', 'programTypes', 'categories', 'categoryType', 'categorySubtype'));
    }

    /**
     * Update the specified program in storage.
     */
    public function adminUpdate(Request $request, Program $program)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|in:zakat,infaq,shadaqah,pilar',
            'target_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'target_amount', 'status']);
        $data['category'] = $this->resolveCategory($request->all());

        // Upload foto baru dan hapus yang lama
        if ($request->hasFile('photo')) {
            if ($program->photo) {
                Storage::disk('public')->delete($program->photo);
            }
            $data['photo'] = $request->file('photo')->store('programs', 'public');
        }

        $program->update($data);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program berhasil diperbarui.');
    }

    /**
     * Remove the specified program from storage.
     */
    public function adminDestroy(Program $program)
    {
        if ($program->photo) {
            Storage::disk('public')->delete($program->photo);
        }

        $program->delete();

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program berhasil dihapus.');
    }

    /**
     * Resolve category based on type and custom input.
     */
    private function resolveCategory(array $data): string
    {
        switch ($data['category']) {
            case 'zakat':
                if (!empty($data['zakat_type'] ?? null) && $data['zakat_type'] === 'other' && !empty($data['zakat_type_other'] ?? null)) {
                    return 'zakat-' . Str::slug($data['zakat_type_other'], '-');
                }
                return 'zakat-' . ($data['zakat_type'] ?? 'umum');

            case 'infaq':
                if (!empty($data['infaq_type'] ?? null) && $data['infaq_type'] === 'other' && !empty($data['infaq_type_other'] ?? null)) {
                    return 'infaq-' . Str::slug($data['infaq_type_other'], '-');
                }
                return 'infaq-' . ($data['infaq_type'] ?? 'umum');

            case 'shadaqah':
                if (!empty($data['shadaqah_type'] ?? null) && $data['shadaqah_type'] === 'other' && !empty($data['shadaqah_type_other'] ?? null)) {
                    return 'shadaqah-' . Str::slug($data['shadaqah_type_other'], '-');
                }
                return 'shadaqah-' . ($data['shadaqah_type'] ?? 'umum');

            case 'pilar':
                if (!empty($data['pilar_category'] ?? null) && $data['pilar_category'] === 'other' && !empty($data['pilar_type_other'] ?? null)) {
                    return Str::slug($data['pilar_type_other'], '-');
                }
                return $data['pilar_category'] ?? 'umum';

            default:
                return 'umum';
        }
    }

    /**
     * Get available categories for programs.
     */
    private function getAvailableCategories(): array
    {
        return [
            'zakat' => [
                'umum' => 'Tidak Ada Jenis Khusus',
                'fitrah' => 'Zakat Fitrah',
                'mal' => 'Zakat Mal',
                'profesi' => 'Zakat Profesi',
                'pertanian' => 'Zakat Pertanian',
                'perdagangan' => 'Zakat Perdagangan',
            ],
            'infaq' => [
                'umum' => 'Tidak Ada Jenis Khusus',
                'masjid' => 'Infaq Masjid',
                'pendidikan' => 'Infaq Pendidikan',
                'kemanusiaan' => 'Infaq Kemanusiaan',
                'bencana' => 'Infaq Bencana',
                'sosial' => 'Infaq Sosial',
            ],
            'shadaqah' => [
                'umum' => 'Tidak Ada Jenis Khusus',
                'rutin' => 'Shadaqah Rutin',
                'jariyah' => 'Shadaqah Jariyah',
                'tetangga' => 'Shadaqah Tetangga',
                'pakaian' => 'Shadaqah Pakaian',
                'fidyah' => 'Fidyah',
            ],
            'pilar' => [
                'umum' => 'Tidak Ada Jenis Khusus',
                'pendidikan' => 'Pendidikan',
                'kesehatan' => 'Kesehatan',
                'ekonomi' => 'Ekonomi',
                'sosial-dakwah' => 'Sosial & Dakwah',
                'kemanusiaan' => 'Kemanusiaan',
                'lingkungan' => 'Lingkungan',
            ],
        ];
    }
}
