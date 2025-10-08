<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Perusahaan;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data user dengan level siswa
        $usersSiswa = User::where('level', 'siswa')->get();
        
        if ($usersSiswa->isEmpty()) {
            $this->command->info('Tidak ada user dengan level siswa. Membuat beberapa user siswa...');
            
            // Buat beberapa user siswa jika belum ada
            $usersSiswa = collect([
                User::create([
                    'nama' => 'Ahmad Fauzi',
                    'email' => 'ahmad.fauzi@student.com',
                    'level' => 'siswa',
                ]),
                User::create([
                    'nama' => 'Siti Aminah',
                    'email' => 'siti.aminah@student.com',
                    'level' => 'siswa',
                ]),
                User::create([
                    'nama' => 'Budi Santoso',
                    'email' => 'budi.santoso@student.com',
                    'level' => 'siswa',
                ]),
                User::create([
                    'nama' => 'Dewi Sari',
                    'email' => 'dewi.sari@student.com',
                    'level' => 'siswa',
                ]),
                User::create([
                    'nama' => 'Rudi Pratama',
                    'email' => 'rudi.pratama@student.com',
                    'level' => 'siswa',
                ]),
            ]);
        }

        // Ambil data perusahaan yang tersedia
        $perusahaans = Perusahaan::all();
        
        $kelasOptions = ['XII RPL 1', 'XII RPL 2', 'XII TKJ 1', 'XII TKJ 2', 'XII MM 1', 'XII MM 2'];

        foreach ($usersSiswa as $user) {
            // Cek apakah siswa sudah ada untuk user ini
            $existingSiswa = Siswa::where('id_user', $user->id)->first();
            
            if (!$existingSiswa) {
                Siswa::create([
                    'id_user' => $user->id,
                    'id_perusahaan' => $perusahaans->isNotEmpty() ? $perusahaans->random()->id : null,
                    'kelas' => $kelasOptions[array_rand($kelasOptions)],
                ]);
            }
        }

        $this->command->info('Seeder siswa berhasil dijalankan!');
    }
}
