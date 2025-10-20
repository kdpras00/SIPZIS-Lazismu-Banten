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
        Schema::table('programs', function (Blueprint $table) {
            // Tambahkan kolom image_url jika belum ada
            if (!Schema::hasColumn('programs', 'image_url')) {
                $table->string('image_url')->nullable()->after('photo');
            }
        });

        // Salin data dari kolom photo ke image_url untuk data yang sudah ada
        DB::statement("UPDATE programs SET image_url = photo WHERE image_url IS NULL AND photo IS NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            if (Schema::hasColumn('programs', 'image_url')) {
                $table->dropColumn('image_url');
            }
        });
    }
};
