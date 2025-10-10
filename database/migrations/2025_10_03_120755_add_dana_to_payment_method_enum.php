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
        // Add 'dana' to the payment_method ENUM
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
            'dana',
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
        // Remove 'dana' from the payment_method ENUM
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
};
