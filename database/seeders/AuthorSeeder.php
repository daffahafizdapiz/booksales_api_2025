<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('authors')->insert([
            [
                'id' => 1,
                'name' => 'Andrea Hirata',
                'photo' => 'andrea.jpg',
                'bio' => 'Penulis asal Belitung, terkenal dengan novel Laskar Pelangi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Pramoedya Ananta Toer',
                'photo' => 'pram.jpg',
                'bio' => 'Sastrawan legendaris Indonesia, penulis Bumi Manusia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Ahmad Fuadi',
                'photo' => 'fuadi.jpg',
                'bio' => 'Penulis trilogi Negeri 5 Menara.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Tere Liye',
                'photo' => 'tere.jpg',
                'bio' => 'Penulis produktif dengan gaya narasi emosional dan inspiratif.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Dewi Lestari',
                'photo' => 'dee.jpg',
                'bio' => 'Penulis novel Perahu Kertas dan tokoh penting sastra modern Indonesia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
