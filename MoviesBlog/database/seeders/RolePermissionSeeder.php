<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // -----------------------------------------
        // 1. Crear roles base del sistema
        // -----------------------------------------
        $roles = [
            ['name' => 'Administrador', 'slug' => 'admin'],
            ['name' => 'Editor',        'slug' => 'editor'],
            ['name' => 'Visitante',     'slug' => 'visitante'],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(['slug' => $roleData['slug']], $roleData);
        }

        $admin = Role::where('slug', 'admin')->first();
        $editor = Role::where('slug', 'editor')->first();

        // -----------------------------------------
        // 2. Crear permisos del sitio de cine/blog
        // -----------------------------------------
        $permissionsList = [
            // Secciones (categorías)
            ['name' => 'Ver secciones',      'slug' => 'ver-secciones'],
            ['name' => 'Crear secciones',    'slug' => 'crear-secciones'],
            ['name' => 'Editar secciones',   'slug' => 'editar-secciones'],
            ['name' => 'Eliminar secciones', 'slug' => 'eliminar-secciones'],

            // Posts / Reviews / Noticias
            ['name' => 'Ver posts',          'slug' => 'ver-posts'],
            ['name' => 'Crear posts',        'slug' => 'crear-posts'],
            ['name' => 'Editar posts',       'slug' => 'editar-posts'],
            ['name' => 'Eliminar posts',     'slug' => 'eliminar-posts'],

            // Usuarios / Administración
            ['name' => 'Gestionar usuarios', 'slug' => 'gestionar-usuarios'],
        ];

        foreach ($permissionsList as $perm) {
            Permission::firstOrCreate(['slug' => $perm['slug']], $perm);
        }

        $allPermissions = Permission::all();

        // -----------------------------------------
        // 3. Asignar permisos a roles
        // -----------------------------------------

        // ADMIN → TODO
        $admin->permissions()->sync($allPermissions->pluck('id'));

        // EDITOR → solo permisos de posts + secciones (no borrar usuarios)
        $editor->permissions()->sync(
            $allPermissions->whereIn('slug', [
                'ver-secciones',
                'crear-secciones',
                'editar-secciones',

                'ver-posts',
                'crear-posts',
                'editar-posts',
            ])->pluck('id')
        );

        // VISITANTE → sin permisos (solo ve contenido público)
        // relación queda vacía
    }
}
