<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update aspirasi table sesuai skema gambar
        Schema::table('aspirasi', function (Blueprint $table) {
            // Hapus kolom yang tidak sesuai jika ada
            if (Schema::hasColumn('aspirasi', 'nis')) {
                $table->dropColumn('nis');
            }
            if (Schema::hasColumn('aspirasi', 'lokasi')) {
                $table->dropColumn('lokasi');
            }
            if (Schema::hasColumn('aspirasi', 'keterangan')) {
                $table->dropColumn('keterangan');
            }
            if (Schema::hasColumn('aspirasi', 'foto')) {
                $table->dropColumn('foto');
            }
            if (Schema::hasColumn('aspirasi', 'tanggal')) {
                $table->dropColumn('tanggal');
            }
            if (!Schema::hasColumn('aspirasi', 'feedback')) {
                $table->integer('feedback')->nullable();
            }
            if (!Schema::hasColumn('aspirasi', 'id_aspirasi')) {
                $table->renameColumn('id', 'id_aspirasi');
            }
        });
    }

    public function down(): void
    {
        //
    }
};
