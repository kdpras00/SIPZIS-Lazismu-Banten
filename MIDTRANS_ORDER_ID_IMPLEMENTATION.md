# Midtrans Order ID Implementation

## Overview

This document describes the implementation of the `midtrans_order_id` field to track the specific Midtrans order ID for each payment. This enhancement allows for more accurate tracking and matching of payments with their corresponding Midtrans transactions.

## Changes Made

### 1. Database Migration

- Added `midtrans_order_id` column to the `zakat_payments` table
- Column is nullable, unique, and placed after `payment_code`
- Migration file: `2025_10_06_143026_add_midtrans_order_id_to_zakat_payments_table.php`

### 2. Model Update

- Added `midtrans_order_id` to the `$fillable` array in `ZakatPayment` model

### 3. Controller Updates

#### ZakatPaymentController.php

##### handleNotification Method

- Modified payment lookup to first search by `midtrans_order_id`, then fallback to `payment_code`
- Added `midtrans_order_id` to the update data when updating payment status

##### midtransCallback Method

- Modified payment lookup to first search by `midtrans_order_id`, then fallback to `payment_code`
- Added `midtrans_order_id` to the update data when updating payment status

##### getSnapToken Method

- Added `midtrans_order_id` to the update data when generating Snap token

##### getTokenCustom Method

- Added `midtrans_order_id` to the update data when generating Snap token

## Benefits

1. **Accurate Payment Tracking**: Each payment can now be directly linked to its specific Midtrans order ID
2. **Improved Lookup Performance**: Direct lookup by Midtrans order ID is more efficient than parsing payment codes
3. **Better Error Handling**: More precise identification of payment records in notification handling
4. **Enhanced Debugging**: Easier to trace payment issues with direct Midtrans order ID references

## Implementation Details

- The `midtrans_order_id` is generated as `payment_code-timestamp-uniqueid` when creating a Snap token
- Notification handlers now first attempt to find payments by `midtrans_order_id` before falling back to `payment_code` parsing
- All payment updates include the `midtrans_order_id` to ensure consistency

## Testing

To test this implementation:

1. Create a new payment and verify the `midtrans_order_id` is stored when generating a Snap token
2. Send a test notification and verify the payment is correctly found by `midtrans_order_id`
3. Check that the `midtrans_order_id` is updated in payment records during status changes

## Future Considerations

- Consider adding indexes on the `midtrans_order_id` column for improved query performance
- Add validation to ensure `midtrans_order_id` uniqueness across the system
- Consider implementing a cleanup process for orphaned `midtrans_order_id` values
