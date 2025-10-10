<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'status'
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2',
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
