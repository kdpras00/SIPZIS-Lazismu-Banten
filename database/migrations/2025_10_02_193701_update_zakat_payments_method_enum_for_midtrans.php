<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('zakat_payments', function (Blueprint $table) {
            // Modify the payment_method column to include all Midtrans Snap payment methods
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zakat_payments', function (Blueprint $table) {
            // Revert to original enum values
            DB::statement("ALTER TABLE zakat_payments MODIFY COLUMN payment_method ENUM('cash', 'transfer', 'check', 'online') NOT NULL DEFAULT 'cash'");
        });
    }
};
