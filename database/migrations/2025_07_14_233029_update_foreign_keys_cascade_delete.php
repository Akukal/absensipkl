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
        // Update siswa table foreign key
        Schema::table('siswa', function (Blueprint $table) {
            // Drop existing foreign key constraint
            $table->dropForeign(['id_user']);
            
            // Add new foreign key constraint with cascade delete
            $table->foreign('id_user')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        // Update absen table foreign key
        Schema::table('absen', function (Blueprint $table) {
            // Drop existing foreign key constraint for id_siswa
            $table->dropForeign(['id_siswa']);
            
            // Add new foreign key constraint with cascade delete
            $table->foreign('id_siswa')
                  ->references('id')
                  ->on('siswa')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore siswa table foreign key without cascade
        Schema::table('siswa', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->foreign('id_user')
                  ->references('id')
                  ->on('users');
        });

        // Restore absen table foreign key without cascade
        Schema::table('absen', function (Blueprint $table) {
            $table->dropForeign(['id_siswa']);
            $table->foreign('id_siswa')
                  ->references('id')
                  ->on('siswa');
        });
    }
};
