<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Campaign extends Model
{
    protected $fillable = [
        'title',
        'description',
        'program_category',
        'program_id',
        'target_amount',
        'collected_amount',
        'photo',
        'status',
        'end_date'
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
        'end_date' => 'date'
    ];

    // Relationships
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function zakatPayments()
    {
        return $this->hasMany(ZakatPayment::class, 'program_category', 'program_category')
            ->whereNotNull('program_category')
            ->where('status', 'completed');
    }

    public function zakatDistributions()
    {
        return $this->hasMany(ZakatDistribution::class, 'program_name', 'program_category');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if (empty($this->photo)) {
            return asset('img/masjid.webp');
        }

        if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }

        return asset('storage/' . ltrim($this->photo, '/'));
    }

    public function getCollectedAmountAttribute()
    {
        return $this->zakatPayments()->sum('paid_amount');
    }

    public function getDistributedAmountAttribute()
    {
        return $this->zakatDistributions()->sum('amount');
    }

    public function getNetCollectedAmountAttribute()
    {
        return max(0, $this->collected_amount - $this->distributed_amount);
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount <= 0) {
            return 0;
        }

        return min(100, ($this->net_collected_amount / $this->target_amount) * 100);
    }

    public function getFormattedTargetAmountAttribute()
    {
        return 'Rp ' . number_format($this->target_amount, 0, ',', '.');
    }

    public function getFormattedCollectedAmountAttribute()
    {
        return 'Rp ' . number_format($this->net_collected_amount, 0, ',', '.');
    }

    public function getDonorsCountAttribute()
    {
        return $this->zakatPayments()->count();
    }

    /**
     * Calculate remaining days until campaign ends
     * 
     * Returns:
     * - Positive number: days remaining
     * - 0: campaign ends today
     * - -1: campaign has already ended
     * - null: no end date set
     */
    public function getRemainingDaysAttribute()
    {
        // Jika tidak ada end_date, return null
        if (!$this->end_date) {
            return null;
        }

        $endDate = Carbon::parse($this->end_date)->endOfDay(); // Gunakan end of day untuk akurasi
        $now = Carbon::now();

        // Jika sudah melewati end_date, return -1
        if ($now->isAfter($endDate)) {
            return -1;
        }

        // Hitung selisih hari dari hari ini ke end_date
        // PENTING: Urutan parameter benar! (from, to)
        $remainingDays = $now->diffInDays($endDate, absolute: false);

        return (int) $remainingDays;
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('program_category', $category);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function isExpired(): bool
    {
        if (!$this->end_date) {
            return false;
        }

        return Carbon::parse($this->end_date)->isPast();
    }

    /**
     * Mark campaign as completed
     */
    public function markAsCompleted(): bool
    {
        if ($this->isExpired() && $this->status === 'published') {
            return $this->update(['status' => 'completed']);
        }

        return false;
    }

    /**
     * Check if campaign should be automatically completed and do so if needed
     */
    public function checkAndCompleteIfExpired(): bool
    {
        if ($this->isExpired() && $this->status === 'published') {
            return $this->markAsCompleted();
        }

        return false;
    }

    /**
     * Scope untuk mendapatkan campaign yang sudah expired
     */
    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', now()->startOfDay());
    }
}
