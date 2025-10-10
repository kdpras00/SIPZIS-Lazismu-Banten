# Program Donation Amount Calculation Fix

## Issue Description

The program donation amounts were not updating properly when new donations were made. The `formatted_total_collected` value was showing as Rp 0 even when donations had been made to the program.

## Root Cause

The issue was in the `Program` model's `getTotalCollectedAttribute()` method. The method was only calculating donations from campaigns but not direct program-based donations. The relationship between the Program and ZakatPayment models was not properly configured to include direct program donations.

## Solution Implemented

### 1. Fixed the Program Model Relationship

Added a proper relationship in the `Program` model to link to `ZakatPayment` records:

```php
// Relationship to get zakat payments directly associated with this program
public function zakatPayments()
{
    // For program-based donations, we need to match the program category
    return $this->hasMany(ZakatPayment::class, 'program_category', 'category');
}
```

### 2. Updated the Total Collected Calculation

Modified the `getTotalCollectedAttribute()` method to include both direct program donations and campaign-based donations:

```php
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
```

## How It Works

1. When a donation is made to a program (e.g., "pendidikan"), it's stored in the `zakat_payments` table with the `program_category` field set to "pendidikan"
2. The `zakatPayments()` relationship in the `Program` model links to all `ZakatPayment` records where `program_category` matches the program's `category`
3. The `getTotalCollectedAttribute()` accessor calculates the sum of all completed payments for both direct program donations and campaign-based donations
4. The `getFormattedTotalCollectedAttribute()` accessor formats this value as Indonesian Rupiah

## Testing

A test script was created to verify the fix works correctly:

- Creates a test donation to the "pendidikan" program
- Verifies that the total collected amount is calculated correctly
- Confirms that both direct and campaign payments are included in the calculation

## Benefits

- Program donation amounts now update in real-time when new donations are made
- Both direct program donations and campaign-based donations are properly accounted for
- The calculation is more accurate and comprehensive
- Users can see the correct donation progress for each program
