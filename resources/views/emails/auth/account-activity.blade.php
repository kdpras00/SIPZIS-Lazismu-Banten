<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if($activityType == 'login')
        Aktivitas Login Baru
        @elseif($activityType == 'profile_update')
        Profil Anda Diperbarui
        @elseif($activityType == 'password_change')
        Kata Sandi Diubah
        @else
        Aktivitas Akun Anda
        @endif
    </title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <!-- Header -->
        <div style="
            @if($activityType == 'login')
                background: linear-gradient(135deg, #4CAF50 0%, #388E3C 100%);
            @elseif($activityType == 'profile_update')
                background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
            @elseif($activityType == 'password_change')
                background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%);
            @else
                background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
            @endif
            color: white; padding: 20px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px;">
                @if($activityType == 'login')
                📬 Aktivitas Login
                @elseif($activityType == 'profile_update')
                🔄 Profil Diperbarui
                @elseif($activityType == 'password_change')
                🔑 Kata Sandi Diubah
                @else
                📬 Aktivitas Akun
                @endif
            </h1>
            <p style="margin: 5px 0 0; font-size: 16px;">SIPZIS - Sistem Informasi Pengelolaan Zakat</p>
        </div>

        <!-- Content -->
        <div style="padding: 30px;">
            <h2 style="
                @if($activityType == 'login')
                    color: #4CAF50;
                @elseif($activityType == 'profile_update')
                    color: #FF9800;
                @elseif($activityType == 'password_change')
                    color: #9C27B0;
                @else
                    color: #2196F3;
                @endif
                margin-top: 0;">
                @if($activityType == 'login')
                Aktivitas Login Baru di Akun Anda
                @elseif($activityType == 'profile_update')
                Profil Anda Telah Diperbarui
                @elseif($activityType == 'password_change')
                Kata Sandi Anda Telah Diubah
                @else
                Aktivitas Akun Anda
                @endif
            </h2>

            <p>Assalamu'alaikum wr. wb.,</p>

            <p><strong>{{ $user->name }}</strong>,</p>

            @if($activityType == 'login')
            <p>Kami ingin memberitahukan bahwa ada aktivitas login baru di akun Anda:</p>

            <div style="background: #e8f5e9; border-left: 4px solid #4CAF50; padding: 20px; margin: 20px 0; border-radius: 5px;">
                <h3 style="margin-top: 0; color: #4CAF50;">📋 Detail Login</h3>
                <p><strong>Waktu:</strong> {{ $activityDetails['time'] ?? now()->format('d F Y H:i') }}</p>
                <p><strong>IP Address:</strong> {{ $activityDetails['ip'] ?? 'Tidak tersedia' }}</p>
                <p><strong>Lokasi:</strong> {{ $activityDetails['location'] ?? 'Tidak tersedia' }}</p>
                <p><strong>Perangkat:</strong> {{ $activityDetails['device'] ?? 'Tidak tersedia' }}</p>
            </div>

            <p style="background: #fff3e0; padding: 15px; border-radius: 5px; border-left: 4px solid #FF9800;">
                <strong>⚠️ Perhatian:</strong><br>
                Jika Anda tidak mengenali aktivitas login ini, segera ubah password Anda dan hubungi admin@sipzis.id
            </p>
            @elseif($activityType == 'profile_update')
            <p>Profil Anda telah diperbarui dengan informasi berikut:</p>

            <div style="background: #fff3e0; border-left: 4px solid #FF9800; padding: 20px; margin: 20px 0; border-radius: 5px;">
                <h3 style="margin-top: 0; color: #FF9800;">📋 Perubahan Profil</h3>
                @if(isset($activityDetails['changes']))
                <ul>
                    @foreach($activityDetails['changes'] as $field => $value)
                    <li style="margin-bottom: 10px;"><strong>{{ ucfirst(str_replace('_', ' ', $field)) }}:</strong> {{ $value }}</li>
                    @endforeach
                </ul>
                @else
                <p>Profil Anda telah diperbarui</p>
                @endif
            </div>
            @elseif($activityType == 'password_change')
            <p>Kata sandi Anda telah berhasil diubah. Jika Anda tidak melakukan perubahan ini, segera hubungi admin@sipzis.id</p>

            <div style="background: #f3e5f5; border-left: 4px solid #9C27B0; padding: 20px; margin: 20px 0; border-radius: 5px;">
                <h3 style="margin-top: 0; color: #9C27B0;">🔑 Keamanan Akun</h3>
                <ul>
                    <li style="margin-bottom: 10px;">Gunakan password yang kuat dan unik</li>
                    <li style="margin-bottom: 10px;">Jangan berbagi password dengan orang lain</li>
                    <li style="margin-bottom: 10px;">Aktifkan autentikasi dua faktor jika tersedia</li>
                </ul>
            </div>
            @else
            <p>Ada aktivitas baru di akun Anda:</p>

            <div style="background: #e3f2fd; border-left: 4px solid #2196F3; padding: 20px; margin: 20px 0; border-radius: 5px;">
                <h3 style="margin-top: 0; color: #2196F3;">📋 Detail Aktivitas</h3>
                @if(isset($activityDetails['message']))
                <p>{{ $activityDetails['message'] }}</p>
                @else
                <p>Aktivitas akun Anda telah diperbarui</p>
                @endif
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
            <p>&copy; {{ date('Y') }} SIPZIS. All rights reserved.</p>
        </div>
    </div>
</body>

</html>