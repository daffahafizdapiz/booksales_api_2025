<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('genres')->insert([
            [
                'nama' => 'Romansa',
                'deskripsi' => 'Genre yang berfokus pada kisah cinta dan hubungan emosional antar tokoh.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Petualangan',
                'deskripsi' => 'Genre yang berisi kisah perjalanan penuh tantangan dan eksplorasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Fiksi Ilmiah',
                'deskripsi' => 'Genre yang menggambarkan teknologi futuristik, ruang angkasa, dan sains spekulatif.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Horor',
                'deskripsi' => 'Genre yang bertujuan menimbulkan rasa takut dan ketegangan pada pembaca.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Komedi',
                'deskripsi' => 'Genre yang berisi unsur humor dan hiburan untuk membuat pembaca tertawa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
