<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penyaluran Zakat Anda</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background: #9C27B0; color: white; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px;">SIPZIS</h1>
            <p style="margin: 5px 0 0; font-size: 16px;">Sistem Informasi Pengelolaan Zakat</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <h2 style="color: #9C27B0; margin-top: 0;">📈 Laporan Penyaluran Zakat Anda</h2>

            <p>Assalamu'alaikum wr. wb.,</p>

            <p><strong>{{ $muzakki->name }}</strong>,</p>

            <p>Terima kasih atas kepercayaan Anda dalam menyalurkan zakat melalui yayasan kami. Berikut adalah laporan penyaluran zakat Anda untuk program <strong>{{ $program->name }}</strong>:</p>

            <div style="background: #f3e5f5; border-left: 4px solid #9C27B0; padding: 15px; margin: 20px 0;">
                <h3 style="margin-top: 0; color: #9C27B0;">Ringkasan Penyaluran</h3>
                <p><strong>Nama Program:</strong> {{ $program->name }}</p>
                <p><strong>Total Donasi Anda:</strong> Rp {{ number_format($reportData['total_donation'] ?? 0, 0, ',', '.') }}</p>
                <p><strong>Total Disalurkan:</strong> Rp {{ number_format($reportData['total_distributed'] ?? 0, 0, ',', '.') }}</p>
                <p><strong>Sisa Dana:</strong> Rp {{ number_format(($reportData['total_donation'] ?? 0) - ($reportData['total_distributed'] ?? 0), 0, ',', '.') }}</p>
                <p><strong>Periode Laporan:</strong> {{ $reportData['period'] ?? 'Bulanan' }}</p>
            </div>

            <h3 style="color: #9C27B0;">Detail Penyaluran</h3>
            <ul style="background: #f9f9f9; padding: 15px; border-radius: 5px;">
                @if(isset($reportData['distributions']) && count($reportData['distributions']) > 0)
                @foreach($reportData['distributions'] as $distribution)
                <li style="margin-bottom: 10px;">
                    <strong>{{ $distribution['date'] ?? 'Tanggal' }}:</strong>
                    Rp {{ number_format($distribution['amount'] ?? 0, 0, ',', '.') }}
                    disalurkan kepada {{ $distribution['beneficiaries'] ?? 'para mustahik' }}
                    di {{ $distribution['location'] ?? 'wilayah yang membutuhkan' }}
                </li>
                @endforeach
                @else
                <li>Belum ada penyaluran untuk periode ini.</li>
                @endif
            </ul>

            <p>Donasi Anda telah membantu meningkatkan kesejahteraan para mustahik sesuai dengan ketentuan syariat Islam. Semoga menjadi Berkah dan pahala yang berlipat ganda untuk Anda.</p>

            <div style="background: #e8f5e9; padding: 15px; border-radius: 5px; border-left: 4px solid #0d8a00; margin: 20px 0;">
                <h3 style="margin-top: 0; color: #0d8a00;">📊 Dampak Donasi Anda</h3>
                <p>Donasi Anda telah membantu:</p>
                <ul>
                    <li>Menyediakan makanan untuk keluarga tidak mampu</li>
                    <li>Membantu biaya pengobatan pasien kurang mampu</li>
                    <li>Memberikan beasiswa kepada pelajar berprestasi kurang mampu</li>
                    <li>Membangun fasilitas umum untuk masyarakat</li>
                </ul>
            </div>

            <p style="margin-top: 30px;">Wallahu a'lam bishawab.</p>

            <p>Wassalamu'alaikum wr. wb.</p>

            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                <p style="margin: 0;"><strong>Yayasan SIPZIS</strong></p>
                <p style="margin: 5px 0 0;">Jl. Contoh Alamat No. 123</p>
                <p style="margin: 0;">Jakarta, Indonesia</p>
                <p style="margin: 5px 0 0;">Email: info@sipzis.id</p>
            </div>
        </div>

        <!-- Footer -->
        <div style="background: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #666;">
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
            <p>Jika Anda memiliki pertanyaan, silakan hubungi kami di admin@sipzis.id</p>
            <p>&copy; {{ date('Y') }} SIPZIS. All rights reserved.</p>
        </div>
    </div>
</body>

</html>