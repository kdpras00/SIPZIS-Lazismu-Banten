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
            $table->string('midtrans_order_id')->nullable()->unique()->after('payment_code');
        });
    }

    public function down(): void
    {
        Schema::table('zakat_payments', function (Blueprint $table) {
            $table->dropColumn('midtrans_order_id');
        });
    }
};
