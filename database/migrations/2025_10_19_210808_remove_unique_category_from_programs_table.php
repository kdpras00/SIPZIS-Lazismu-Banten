<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if the index exists before trying to drop it
        $indexes = DB::select("SHOW INDEX FROM programs WHERE Key_name = 'programs_category_unique'");

        if (!empty($indexes)) {
            // Drop the unique constraint if it exists
            Schema::table('programs', function (Blueprint $table) {
                $table->dropUnique('programs_category_unique');
            });
        }
    }

    public function down(): void
    {
        // Check if the index doesn't exist before adding it back
        $indexes = DB::select("SHOW INDEX FROM programs WHERE Key_name = 'programs_category_unique'");

        if (empty($indexes)) {
            // Add the unique constraint back if it doesn't exist
            Schema::table('programs', function (Blueprint $table) {
                $table->unique('category');
            });
        }
    }
};
