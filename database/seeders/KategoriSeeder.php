<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kategori default untuk aspirasi/pengaduan
        Kategori::firstOrCreate(
            ['id_kategori' => 1],
            ['ket_kategori' => 'Kebersihan']
        );

        Kategori::firstOrCreate(
            ['id_kategori' => 2],
            ['ket_kategori' => 'Keselamatan']
        );

        Kategori::firstOrCreate(
            ['id_kategori' => 3],
            ['ket_kategori' => 'Fasilitas']
        );

        Kategori::firstOrCreate(
            ['id_kategori' => 4],
            ['ket_kategori' => 'Pembelajaran']
        );

        Kategori::firstOrCreate(
            ['id_kategori' => 5],
            ['ket_kategori' => 'Administrasi']
        );
    }
}
