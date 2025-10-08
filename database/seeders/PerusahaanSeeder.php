<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Perusahaan;
use App\Models\Guru;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data guru untuk dijadikan referensi
        $gurus = Guru::all();
        
        if ($gurus->isEmpty()) {
            $this->command->info('Tidak ada data guru yang tersedia. Silakan jalankan seeder untuk guru terlebih dahulu.');
            return;
        }

        $perusahaans = [
            [
                'nama' => 'PT. TESTING INPUT 1',
                'alamat' => 'Jl. Testing No. 123, Jakarta Testing',
                'pj' => 'Budi Santoso',
                'nohp' => '081234567890',
                'id_guru' => $gurus->random()->id,
            ],
        ];

        foreach ($perusahaans as $perusahaan) {
            Perusahaan::create($perusahaan);
        }

        $this->command->info('Seeder perusahaan berhasil dijalankan! ' . count($perusahaans) . ' perusahaan telah ditambahkan.');
    }
}
