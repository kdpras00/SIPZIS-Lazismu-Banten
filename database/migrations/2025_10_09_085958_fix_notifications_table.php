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
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('notifiable_type')->nullable()->change();
            $table->unsignedBigInteger('notifiable_id')->nullable()->change();
            $table->string('icon')->nullable()->change();
            $table->string('color')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('notifiable_type')->nullable(false)->change();
            $table->unsignedBigInteger('notifiable_id')->nullable(false)->change();
            $table->string('icon')->nullable(false)->change();
            $table->string('color')->nullable(false)->change();
        });
    }
};
