<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if($occasion == 'ramadhan')
        Selamat Ramadhan
        @elseif($occasion == 'idul_fitri')
        Taqabbalallahu Minna Wa Minkum
        @elseif($occasion == 'idul_adha')
        Selamat Idul Adha
        @else
        {{ ucfirst($occasion) }}
        @endif
    </title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="
            @if($occasion == 'ramadhan')
                background: linear-gradient(135deg, #0d8a00 0%, #2e7d32 100%);
            @elseif($occasion == 'idul_fitri')
                background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            @elseif($occasion == 'idul_adha')
                background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
            @else
                background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%);
            @endif
            color: white; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px;">
                @if($occasion == 'ramadhan')
                🌙 Selamat Ramadhan
                @elseif($occasion == 'idul_fitri')
                🌟 Taqabbalallahu Minna Wa Minkum
                @elseif($occasion == 'idul_adha')
                🐑 Selamat Idul Adha
                @else
                💌 {{ ucfirst($occasion) }}
                @endif
            </h1>
            <p style="margin: 5px 0 0; font-size: 16px;">SIPZIS - Sistem Informasi Pengelolaan Zakat</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <h2 style="
                @if($occasion == 'ramadhan')
                    color: #0d8a00;
                @elseif($occasion == 'idul_fitri')
                    color: #4CAF50;
                @elseif($occasion == 'idul_adha')
                    color: #f44336;
                @else
                    color: #9C27B0;
                @endif
                margin-top: 0;">
                @if($occasion == 'ramadhan')
                🌙 Bulan Penuh Berkah
                @elseif($occasion == 'idul_fitri')
                🌟 Hari Kemenangan
                @elseif($occasion == 'idul_adha')
                🐑 Hari Raya Kurban
                @else
                {{ ucfirst($occasion) }}
                @endif
            </h2>

            <p>Assalamu'alaikum wr. wb.,</p>

            <p><strong>{{ $recipientName }}</strong>,</p>

            <div style="
                @if($occasion == 'ramadhan')
                    background: #e8f5e9;
                    border-left: 4px solid #0d8a00;
                @elseif($occasion == 'idul_fitri')
                    background: #e8f5e9;
                    border-left: 4px solid #4CAF50;
                @elseif($occasion == 'idul_adha')
                    background: #ffebee;
                    border-left: 4px solid #f44336;
                @else
                    background: #f3e5f5;
                    border-left: 4px solid #9C27B0;
                @endif
                padding: 20px; margin: 20px 0; border-radius: 5px;">
                {!! $message !!}
            </div>

            @if($occasion == 'ramadhan')
            <div style="background: #fff3e0; padding: 15px; border-radius: 5px; border-left: 4px solid #FF9800; margin: 20px 0;">
                <h3 style="margin-top: 0; color: #FF9800;">🕌 Peluang Zakat di Bulan Suci</h3>
                <p>Ramadhan adalah waktu yang paling tepat untuk membersihkan harta melalui zakat. Jangan lewatkan kesempatan ini untuk mendapatkan keberkahan yang berlipat ganda.</p>
                <div style="text-align: center; margin-top: 15px;">
                    <a href="{{ url('/payments/create') }}" style="background: #FF9800; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Bayar Zakat Sekarang</a>
                </div>
            </div>
            @elseif($occasion == 'idul_fitri')
            <div style="background: #e3f2fd; padding: 15px; border-radius: 5px; border-left: 4px solid #2196F3; margin: 20px 0;">
                <h3 style="margin-top: 0; color: #2196F3;">🕌 Jangan Lupa Zakat Fitrah</h3>
                <p>Sebelum menunaikan ibadah shalat Id, pastikan Anda telah membayar zakat fitrah. Mari kita bantu saudara-saudara kita yang membutuhkan merasakan kebahagiaan Idul Fitri.</p>
                <div style="text-align: center; margin-top: 15px;">
                    <a href="{{ url('/payments/create?category=zakat-fitrah') }}" style="background: #2196F3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Bayar Zakat Fitrah</a>
                </div>
            </div>
            @elseif($occasion == 'idul_adha')
            <div style="background: #ffebee; padding: 15px; border-radius: 5px; border-left: 4px solid #f44336; margin: 20px 0;">
                <h3 style="margin-top: 0; color: #f44336;">🕌 Qurban dan Zakat</h3>
                <p>Idul Adha adalah momentum yang tepat untuk berqurban dan menunaikan zakat. Mari kita berbagi kebahagiaan dengan saudara-saudara kita yang membutuhkan.</p>
                <div style="text-align: center; margin-top: 15px;">
                    <a href="{{ url('/programs/qurban') }}" style="background: #f44336; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 10px;">Program Qurban</a>
                    <a href="{{ url('/payments/create') }}" style="background: #0d8a00; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Bayar Zakat</a>
                </div>
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
            <p><a href="{{ url('/unsubscribe') }}" style="color: #666; text-decoration: underline;">Berhenti berlangganan</a></p>
            <p>&copy; {{ date('Y') }} SIPZIS. All rights reserved.</p>
        </div>
    </div>
</body>

</html>