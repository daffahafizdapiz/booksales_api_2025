<?php

namespace App\Models;

class Genre
{
    public static function all()
    {
        return [
            ['id' => 1, 'nama' => 'Fiksi', 'deskripsi' => 'Cerita khayalan atau imajinatif.'],
            ['id' => 2, 'nama' => 'Non-Fiksi', 'deskripsi' => 'Cerita berdasarkan fakta dan kejadian nyata.'],
            ['id' => 3, 'nama' => 'Petualangan', 'deskripsi' => 'Cerita dengan tema perjalanan dan aksi.'],
            ['id' => 4, 'nama' => 'Romansa', 'deskripsi' => 'Cerita bertema cinta dan hubungan emosional.'],
            ['id' => 5, 'nama' => 'Misteri', 'deskripsi' => 'Cerita yang memuat teka-teki dan penyelidikan.'],
        ];
    }
}
