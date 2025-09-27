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

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zakatPayments()
    {
        return $this->hasMany(ZakatPayment::class);
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
