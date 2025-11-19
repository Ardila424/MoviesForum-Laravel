<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            ['name' => 'Reseñas', 'slug' => 'resenas', 'description' => 'Reseñas de películas'],
            ['name' => 'Noticias', 'slug' => 'noticias', 'description' => 'Noticias del mundo del cine'],
            ['name' => 'Estrenos', 'slug' => 'estrenos', 'description' => 'Próximos estrenos en cine y streaming'],
            ['name' => 'Recomendaciones', 'slug' => 'recomendaciones', 'description' => 'Listas y recomendaciones'],
        ];

        foreach ($sections as $sec) {
            Section::create($sec);
        }
    }
}
