<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Développement Web',
            'Intelligence Artificielle',
            'Cybersécurité',
            'DevOps',
            'Mobile',
            'Data & Bases de données',
        ];

        foreach ($categories as $nom) {
            Category::updateOrCreate(
                ['slug' => Str::slug($nom)],
                ['nom'  => $nom]
            );
        }
    }
}