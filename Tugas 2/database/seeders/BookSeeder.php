<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('books')->insert([
            ['judul' => 'Laskar Pelangi', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => 2005, 'stok' => 10, 'author_id' => 1],
            ['judul' => 'Bumi Manusia', 'penerbit' => 'Hasta Mitra', 'tahun_terbit' => 1980, 'stok' => 8, 'author_id' => 2],
            ['judul' => 'Negeri 5 Menara', 'penerbit' => 'Gramedia', 'tahun_terbit' => 2009, 'stok' => 12, 'author_id' => 3],
            ['judul' => 'Rindu', 'penerbit' => 'Republika', 'tahun_terbit' => 2014, 'stok' => 5, 'author_id' => 4],
            ['judul' => 'Perahu Kertas', 'penerbit' => 'Bentang Pustaka', 'tahun_terbit' => 2009, 'stok' => 9, 'author_id' => 5],
        ]);
    }
}
