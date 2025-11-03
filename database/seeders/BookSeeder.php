<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'id' => 1,
                'title' => 'Laskar Pelangi',
                'description' => 'Novel inspiratif karya Andrea Hirata yang berlatar di Belitung.',
                'price' => 85000,
                'stock' => 10,
                'cover_photo' => 'laskar_pelangi.jpg',
                'genre_id' => 1,
                'author_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'title' => 'Bumi Manusia',
                'description' => 'Karya klasik Pramoedya Ananta Toer tentang kolonialisme dan cinta.',
                'price' => 90000,
                'stock' => 8,
                'cover_photo' => 'bumi_manusia.jpg',
                'genre_id' => 4,
                'author_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'title' => 'Negeri 5 Menara',
                'description' => 'Novel Ahmad Fuadi yang mengangkat kisah santri penuh semangat.',
                'price' => 75000,
                'stock' => 12,
                'cover_photo' => 'negeri_5_menara.jpg',
                'genre_id' => 3,
                'author_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'title' => 'Rindu',
                'description' => 'Karya Tere Liye dengan kisah spiritual yang menyentuh.',
                'price' => 70000,
                'stock' => 5,
                'cover_photo' => 'rindu.jpg',
                'genre_id' => 3,
                'author_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'title' => 'Perahu Kertas',
                'description' => 'Novel populer Dewi Lestari bertema cinta dan jati diri.',
                'price' => 80000,
                'stock' => 9,
                'cover_photo' => 'perahu_kertas.jpg',
                'genre_id' => 2,
                'author_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
