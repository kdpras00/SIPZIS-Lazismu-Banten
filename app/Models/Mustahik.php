<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mustahik extends Model
{
    use HasFactory;

    protected $table = 'mustahik';

    protected $fillable = [
        'name',
        'nik',
        'gender',
        'address',
        'city',
        'province',
        'phone',
        'date_of_birth',
        'category',
        'category_description',
        'family_status',
        'family_members',
        'monthly_income',
        'income_source',
        'verification_status',
        'verification_notes',
        'verified_at',
        'verified_by',
        'is_active'
    ];

    protected $casts = [
        'monthly_income' => 'decimal:2',
        'date_of_birth' => 'date',
        'verified_at' => 'date',
        'is_active' => 'boolean',
    ];

    // Constants for categories (8 Asnaf)
    public const CATEGORIES = [
        'fakir' => 'Fakir - Orang yang tidak memiliki harta dan pekerjaan',
        'miskin' => 'Miskin - Orang yang memiliki harta/pekerjaan tapi tidak mencukupi',
        'amil' => 'Amil - Petugas yang mengumpulkan dan membagikan zakat',
        'muallaf' => 'Muallaf - Orang yang baru masuk Islam atau yang hatinya perlu diperkuat',
        'riqab' => 'Riqab - Memerdekakan budak atau membebaskan muslim dari tawanan',
        'gharim' => 'Gharim - Orang yang berutang untuk kepentingan yang tidak maksiat',
        'fisabilillah' => 'Fi Sabilillah - Untuk kepentingan umum di jalan Allah',
        'ibnu_sabil' => 'Ibnu Sabil - Musafir yang kehabisan bekal dalam perjalanan'
    ];

    // Relationships
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function zakatDistributions()
    {
        return $this->hasMany(ZakatDistribution::class);
    }

    // Methods
    public function getTotalZakatReceivedAttribute()
    {
        return $this->zakatDistributions()->sum('amount');
    }

    public function getCategoryLabelAttribute()
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    public function getLastDistributionAttribute()
    {
        return $this->zakatDistributions()->latest('distribution_date')->first();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopePending($query)
    {
        return $query->where('verification_status', 'pending');
    }
}
