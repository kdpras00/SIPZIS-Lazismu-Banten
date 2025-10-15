<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Penyaluran Dana</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background: #9C27B0; color: white; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px;">SIPZIS - Admin Notification</h1>
            <p style="margin: 5px 0 0; font-size: 16px;">Sistem Informasi Pengelolaan Zakat</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <h2 style="color: #9C27B0; margin-top: 0;">📦 Pengingat Penyaluran Dana</h2>

            <p>Assalamu'alaikum wr. wb.</p>

            <p>Ini adalah pengingat untuk menyalurkan dana program berikut:</p>

            <div style="background: #f9f9f9; border-left: 4px solid #9C27B0; padding: 15px; margin: 20px 0;">
                <p><strong>Nama Program:</strong> {{ $programName }}</p>
                <p><strong>Jumlah Dana Tersedia:</strong> Rp {{ number_format($distribution->amount, 0, ',', '.') }}</p>
                <p><strong>Lokasi Penyaluran:</strong> {{ $distribution->location ?? 'Wilayah yang membutuhkan' }}</p>
                <p><strong>Tanggal Penyaluran:</strong> {{ $distribution->distribution_date ? $distribution->distribution_date->format('d F Y') : 'Segera' }}</p>
                <p><strong>Jumlah Mustahik:</strong> {{ $distribution->beneficiaries_count ?? 'Tidak ditentukan' }}</p>
            </div>

            <p>Silakan lakukan penyaluran dana sesuai dengan rencana yang telah ditetapkan. Pastikan untuk mendokumentasikan proses penyaluran dan memperbarui status di sistem setelah penyaluran selesai.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/admin/distributions/' . $distribution->id) }}" style="background: #9C27B0; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">Lihat Detail Penyaluran</a>
            </div>

            <p style="background: #f3e5f5; padding: 15px; border-radius: 5px; border-left: 4px solid #9C27B0;">
                <strong>Instruksi:</strong><br>
                1. Siapkan dana sesuai jumlah yang tercantum<br>
                2. Lakukan penyaluran sesuai lokasi dan jadwal<br>
                3. Dokumentasikan proses penyaluran<br>
                4. Perbarui status penyaluran di sistem
            </p>

            <p style="margin-top: 30px;">Wallahu a'lam bishawab.</p>

            <p>Wassalamu'alaikum wr. wb.</p>

            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                <p style="margin: 0;"><strong>Yayasan SIPZIS - Sistem Notifikasi</strong></p>
                <p style="margin: 5px 0 0;">Email ini dikirim secara otomatis oleh sistem</p>
            </div>
        </div>

        <!-- Footer -->
        <div style="background: #f4f4f4; padding: 15px; text-align: center; font-size: 12px; color: #666;">
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} SIPZIS. All rights reserved.</p>
        </div>
    </div>
</body>

</html>