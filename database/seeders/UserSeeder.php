<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat Akun Admin
        User::create([
            'name' => 'Muhammad Rijal Alfatori',
            'email' => 'admin@dokterjanji.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Membuat Akun Pengguna Biasa
        User::create([
            'name' => 'Dzaki',
            'email' => 'dzaki@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }
}