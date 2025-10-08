<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\User;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data user dengan level guru
        $usersGuru = User::where('level', 'guru')->get();
        
        if ($usersGuru->isEmpty()) {
            $this->command->info('Tidak ada user dengan level guru. Membuat beberapa user guru...');
            
            // Buat beberapa user guru jika belum ada
            $usersGuru = collect([
                User::create([
                    'nama' => 'Dr. Sari Dewi, M.Pd',
                    'email' => 'sari.dewi@guru.com',
                    'level' => 'guru',
                ]),
                User::create([
                    'nama' => 'Drs. Ahmad Fauzi, S.Kom',
                    'email' => 'ahmad.fauzi@guru.com',
                    'level' => 'guru',
                ]),
                User::create([
                    'nama' => 'Ir. Budi Santoso, M.T',
                    'email' => 'budi.santoso@guru.com',
                    'level' => 'guru',
                ]),
                User::create([
                    'nama' => 'Dra. Maya Sari, S.Pd',
                    'email' => 'maya.sari@guru.com',
                    'level' => 'guru',
                ]),
                User::create([
                    'nama' => 'Gilbert Sibuea, S.Kom',
                    'email' => 'gilbertsibuea8539@gmail.com',
                    'level' => 'guru',
                ]),
            ]);
        }

        foreach ($usersGuru as $user) {
            // Cek apakah guru sudah ada untuk user ini
            $existingGuru = Guru::where('id_user', $user->id)->first();
            
            if (!$existingGuru) {
                Guru::create([
                    'id_user' => $user->id,
                    'nohp' => '08' . rand(1000000000, 9999999999), // Generate random phone number
                ]);
            }
        }

        $this->command->info('Seeder guru berhasil dijalankan!');
    }
}
