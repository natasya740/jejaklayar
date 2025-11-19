<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // Gunakan firstOrCreate
    // Artinya: Cari user dengan email ini. Jika tidak ada, baru buat.
    
    User::firstOrCreate(
        ['email' => 'admin@jejaklayar.com'], // Kunci pencarian
        [
            'name' => 'Administrator',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]
    );

    User::firstOrCreate(
        ['email' => 'kontributor@jejaklayar.com'],
        [
            'name' => 'Kontributor Demo',
            'password' => Hash::make('password123'),
            'role' => 'kontributor',
        ]
    );
}
}