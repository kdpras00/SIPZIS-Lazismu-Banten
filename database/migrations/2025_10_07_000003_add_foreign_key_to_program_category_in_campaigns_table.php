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
        // First, clean up any invalid references
        DB::statement("
            UPDATE campaigns 
            SET program_category = NULL 
            WHERE program_category NOT IN (SELECT category FROM programs WHERE category IS NOT NULL)
        ");

        Schema::table('campaigns', function (Blueprint $table) {
            // Check if the foreign key constraint doesn't already exist
            $existingForeignKeys = collect(DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'campaigns' 
                AND COLUMN_NAME = 'program_category'
                AND REFERENCED_TABLE_NAME IS NOT NULL
            "))->pluck('CONSTRAINT_NAME')->toArray();

            // Only add the foreign key if it doesn't already exist
            if (!in_array('fk_campaign_program_category', $existingForeignKeys)) {
                // Check if the column types match before adding foreign key
                $campaignColumnType = DB::select("
                    SELECT COLUMN_TYPE 
                    FROM information_schema.COLUMNS 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'campaigns' 
                    AND COLUMN_NAME = 'program_category'
                ")[0]->COLUMN_TYPE ?? '';

                $programColumnType = DB::select("
                    SELECT COLUMN_TYPE 
                    FROM information_schema.COLUMNS 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'programs' 
                    AND COLUMN_NAME = 'category'
                ")[0]->COLUMN_TYPE ?? '';

                // Only add foreign key if column types match
                if ($campaignColumnType === $programColumnType) {
                    $table->foreign('program_category', 'fk_campaign_program_category')
                        ->references('category')->on('programs')
                        ->onDelete('set null')
                        ->onUpdate('restrict');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            // Check if the foreign key constraint exists before dropping
            $existingForeignKeys = collect(DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'campaigns' 
                AND COLUMN_NAME = 'program_category'
                AND REFERENCED_TABLE_NAME IS NOT NULL
                AND CONSTRAINT_NAME = 'fk_campaign_program_category'
            "))->pluck('CONSTRAINT_NAME')->toArray();

            if (in_array('fk_campaign_program_category', $existingForeignKeys)) {
                $table->dropForeign('fk_campaign_program_category');
            }
        });
    }
};
