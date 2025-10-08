<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Jalankan seeder dalam urutan yang benar (guru dulu, baru perusahaan, lalu siswa)
        $this->call([
            GuruSeeder::class,
            PerusahaanSeeder::class,
            SiswaSeeder::class,
        ]);
    }
}
