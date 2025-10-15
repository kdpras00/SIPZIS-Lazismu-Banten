<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter SIPZIS</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px;">SIPZIS Newsletter</h1>
            <p style="margin: 5px 0 0; font-size: 16px;">Sistem Informasi Pengelolaan Zakat</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <h2 style="color: #667eea; margin-top: 0;">🌟 Newsletter Terbaru</h2>

            <p>Assalamu'alaikum wr. wb.,</p>

            <p><strong>{{ $recipientName }}</strong>,</p>

            <p>Terima kasih telah menjadi bagian dari komunitas SIPZIS. Berikut adalah update terbaru dari kami:</p>

            <div style="background: #f0f4ff; border-left: 4px solid #667eea; padding: 20px; margin: 20px 0; border-radius: 5px;">
                {!! $content !!}
            </div>

            <div style="background: #e8f5e9; padding: 15px; border-radius: 5px; border-left: 4px solid #0d8a00; margin: 20px 0;">
                <h3 style="margin-top: 0; color: #0d8a00;">🎯 Program Unggulan Bulan Ini</h3>
                <ul>
                    <li style="margin-bottom: 10px;">Program Zakat untuk Anak Yatim</li>
                    <li style="margin-bottom: 10px;">Bantuan Kemanusiaan untuk Korban Bencana</li>
                    <li style="margin-bottom: 10px;">Beasiswa Pendidikan untuk Pelajar Kurang Mampu</li>
                </ul>
                <div style="text-align: center; margin-top: 15px;">
                    <a href="{{ url('/programs') }}" style="background: #0d8a00; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Lihat Semua Program</a>
                </div>
            </div>

            <p>Kami berharap update ini bermanfaat bagi Anda. Jika Anda memiliki pertanyaan atau saran, jangan ragu untuk menghubungi kami.</p>

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
            <p><a href="{{ url('/unsubscribe') }}" style="color: #666; text-decoration: underline;">Berhenti berlangganan</a></p>
            <p>&copy; {{ date('Y') }} SIPZIS. All rights reserved.</p>
        </div>
    </div>
</body>

</html>