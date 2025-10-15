<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'muzakki_id',
        'type',
        'title',
        'message',
        'icon',
        'color',
        'is_read',
        'read_at',
        'notifiable_type',
        'notifiable_id',
        'data'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'data' => 'array'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function muzakki()
    {
        return $this->belongsTo(Muzakki::class);
    }

    public function notifiable()
    {
        return $this->morphTo();
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForMuzakki($query, $muzakkiId)
    {
        return $query->where('muzakki_id', $muzakkiId);
    }

    public function scopeByTypes($query, $types)
    {
        return $query->whereIn('type', $types);
    }

    // Methods
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        }
    }

    public function markAsUnread()
    {
        if ($this->is_read) {
            $this->update([
                'is_read' => false,
                'read_at' => null
            ]);
        }
    }

    public function getIconClassAttribute()
    {
        $icons = [
            'payment' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'distribution' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3',
            'program' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
            'account' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
            'reminder' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
            'message' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'
        ];

        return $icons[$this->type] ?? $icons['message'];
    }

    public function getColorClassAttribute()
    {
        $colors = [
            'payment' => 'green',
            'distribution' => 'blue',
            'program' => 'purple',
            'account' => 'yellow',
            'reminder' => 'orange',
            'message' => 'indigo'
        ];

        return $colors[$this->type] ?? $colors['message'];
    }

    // Group notifications by type
    public static function groupByType($notifications)
    {
        return $notifications->groupBy('type');
    }

    // Get notification types with counts
    public static function getTypesWithCounts($userId = null, $muzakkiId = null)
    {
        $query = self::select('type')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('type');

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($muzakkiId) {
            $query->where('muzakki_id', $muzakkiId);
        }

        return $query->get()->keyBy('type');
    }

    // Static methods for creating different types of notifications
    public static function createPaymentNotification($muzakki, $payment, $status)
    {
        $messages = [
            'completed' => 'Pembayaran ' . ucfirst(str_replace('-', ' ', $payment->program_category)) . ' Anda telah berhasil diverifikasi.',
            'failed' => 'Pembayaran Anda gagal diproses, silakan coba kembali.',
            'pending' => 'Menunggu konfirmasi pembayaran melalui ' . ($payment->payment_method ?? 'transfer bank') . '.'
        ];

        $titles = [
            'completed' => '✅ Pembayaran Berhasil',
            'failed' => '❌ Pembayaran Gagal',
            'pending' => '⏳ Menunggu Konfirmasi'
        ];

        return self::create([
            'muzakki_id' => $muzakki->id,
            'user_id' => $muzakki->user_id,
            'type' => 'payment',
            'title' => $titles[$status],
            'message' => $messages[$status],
            'notifiable_type' => ZakatPayment::class,
            'notifiable_id' => $payment->id,
            'data' => [
                'payment_id' => $payment->id,
                'status' => $status,
                'amount' => $payment->paid_amount,
                'program_category' => $payment->program_category
            ]
        ]);
    }

    public static function createDistributionNotification($muzakki, $distribution)
    {
        $message = 'Zakat Anda telah disalurkan kepada mustahik di wilayah ' . ($distribution->location ?? 'yang membutuhkan') . '.';

        return self::create([
            'muzakki_id' => $muzakki->id,
            'user_id' => $muzakki->user_id,
            'type' => 'distribution',
            'title' => '📬 Zakat Telah Disalurkan',
            'message' => $message,
            'notifiable_type' => ZakatDistribution::class,
            'notifiable_id' => $distribution->id,
            'data' => [
                'distribution_id' => $distribution->id,
                'location' => $distribution->location,
                'amount' => $distribution->amount
            ]
        ]);
    }

    public static function createProgramNotification($user, $program, $eventType)
    {
        $messages = [
            'event' => 'Kajian Jumat besok pukul 09.00 di Aula Utama.',
            'program' => 'Program Sedekah Subuh kembali dibuka minggu ini.'
        ];

        $titles = [
            'event' => '📅 Kegiatan Mendatang',
            'program' => '🕌 Program Baru'
        ];

        return self::create([
            'user_id' => $user->id,
            'type' => 'program',
            'title' => $titles[$eventType],
            'message' => $messages[$eventType],
            'notifiable_type' => Program::class,
            'notifiable_id' => $program->id,
            'data' => [
                'program_id' => $program->id,
                'event_type' => $eventType
            ]
        ]);
    }

    public static function createAccountNotification($user, $eventType)
    {
        // Ambil profil muzakki yang terhubung dengan user
        $muzakki = $user->muzakki;

        $messages = [
            'profile' => 'Selamat datang! Lengkapi profil Anda untuk mempermudah transaksi donasi.',
            'password' => 'Kata sandi Anda berhasil diubah.'
        ];

        $titles = [
            'profile' => '👋 Selamat Datang',
            'password' => '🔒 Perubahan Kata Sandi'
        ];

        return self::create([
            'user_id' => $user->id,
            'muzakki_id' => $muzakki ? $muzakki->id : null, // <-- INI PERBAIKANNYA
            'type' => 'account',
            'title' => $titles[$eventType],
            'message' => $messages[$eventType],
            'data' => [
                'event_type' => $eventType
            ]
        ]);
    }
    public static function createReminderNotification($muzakki, $reminderType)
    {
        $messages = [
            'zakat' => 'Sudah waktunya membayar zakat penghasilan bulan ini.',
            'balance' => 'Saldo zakat Anda tersisa Rp200.000, ingin disalurkan?'
        ];

        $titles = [
            'zakat' => '🕋 Waktu Zakat',
            'balance' => '💡 Saldo Zakat'
        ];

        return self::create([
            'muzakki_id' => $muzakki->id,
            'user_id' => $muzakki->user_id,
            'type' => 'reminder',
            'title' => $titles[$reminderType],
            'message' => $messages[$reminderType],
            'data' => [
                'reminder_type' => $reminderType
            ]
        ]);
    }

    public static function createMessageNotification($user, $message, $sender = 'Admin')
    {
        return self::create([
            'user_id' => $user->id,
            'type' => 'message',
            'title' => '📩 Pesan Baru',
            'message' => $sender . ': ' . $message,
            'data' => [
                'sender' => $sender,
                'message' => $message
            ]
        ]);
    }
}
