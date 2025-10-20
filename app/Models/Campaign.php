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

    // Accessors
    public function getImageUrlAttribute()
    {
        // If photo is empty, return a default image
        if (empty($this->photo)) {
            return asset('img/masjid.webp');
        }

        // Check if photo is a full URL (CDN)
        if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }

        // For local storage paths, use asset() helper
        return asset('storage/' . ltrim($this->photo, '/'));
    }

    public function getCollectedAmountAttribute($value)
    {
        // Calculate collected amount dynamically from related payments
        if (isset($this->attributes['collected_amount'])) {
            // For backward compatibility, use stored value if available
            return $this->attributes['collected_amount'];
        }

        // Otherwise calculate from payments
        return $this->zakatPayments()->sum('paid_amount');
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount <= 0) {
            return 0;
        }

        return min(100, ($this->collected_amount / $this->target_amount) * 100);
    }

    public function getFormattedTargetAmountAttribute()
    {
        return 'Rp ' . number_format($this->target_amount, 0, ',', '.');
    }

    public function getFormattedCollectedAmountAttribute()
    {
        return 'Rp ' . number_format($this->collected_amount, 0, ',', '.');
    }

    public function getDonorsCountAttribute()
    {
        return $this->zakatPayments()->count();
    }

    public function getRemainingDaysAttribute()
    {
        if (!$this->end_date) {
            return null;
        }

        $endDate = Carbon::parse($this->end_date);
        $now = Carbon::now();

        if ($endDate->isPast()) {
            return 0;
        }

        return $endDate->diffInDays($now);
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
}
