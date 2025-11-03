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
                'id' => 1,
                'name' => 'Petualangan',
                'description' => 'Genre yang berfokus pada kisah perjalanan seru, eksplorasi tempat baru, dan tantangan penuh aksi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Novel',
                'description' => 'Genre yang menyoroti kisah kehidupan, cinta, dan konflik emosional antar tokoh secara mendalam.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Fiksi',
                'description' => 'Genre yang mengangkat cerita rekaan, sering kali melibatkan unsur fantasi, imajinasi, atau dunia alternatif.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Drama',
                'description' => 'Genre yang menampilkan konflik emosional dan sosial yang intens, menggambarkan realitas kehidupan manusia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Komedi',
                'description' => 'Genre yang bertujuan menghibur penonton dengan situasi lucu, humor, dan kejadian ringan yang mengundang tawa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
