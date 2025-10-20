<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            // Hapus constraint unik pada kolom category
            $table->dropUnique('programs_category_unique');
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            // Kembalikan constraint unik jika di-rollback
            $table->unique('category');
        });
    }
};
