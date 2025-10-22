<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin'
        ]);

        // User biasa
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('user123'),
            'role' => 'user'
        ]);
    }
}
