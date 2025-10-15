<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edukasi Zakat: {{ $topic }}</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #FF9800 0%, #FF5722 100%); color: white; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px;">💡 Edukasi Zakat</h1>
            <p style="margin: 5px 0 0; font-size: 16px;">SIPZIS - Sistem Informasi Pengelolaan Zakat</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <h2 style="color: #FF9800; margin-top: 0;">{{ $topic }}</h2>

            <p>Assalamu'alaikum wr. wb.,</p>

            <p><strong>{{ $recipientName }}</strong>,</p>

            <p>Mari kita tingkatkan pemahaman kita tentang zakat melalui edukasi berikut:</p>

            <div style="background: #fff3e0; border-left: 4px solid #FF9800; padding: 20px; margin: 20px 0; border-radius: 5px;">
                {!! $content !!}
            </div>

            <div style="background: #f5f5f5; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <h3 style="margin-top: 0; color: #333;">📌 Kesimpulan</h3>
                <p>Pemahaman yang benar tentang zakat akan membantu kita dalam menjalankan kewajiban ini dengan lebih baik dan tepat sasaran.</p>
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/calculator') }}" style="background: #FF9800; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 10px;">Kalkulator Zakat</a>
                <a href="{{ url('/faq') }}" style="background: #2196F3; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">FAQ Zakat</a>
            </div>

            <p style="background: #e3f2fd; padding: 15px; border-radius: 5px; border-left: 4px solid #2196F3;">
                <strong>Ingin tahu lebih banyak?</strong><br>
                Kunjungi halaman FAQ kami atau hubungi admin@sipzis.id untuk pertanyaan lebih lanjut.
            </p>

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