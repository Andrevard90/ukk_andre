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
        Schema::create('input_aspirasi', function (Blueprint $table) {
    $table->id('id_pelaporan');
    $table->string('nis');
    $table->foreign('nis')->references('nis')->on('siswa');
    $table->unsignedBigInteger('id_kategori');
    $table->string('lokasi');
    $table->text('ket');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_aspirasi');
    }
};
