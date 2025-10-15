<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if($reminderType == 'zakat')
        Pengingat Zakat Tahunan
        @else
        Kami Rindu Kehadiran Anda Kembali
        @endif
    </title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="
            @if($reminderType == 'zakat')
                background: #0d8a00;
            @else
                background: #2196F3;
            @endif
            color: white; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px;">SIPZIS</h1>
            <p style="margin: 5px 0 0; font-size: 16px;">Sistem Informasi Pengelolaan Zakat</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <h2 style="
                @if($reminderType == 'zakat')
                    color: #0d8a00;
                @else
                    color: #2196F3;
                @endif
                margin-top: 0;">
                @if($reminderType == 'zakat')
                📅 Pengingat Zakat Tahunan
                @else
                🤝 Kami Rindu Kehadiran Anda Kembali
                @endif
            </h2>

            <p>Assalamu'alaikum wr. wb.,</p>

            <p><strong>{{ $muzakki->name }}</strong>,</p>

            @if($reminderType == 'zakat')
            <p>Saat ini sudah memasuki waktu haul (satu tahun) sejak terakhir kali Anda membayar zakat. Sebagai pengingat, zakat merupakan kewajiban bagi setiap muslim yang memenuhi syarat.</p>

            <div style="background: #e8f5e9; border-left: 4px solid #0d8a00; padding: 15px; margin: 20px 0;">
                <h3 style="margin-top: 0; color: #0d8a00;">Waktunya Membayar Zakat!</h3>
                <p>Zakat yang Anda bayarkan akan menjadi sarana untuk membersihkan harta dan membantu sesama yang membutuhkan.</p>
                <p>Anda dapat menghitung kembali zakat Anda menggunakan kalkulator zakat di website kami.</p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/payments/create') }}" style="background: #0d8a00; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">Bayar Zakat Sekarang</a>
            </div>
            @else
            <p>Kami merindukan kehadiran Anda kembali dalam program zakat dan donasi kami. Sudah beberapa waktu terakhir Anda tidak melakukan donasi, dan kami berharap dapat kembali melayani Anda.</p>

            <div style="background: #e3f2fd; border-left: 4px solid #2196F3; padding: 15px; margin: 20px 0;">
                <h3 style="margin-top: 0; color: #2196F3;">Kami Butuh Anda!</h3>
                <p>Kehadiran dan kontribusi Anda sangat berarti bagi kami dan para mustahik yang membutuhkan bantuan.</p>
                <p>Bersama-sama kita bisa membuat perbedaan yang nyata dalam kehidupan banyak orang.</p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/payments/create') }}" style="background: #2196F3; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">Berdonasi Sekarang</a>
            </div>
            @endif

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
            <p>
                @if($reminderType == 'zakat')
                Jika Anda sudah membayar zakat, abaikan email ini.
                @else
                Jika Anda tidak ingin menerima email ini lagi, silakan ubah preferensi notifikasi di akun Anda.
                @endif
            </p>
            <p>&copy; {{ date('Y') }} SIPZIS. All rights reserved.</p>
        </div>
    </div>
</body>

</html>