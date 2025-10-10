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
        $programs = Program::with('programType')->orderBy('category')->orderBy('name')->get();

        // Group programs by category for easier display
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
     * Show the form for creating programs in bulk.
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

        // ✅ Cek kategori utama & subkategori
        switch ($request->category) {
            case 'zakat':
                if ($request->zakat_type === 'other' && $request->filled('zakat_type_other')) {
                    $data['category'] = 'zakat-' . Str::slug($request->zakat_type_other, '-');
                } else {
                    $data['category'] = 'zakat-' . ($request->zakat_type ?? 'umum');
                }
                break;

            case 'infaq':
                if ($request->infaq_type === 'other' && $request->filled('infaq_type_other')) {
                    $data['category'] = 'infaq-' . Str::slug($request->infaq_type_other, '-');
                } else {
                    $data['category'] = 'infaq-' . ($request->infaq_type ?? 'umum');
                }
                break;

            case 'shadaqah':
                if ($request->shadaqah_type === 'other' && $request->filled('shadaqah_type_other')) {
                    $data['category'] = 'shadaqah-' . Str::slug($request->shadaqah_type_other, '-');
                } else {
                    $data['category'] = 'shadaqah-' . ($request->shadaqah_type ?? 'umum');
                }
                break;

            case 'pilar':
                if ($request->pilar_category === 'other' && $request->filled('pilar_type_other')) {
                    $data['category'] = Str::slug($request->pilar_type_other, '-');
                } else {
                    $data['category'] = $request->pilar_category ?? 'umum';
                }
                break;
        }

        // Upload foto
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('programs', 'public');
        }

        Program::create($data);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program created successfully.');
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
            ];

            // Set category based on selection
            if ($programData['category'] === 'zakat') {
                $data['category'] = 'zakat-' . ($programData['zakat_type'] ?? 'umum');
            } elseif ($programData['category'] === 'infaq') {
                $data['category'] = 'infaq-' . ($programData['infaq_type'] ?? 'umum');
            } elseif ($programData['category'] === 'shadaqah') {
                $data['category'] = 'shadaqah-' . ($programData['shadaqah_type'] ?? 'umum');
            } else {
                $data['category'] = $programData['pilar_category'] ?? 'umum';
            }

            Program::create($data);
        }

        return redirect()->route('admin.programs.index')->with('success', 'All programs created successfully.');
    }

    /**
     * Show the form for editing the specified program.
     */
    public function adminEdit(Program $program)
    {
        $programTypes = ProgramType::active()->get();
        $categories = $this->getAvailableCategories();

        // Extract category type and subtype
        $categoryType = '';
        $categorySubtype = '';

        if (strpos($program->category, 'zakat-') === 0) {
            $categoryType = 'zakat';
            $categorySubtype = substr($program->category, 6);
        } elseif (strpos($program->category, 'infaq-') === 0) {
            $categoryType = 'infaq';
            $categorySubtype = substr($program->category, 6);
        } elseif (strpos($program->category, 'shadaqah-') === 0) {
            $categoryType = 'shadaqah';
            $categorySubtype = substr($program->category, 9);
        } else {
            $categoryType = 'pilar';
            $categorySubtype = $program->category;
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

        // ✅ Periksa apakah user memilih "Lainnya"
        switch ($request->category) {
            case 'zakat':
                if ($request->zakat_type === 'other' && $request->filled('zakat_type_other')) {
                    $data['category'] = 'zakat-' . Str::slug($request->zakat_type_other, '-');
                } else {
                    $data['category'] = 'zakat-' . ($request->zakat_type ?? 'umum');
                }
                break;

            case 'infaq':
                if ($request->infaq_type === 'other' && $request->filled('infaq_type_other')) {
                    $data['category'] = 'infaq-' . Str::slug($request->infaq_type_other, '-');
                } else {
                    $data['category'] = 'infaq-' . ($request->infaq_type ?? 'umum');
                }
                break;

            case 'shadaqah':
                if ($request->shadaqah_type === 'other' && $request->filled('shadaqah_type_other')) {
                    $data['category'] = 'shadaqah-' . Str::slug($request->shadaqah_type_other, '-');
                } else {
                    $data['category'] = 'shadaqah-' . ($request->shadaqah_type ?? 'umum');
                }
                break;

            case 'pilar':
                if ($request->pilar_category === 'other' && $request->filled('pilar_type_other')) {
                    $data['category'] = Str::slug($request->pilar_type_other, '-');
                } else {
                    $data['category'] = $request->pilar_category ?? 'umum';
                }
                break;
        }

        // Ganti foto kalau diupload baru
        if ($request->hasFile('photo')) {
            if ($program->photo) {
                Storage::disk('public')->delete($program->photo);
            }
            $data['photo'] = $request->file('photo')->store('programs', 'public');
        }

        $program->update($data);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program updated successfully.');
    }

    /**
     * Remove the specified program from storage.
     */
    public function adminDestroy(Program $program)
    {
        // Delete photo if exists
        if ($program->photo) {
            Storage::disk('public')->delete($program->photo);
        }

        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Program deleted successfully.');
    }

    /**
     * Get available categories for programs.
     */
    private function getAvailableCategories()
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
            ]
        ];
    }
}
