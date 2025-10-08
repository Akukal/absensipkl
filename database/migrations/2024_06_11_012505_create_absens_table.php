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
        Schema::create('absen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_siswa');
            $table->enum('status', ['Hadir', 'Tidak Hadir', 'Izin']);
            $table->time('jam_masuk')->nullable();
            $table->string('foto_masuk')->nullable();
            $table->text('lokasi_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->string('foto_keluar')->nullable();
            $table->text('lokasi_keluar')->nullable();
            $table->string('foto')->nullable();
            $table->string('keterangan')->nullable();

            $table->foreign('id_siswa')->references('id')->on('siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absens');
    }
};
