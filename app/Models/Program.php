<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Program extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'target_amount',
        'status',
        'photo',
        'image_url',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
    ];

    // ========================
    // 🔗 Relationships
    // ========================
    public function programType()
    {
        return $this->belongsTo(ProgramType::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    // Relationship to get zakat payments directly associated with this program
    public function zakatPayments()
    {
        return $this->hasMany(ZakatPayment::class, 'program_id', 'id');
    }


    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    // ========================
    // 🧮 Accessors (Computed Fields)
    // ========================

    /**
     * Get the full URL for the program photo.
     * Supports both CDN URLs and local storage paths.
     */
    public function getImageUrlAttribute()
    {
        // Use image_url if available, otherwise fallback to photo
        $imagePath = $this->image_url ?? $this->photo;

        // If image path is empty, return a default image
        if (empty($imagePath)) {
            return asset('img/masjid.webp');
        }

        // Check if image path is a full URL (CDN)
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }

        // For local storage paths, ensure they start with 'programs/' directory
        if (strpos($imagePath, 'programs/') === 0) {
            // Use Storage::url() for proper URL generation
            return Storage::url($imagePath);
        }

        // For other relative paths, prepend storage directory
        if (strpos($imagePath, '/') !== 0) {
            $imagePath = 'programs/' . $imagePath;
        }

        // Use Storage::url() for proper URL generation
        return Storage::url(ltrim($imagePath, '/'));
    }

    // Total dana terkumpul dari semua campaign yang published
    public function getTotalCollectedAttribute()
    {
        // First check for direct program-based donations
        $directPayments = $this->zakatPayments()
            ->completed()
            ->sum('paid_amount');

        // Then check for campaign-based donations
        $campaignPayments = $this->campaigns()
            ->published()
            ->with('zakatPayments')
            ->get()
            ->sum(function ($campaign) {
                return $campaign->zakatPayments()->completed()->sum('paid_amount');
            });

        return $directPayments + $campaignPayments;
    }

    // Format total terkumpul dalam bentuk rupiah
    public function getFormattedTotalCollectedAttribute()
    {
        return 'Rp ' . number_format($this->total_collected ?? 0, 0, ',', '.');
    }

    // Total target (ambil dari program langsung atau dari campaign)
    public function getTotalTargetAttribute()
    {
        if ($this->target_amount > 0) {
            return $this->target_amount;
        }

        return $this->campaigns()
            ->published()
            ->sum('target_amount');
    }

    // Format total target dalam bentuk rupiah
    public function getFormattedTotalTargetAttribute()
    {
        return 'Rp ' . number_format($this->total_target ?? 0, 0, ',', '.');
    }

    // Persentase progress (0–100%)
    public function getProgressPercentageAttribute()
    {
        if ($this->total_target <= 0) {
            return 0;
        }

        return min(100, ($this->total_collected / $this->total_target) * 100);
    }

    // ========================
    // 🔍 Scopes
    // ========================
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($program) {
            $program->slug = Str::slug($program->name);
        });

        // When a program is created
        static::created(function ($program) {
            // Create a notification for all users about the new program
            // This would typically be done in a scheduled job or event listener
        });

        // When a program is updated
        static::updated(function ($program) {
            // Check if status has changed to active
            if ($program->isDirty('status') && $program->status === 'active') {
                // Create a notification for all users about the program being active
                // This would typically be done in a scheduled job or event listener
            }
        });
    }
}
