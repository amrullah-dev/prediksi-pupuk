<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'nama' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'nama' => 'Pemilik',
            'email' => 'pemilik@gmail.com',
            'password' => 'pemilik123',
            'role' => 'pemilik',
        ]);
    }
}
