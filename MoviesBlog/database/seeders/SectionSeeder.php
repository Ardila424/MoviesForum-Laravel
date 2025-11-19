<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Reseñas',
            'Noticias',
            'Estrenos',
            'Críticas',
            'Artículos Especiales',
        ];

        foreach ($names as $name) {
            Section::firstOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name'        => $name,
                    'description' => "Sección de {$name} sobre películas y series.",
                ]
            );
        }
    }
}
