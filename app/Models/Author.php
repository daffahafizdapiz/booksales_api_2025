<?php

namespace App\Models;

class Author
{
    public static function all()
    {
        return [
            ['id' => 1, 'nama' => 'Andrea Hirata', 'asal' => 'Indonesia'],
            ['id' => 2, 'nama' => 'Tere Liye', 'asal' => 'Indonesia'],
            ['id' => 3, 'nama' => 'Dewi Lestari', 'asal' => 'Indonesia'],
            ['id' => 4, 'nama' => 'Ahmad Fuadi', 'asal' => 'Indonesia'],
            ['id' => 5, 'nama' => 'Habiburrahman El Shirazy', 'asal' => 'Indonesia'],
        ];
    }
}
