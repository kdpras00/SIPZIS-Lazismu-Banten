<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Campaign;
use App\Models\Program;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campaigns = [
            [
                'title' => 'Bantuan Pendidikan Anak Yatim',
                'description' => 'Program bantuan pendidikan untuk anak-anak yatim piatu yang kurang mampu. Dana akan digunakan untuk biaya sekolah, buku, seragam, dan kebutuhan pendidikan lainnya.',
                'program_category' => 'pendidikan',
                'target_amount' => 50000000,
                'collected_amount' => 35000000,
                'photo' => null,
                'status' => 'published'
            ],
            [
                'title' => 'Operasi Jantung Gratis',
                'description' => 'Program bantuan operasi jantung gratis untuk masyarakat kurang mampu yang membutuhkan perawatan medis khusus.',
                'program_category' => 'kesehatan',
                'target_amount' => 100000000,
                'collected_amount' => 75000000,
                'photo' => null,
                'status' => 'published'
            ],
            [
                'title' => 'Modal Usaha UKM',
                'description' => 'Program pemberian modal usaha untuk Usaha Kecil Menengah (UKM) yang terdampak pandemi dan membutuhkan bantuan modal kerja.',
                'program_category' => 'ekonomi',
                'target_amount' => 75000000,
                'collected_amount' => 45000000,
                'photo' => null,
                'status' => 'published'
            ],
            [
                'title' => 'Bantuan Bencana Alam',
                'description' => 'Program bantuan darurat untuk korban bencana alam seperti banjir, tanah longsor, dan kebakaran hutan.',
                'program_category' => 'kemanusiaan',
                'target_amount' => 150000000,
                'collected_amount' => 98000000,
                'photo' => null,
                'status' => 'published'
            ],
            [
                'title' => 'Penanaman 1000 Pohon',
                'description' => 'Program penghijauan dengan menanam 1000 pohon di area kritis untuk menjaga kelestarian lingkungan.',
                'program_category' => 'lingkungan',
                'target_amount' => 25000000,
                'collected_amount' => 18000000,
                'photo' => null,
                'status' => 'published'
            ],
            [
                'title' => 'Program Dakwah Keliling',
                'description' => 'Program dakwah keliling dengan mobil dakwah untuk menyebarkan pesan Islam ke pelosok desa dan daerah terpencil.',
                'program_category' => 'sosial-dakwah',
                'target_amount' => 30000000,
                'collected_amount' => 12000000,
                'photo' => null,
                'status' => 'published'
            ]
        ];

        foreach ($campaigns as $campaignData) {
            // Find the program that matches the campaign's category
            $program = Program::where('category', $campaignData['program_category'])->first();

            // Add program_id to the campaign data
            if ($program) {
                $campaignData['program_id'] = $program->id;
            }

            Campaign::create($campaignData);
        }
    }
}
