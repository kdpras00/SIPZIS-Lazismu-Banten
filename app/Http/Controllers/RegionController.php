<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegionController extends Controller
{
    // Semua negara
    public function countries()
    {
        $response = Http::get('https://restcountries.com/v3.1/all?fields=name,cca2');
        if ($response->failed()) {
            return response()->json([], 500);
        }

        $countries = collect($response->json())->map(function ($country) {
            return [
                'id' => $country['cca2'] ?? $country['name']['common'],
                'name' => $country['name']['common'],
            ];
        })->sortBy('name')->values();

        return response()->json($countries);
    }

    // Provinsi berdasarkan negara
    public function provinces($country)
    {
        if (strtolower($country) !== 'indonesia') {
            return response()->json([]);
        }

        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        return response()->json($response->json());
    }

    // Kota berdasarkan provinsi
    public function cities($provinceId)
    {
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$provinceId}.json");
        return response()->json($response->json());
    }

    // Kecamatan berdasarkan kota
    public function districts($cityId)
    {
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$cityId}.json");
        return response()->json($response->json());
    }

    // Kelurahan berdasarkan kecamatan
    public function villages($districtId)
    {
        $response = Http::get("https://www.emsifa.com/api-wilayah-indonesia/api/villages/{$districtId}.json");
        return response()->json($response->json());
    }

    // Validate postal code based on district and village
    public function validatePostalCode(Request $request)
    {
        $request->validate([
            'district' => 'required|string',
            'village' => 'nullable|string',
        ]);

        try {
            // Use the kodepos API to validate postal code
            $response = Http::get("https://kodepos.vercel.app/search?q=" . urlencode($request->district));

            if ($response->successful()) {
                $data = $response->json();

                if (!empty($data) && isset($data['data']) && is_array($data['data'])) {
                    // If village is specified, filter by village
                    if ($request->village) {
                        $filteredData = array_filter($data['data'], function ($item) use ($request) {
                            return isset($item['village']) &&
                                strtolower($item['village']) === strtolower($request->village);
                        });

                        if (!empty($filteredData)) {
                            $firstMatch = reset($filteredData);
                            return response()->json([
                                'success' => true,
                                'postal_code' => $firstMatch['code'],
                                'village' => $firstMatch['village'],
                                'district' => $firstMatch['district'],
                                'message' => 'Kode pos valid untuk kelurahan ' . $firstMatch['village']
                            ]);
                        }
                    }

                    // Get unique postal codes for the district
                    $postalCodes = collect($data['data'])->pluck('code')->unique()->values();
                    return response()->json([
                        'success' => true,
                        'postal_codes' => $postalCodes,
                        'suggestion' => $postalCodes->first() ?? null,
                        'message' => 'Berikut kode pos yang tersedia untuk kecamatan ' . $request->district
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Kode pos tidak ditemukan untuk kecamatan ini'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memvalidasi kode pos: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get postal code for a specific village
    public function getPostalCodeByVillage(Request $request)
    {
        $request->validate([
            'village' => 'required|string',
        ]);

        try {
            // Use the kodepos API to get postal code by village
            $response = Http::get("https://kodepos.vercel.app/search?q=" . urlencode($request->village));

            if ($response->successful()) {
                $data = $response->json();

                if (!empty($data) && is_array($data)) {
                    // Return the first match
                    return response()->json([
                        'success' => true,
                        'postal_code' => $data[0]['code'] ?? null,
                        'data' => $data[0]
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Kode pos tidak ditemukan untuk kelurahan ini'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil kode pos: ' . $e->getMessage()
            ], 500);
        }
    }
}
