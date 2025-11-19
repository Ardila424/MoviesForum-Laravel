<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Section;
use App\Models\Role;

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

        // Recuperar roles principales
        $adminRole     = Role::where('slug', 'admin')->first();
        $editorRole    = Role::where('slug', 'editor')->first();
        $visitRole     = Role::where('slug', 'visitante')->first();

        // ---------------------------
        // 2. Crear usuarios demo
        // ---------------------------

        // Admin
        if ($adminRole) {
            User::firstOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name'     => 'Admin Demo',
                    'password' => 'password',      // se cifra gracias al cast 'hashed' en el modelo User
                    'role_id'  => $adminRole->id,
                ]
            );
        }

        // Editor
        if ($editorRole) {
            User::firstOrCreate(
                ['email' => 'editor@example.com'],
                [
                    'name'     => 'Editor Demo',
                    'password' => 'password',
                    'role_id'  => $editorRole->id,
                ]
            );
        }

        // Visitante
        if ($visitRole) {
            User::firstOrCreate(
                ['email' => 'visitante@example.com'],
                [
                    'name'     => 'Visitante Demo',
                    'password' => 'password',
                    'role_id'  => $visitRole->id,
                ]
            );
        }

        // ---------------------------
        // 3. Crear SECCIONES base del sitio de películas
        // ---------------------------
        $sectionsData = [
            [
                'name'        => 'Noticias',
                'slug'        => 'noticias',
                'description' => 'Actualidad del mundo del cine',
            ],
            [
                'name'        => 'Reseñas',
                'slug'        => 'resenas', // mejor sin ñ para URLs/rutas
                'description' => 'Críticas de películas y series',
            ],
            [
                'name'        => 'Estrenos',
                'slug'        => 'estrenos',
                'description' => 'Películas recién estrenadas',
            ],
            [
                'name'        => 'Trailers',
                'slug'        => 'trailers',
                'description' => 'Últimos trailers publicados',
            ],
        ];

        $sections = [];
        foreach ($sectionsData as $data) {
            $sections[] = Section::firstOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }

        // ---------------------------
        // 4. Asignar secciones a roles (tabla role_sections)
        // ---------------------------

        // Admin: puede ver y gestionar todas las secciones
        if ($adminRole) {
            foreach ($sections as $section) {
                $adminRole->sections()->syncWithoutDetaching([
                    $section->id => [
                        'can_view'   => true,
                        'can_manage' => true,
                    ],
                ]);
            }
        }

        // Editor: puede ver y gestionar solo Reseñas y Noticias (ejemplo)
        if ($editorRole) {
            foreach ($sections as $section) {
                $canManage = in_array($section->slug, ['resenas', 'noticias']);

                $editorRole->sections()->syncWithoutDetaching([
                    $section->id => [
                        'can_view'   => true,
                        'can_manage' => $canManage,
                    ],
                ]);
            }
        }

        // Visitante: solo puede ver todas las secciones, sin gestionar
        if ($visitRole) {
            foreach ($sections as $section) {
                $visitRole->sections()->syncWithoutDetaching([
                    $section->id => [
                        'can_view'   => true,
                        'can_manage' => false,
                    ],
                ]);
            }
        }
    }
}
