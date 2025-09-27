<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('zakat_payments', function (Blueprint $table) {
            // Modify the payment_method column to include 'midtrans' as a valid option
            DB::statement("ALTER TABLE zakat_payments MODIFY COLUMN payment_method ENUM('cash', 'transfer', 'check', 'online', 'midtrans')");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zakat_payments', function (Blueprint $table) {
            // Revert to original enum values
            DB::statement("ALTER TABLE zakat_payments MODIFY COLUMN payment_method ENUM('cash', 'transfer', 'check', 'online')");
        });
    }
};