<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Kategori;
use App\Models\Lapangan;
use App\Models\HargaLapangan;
// use Database\Factories\HargaLapanganFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      User::factory(5)->create();
      // Lapangan::factory(5)->create();
      // HargaLapangan::factory(50)->create();
      $this->call([
        JamSeeder::class,
        KategoriSeeder::class,
      ]);
    }
}
