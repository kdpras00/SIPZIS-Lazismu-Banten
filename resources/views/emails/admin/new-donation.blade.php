<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi Baru Masuk</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background: #2196F3; color: white; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px;">SIPZIS - Admin Notification</h1>
            <p style="margin: 5px 0 0; font-size: 16px;">Sistem Informasi Pengelolaan Zakat</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <h2 style="color: #2196F3; margin-top: 0;">🔔 Donasi Baru Masuk</h2>

            <p>Assalamu'alaikum wr. wb.</p>

            <p>Ada donasi baru yang masuk ke sistem. Berikut detailnya:</p>

            <div style="background: #f9f9f9; border-left: 4px solid #2196F3; padding: 15px; margin: 20px 0;">
                <p><strong>Kode Pembayaran:</strong> {{ $payment->payment_code }}</p>
                <p><strong>Nama Donatur:</strong> {{ $donorName }}</p>
                <p><strong>Email Donatur:</strong> {{ $payment->muzakki->email ?? '-' }}</p>
                <p><strong>Jumlah Donasi:</strong> Rp {{ number_format($payment->paid_amount, 0, ',', '.') }}</p>
                <p><strong>Tujuan Program:</strong> {{ ucfirst(str_replace('-', ' ', $payment->program_category)) }}</p>
                <p><strong>Waktu Transaksi:</strong> {{ $payment->payment_date->format('d F Y H:i') }}</p>
                <p><strong>Metode Pembayaran:</strong> {{ $payment->payment_method ?? 'Transfer Bank' }}</p>
                <p><strong>Status:</strong>
                    @if($payment->status == 'completed')
                    <span style="color: #0d8a00; font-weight: bold;">Berhasil</span>
                    @elseif($payment->status == 'pending')
                    <span style="color: #ff9800; font-weight: bold;">Menunggu Konfirmasi</span>
                    @else
                    <span style="color: #f44336; font-weight: bold;">Gagal</span>
                    @endif
                </p>
            </div>

            <p>Silakan periksa sistem untuk memverifikasi dan memproses donasi ini sesuai dengan prosedur yang berlaku.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/admin/payments/' . $payment->id) }}" style="background: #2196F3; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">Lihat Detail Donasi</a>
            </div>

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