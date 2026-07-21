<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;


    public function run(): void
    {
        User::factory()->create([
            'name' => 'mahasiswa',
            'email' => 'mahasiswa@example.com',
            'password' => bcrypt('123'),
            'role' => 'mahasiswa',
        ]);

        User::factory()->create([
            'name' => 'Dosen A',
            'email' => 'dosen@example.com',
            'password' => bcrypt('dosen123'),
            'role' => 'dosen',
        ]);
    }
}
