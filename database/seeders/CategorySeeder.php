<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Daftar Kategori yang ingin dibuat
        $categories = [
            'Sejarah',
            'Budaya',
            'Cerita Rakyat',
            'Kuliner',
            'Tokoh',
            'Adat Istiadat'
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat),
            ]);
        }
    }
}