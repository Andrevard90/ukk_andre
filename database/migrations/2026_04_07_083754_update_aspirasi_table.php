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
        Schema::table('aspirasi', function (Blueprint $table) {
            // Add keterangan column if it doesn't exist
            if (!Schema::hasColumn('aspirasi', 'keterangan')) {
                $table->text('keterangan')->nullable()->after('lokasi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aspirasi', function (Blueprint $table) {
            if (Schema::hasColumn('aspirasi', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
        });
    }
};
