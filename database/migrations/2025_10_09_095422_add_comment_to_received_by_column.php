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
        // Add a comment to document that received_by should only be filled by admin or staff roles
        DB::statement("ALTER TABLE zakat_payments MODIFY received_by BIGINT UNSIGNED COMMENT 'Only admin or staff users can be set as receiver'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the comment
        DB::statement("ALTER TABLE zakat_payments MODIFY received_by BIGINT UNSIGNED COMMENT ''");
    }
};
