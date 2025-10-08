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
        Schema::table('siswa', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu
            $table->dropForeign(['id_perusahaan']);
            
            // Ubah kolom menjadi nullable
            $table->unsignedBigInteger('id_perusahaan')->nullable()->change();
            $table->string('kelas')->nullable()->change();
            
            // Tambahkan kembali foreign key constraint
            $table->foreign('id_perusahaan')->references('id')->on('perusahaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            // Hapus foreign key constraint
            $table->dropForeign(['id_perusahaan']);
            
            // Kembalikan kolom menjadi not null
            $table->unsignedBigInteger('id_perusahaan')->nullable(false)->change();
            $table->string('kelas')->nullable(false)->change();
            
            // Tambahkan kembali foreign key constraint
            $table->foreign('id_perusahaan')->references('id')->on('perusahaan');
        });
    }
};
