<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Section;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed de la base de datos de la aplicación.
     */
    public function run(): void
    {
        // ---------------------------
        // 1. Ejecutar seeder de roles y permisos
        // ---------------------------
        $this->call(RolePermissionSeeder::class);


        // ---------------------------
        // 2. Crear usuario admin por defecto
        // ---------------------------
        User::factory()->create([
            'name'     => 'Admin Demo',
            'email'    => 'admin@example.com',
            'password' => 'password',   // gracias al cast 'hashed', se cifra automáticamente
            'role_id'  => 1,            // ID del rol admin definido en RolePermissionSeeder
        ]);


        // ---------------------------
        // 3. Crear SECCIONES base del sitio de películas
        // ---------------------------
        $sections = [
            ['name' => 'Noticias',    'slug' => 'noticias',    'description' => 'Actualidad del mundo del cine'],
            ['name' => 'Reseñas',     'slug' => 'reseñas',     'description' => 'Críticas de películas y series'],
            ['name' => 'Estrenos',    'slug' => 'estrenos',    'description' => 'Películas recién estrenadas'],
            ['name' => 'Trailers',    'slug' => 'trailers',    'description' => 'Últimos trailers publicados'],
        ];

        foreach ($sections as $sec) {
            Section::create($sec);
        }

        // Listo: roles, permisos, admin y secciones iniciadas correctamente
    }
}
