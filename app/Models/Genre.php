<?php

namespace App\Models;

class Genre
{
    public static function all()
    {
        return [
            ['id' => 1, 'name' => 'Fiction', 'description' => 'Imaginative or made-up stories.'],
            ['id' => 2, 'name' => 'Non-Fiction', 'description' => 'Based on real events or facts.'],
            ['id' => 3, 'name' => 'Science Fiction', 'description' => 'Stories about futuristic science and technology.'],
            ['id' => 4, 'name' => 'Romance', 'description' => 'Love and emotional relationship stories.'],
            ['id' => 5, 'name' => 'Mystery', 'description' => 'Focuses on solving a crime or puzzle.'],
        ];
    }
}
