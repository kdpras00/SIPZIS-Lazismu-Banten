<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Muzakki extends Model
{
    use HasFactory;

    protected $table = 'muzakki';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'nik',
        'gender',
        'address',
        'city',
        'province',
        'postal_code',
        'occupation',
        'monthly_income',
        'date_of_birth',
        'is_active',
        'user_id'
    ];

    protected $casts = [
        'monthly_income' => 'decimal:2',
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    // Add a method to find or create a muzakki record
    public static function findOrCreate(array $attributes)
    {
        // First try to find by email
        $muzakki = self::where('email', $attributes['email'])->first();

        if ($muzakki) {
            // Update existing record with new data (but preserve existing data if not provided)
            $updateData = [];
            foreach ($attributes as $key => $value) {
                // Only update if value is provided or if the field is currently null
                if ($value !== null || $muzakki->$key === null) {
                    $updateData[$key] = $value;
                }
            }
            $muzakki->update($updateData);
            return $muzakki;
        }

        // Create new record if not found
        return self::create($attributes);
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zakatPayments()
    {
        return $this->hasMany(ZakatPayment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Methods
    public function getTotalZakatPaidAttribute()
    {
        return $this->zakatPayments()->where('status', 'completed')->sum('paid_amount');
    }

    public function getZakatPaymentsByYear($year = null)
    {
        $year = $year ?: date('Y');
        return $this->zakatPayments()
            ->whereYear('payment_date', $year)
            ->where('status', 'completed')
            ->get();
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    // Get count of pending zakat payments
    public function getPendingPaymentsCountAttribute()
    {
        return $this->zakatPayments()->pending()->count();
    }

    // Get count of all zakat payments
    public function getTotalPaymentsCountAttribute()
    {
        return $this->zakatPayments()->count();
    }

    // Get count of unread notifications
    public function getUnreadNotificationsCountAttribute()
    {
        return $this->notifications()->unread()->count();
    }

    // Get latest notifications
    public function getLatestNotifications($limit = 10)
    {
        return $this->notifications()->latest()->limit($limit)->get();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByOccupation($query, $occupation)
    {
        return $query->where('occupation', $occupation);
    }
}
