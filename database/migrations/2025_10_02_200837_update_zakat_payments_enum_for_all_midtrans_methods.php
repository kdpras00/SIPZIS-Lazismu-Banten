<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Expand ENUM to include both old and new values
        DB::statement("ALTER TABLE zakat_payments MODIFY COLUMN payment_method ENUM(
            'cash', 
            'transfer', 
            'check', 
            'online', 
            'midtrans',
            'bca_va',
            'bri_va',
            'bni_va',
            'mandiri_va',
            'permata_va',
            'cimb_va',
            'other_va',
            'gopay',
            'shopeepay',
            'qris',
            'credit_card',
            'bca_klikpay',
            'cimb_clicks',
            'danamon_online',
            'bri_epay',
            'indomaret',
            'alfamart',
            'akulaku'
        ) NOT NULL DEFAULT 'cash'");

        // Step 2: Update existing 'midtrans' records to a specific payment method
        DB::statement("UPDATE zakat_payments SET payment_method = 'gopay' WHERE payment_method = 'midtrans'");

        // Step 3: Now we can remove 'midtrans' from the ENUM since no records use it anymore
        DB::statement("ALTER TABLE zakat_payments MODIFY COLUMN payment_method ENUM(
            'cash', 
            'transfer', 
            'check', 
            'online', 
            'bca_va',
            'bri_va',
            'bni_va',
            'mandiri_va',
            'permata_va',
            'cimb_va',
            'other_va',
            'gopay',
            'shopeepay',
            'qris',
            'credit_card',
            'bca_klikpay',
            'cimb_clicks',
            'danamon_online',
            'bri_epay',
            'indomaret',
            'alfamart',
            'akulaku'
        ) NOT NULL DEFAULT 'cash'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values with 'midtrans'
        DB::statement("ALTER TABLE zakat_payments MODIFY COLUMN payment_method ENUM(
            'cash', 
            'transfer', 
            'check', 
            'online', 
            'midtrans'
        ) NOT NULL DEFAULT 'cash'");
    }
};
