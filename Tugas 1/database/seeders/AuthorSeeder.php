<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('authors')->insert([
            ['nama' => 'Andrea Hirata', 'asal' => 'Belitung'],
            ['nama' => 'Pramoedya Ananta Toer', 'asal' => 'Blora'],
            ['nama' => 'Ahmad Fuadi', 'asal' => 'Sumatera Barat'],
            ['nama' => 'Tere Liye', 'asal' => 'Palembang'],
            ['nama' => 'Dewi Lestari', 'asal' => 'Bandung'],
        ]);
    }
}
