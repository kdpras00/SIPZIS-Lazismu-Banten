<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ZakatPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_code',
        'midtrans_order_id',
        'snap_token',
        'muzakki_id',
        'program_category',
        'program_type_id',
        'zakat_type_id', // Add this back since it's still used in some places
        'zakat_amount',
        'paid_amount',
        'payment_method',
        'midtrans_payment_method',
        'payment_reference',
        'payment_date',
        'notes',
        'status',
        'receipt_number',
        'received_by',
        'is_guest_payment'
    ];

    protected $casts = [
        'zakat_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    // Relationships
    public function muzakki()
    {
        return $this->belongsTo(Muzakki::class);
    }

    public function programType()
    {
        return $this->belongsTo(ProgramType::class, 'program_type_id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    // Methods
    public static function generatePaymentCode()
    {
        $year = date('Y');
        $lastPayment = self::where('payment_code', 'like', "ZKT-{$year}-%")
            ->orderBy('payment_code', 'desc')
            ->first();

        if ($lastPayment) {
            $lastNumber = (int) substr($lastPayment->payment_code, -3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return "ZKT-{$year}-" . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public static function generateReceiptNumber()
    {
        $year = date('Y');
        $month = date('m');
        $lastReceipt = self::where('receipt_number', 'like', "RCP-{$year}{$month}-%")
            ->orderBy('receipt_number', 'desc')
            ->first();

        if ($lastReceipt) {
            $lastNumber = (int) substr($lastReceipt->receipt_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return "RCP-{$year}{$month}-" . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->paid_amount, 0, ',', '.');
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeByYear($query, $year)
    {
        return $query->whereYear('payment_date', $year);
    }

    public function scopeByMonth($query, $month, $year = null)
    {
        $year = $year ?: date('Y');
        return $query->whereYear('payment_date', $year)
            ->whereMonth('payment_date', $month);
    }

    public function scopeByProgramCategory($query, $category)
    {
        return $query->where('program_category', $category);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    // Event handling for notifications
    public static function boot()
    {
        parent::boot();

        // When a payment is created
        static::created(function ($payment) {
            // Create a notification for the muzakki
            if ($payment->muzakki) {
                Notification::createPaymentNotification($payment->muzakki, $payment, $payment->status);
            }
        });

        // When a payment is updated
        static::updated(function ($payment) {
            // Check if status has changed
            if ($payment->isDirty('status')) {
                // Create a notification for the muzakki
                if ($payment->muzakki) {
                    Notification::createPaymentNotification($payment->muzakki, $payment, $payment->status);
                }
            }
        });
    }
}
