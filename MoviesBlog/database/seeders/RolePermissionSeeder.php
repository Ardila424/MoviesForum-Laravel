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
        // 2. Crear permisos granulares del sitio
        // Estructura: Módulo.acciónMódulo
        // -----------------------------------------

        // Permisos de Blogs
        $showBlogs = Permission::firstOrCreate(
            ['slug' => 'Blogs.showBlogs'],
            ['name' => 'Ver Blogs', 'description' => 'Ver listado de blogs']
        );
        $createBlogs = Permission::firstOrCreate(
            ['slug' => 'Blogs.createBlogs'],
            ['name' => 'Crear Blogs', 'description' => 'Crear nuevos blogs']
        );
        $updateBlogs = Permission::firstOrCreate(
            ['slug' => 'Blogs.updateBlogs'],
            ['name' => 'Editar Blogs', 'description' => 'Editar blogs existentes']
        );
        $deleteBlogs = Permission::firstOrCreate(
            ['slug' => 'Blogs.deleteBlogs'],
            ['name' => 'Eliminar Blogs', 'description' => 'Eliminar blogs']
        );

        // Permisos de Secciones
        $showSections = Permission::firstOrCreate(
            ['slug' => 'Secciones.showSections'],
            ['name' => 'Ver Secciones', 'description' => 'Ver listado de secciones']
        );
        $createSections = Permission::firstOrCreate(
            ['slug' => 'Secciones.createSections'],
            ['name' => 'Crear Secciones', 'description' => 'Crear nuevas secciones']
        );
        $updateSections = Permission::firstOrCreate(
            ['slug' => 'Secciones.updateSections'],
            ['name' => 'Editar Secciones', 'description' => 'Editar secciones existentes']
        );
        $deleteSections = Permission::firstOrCreate(
            ['slug' => 'Secciones.deleteSections'],
            ['name' => 'Eliminar Secciones', 'description' => 'Eliminar secciones']
        );

        // Permisos de Usuarios
        $showUsers = Permission::firstOrCreate(
            ['slug' => 'Usuarios.showUsers'],
            ['name' => 'Ver Usuarios', 'description' => 'Ver listado de usuarios']
        );
        $createUsers = Permission::firstOrCreate(
            ['slug' => 'Usuarios.createUsers'],
            ['name' => 'Crear Usuarios', 'description' => 'Crear nuevos usuarios']
        );
        $updateUsers = Permission::firstOrCreate(
            ['slug' => 'Usuarios.updateUsers'],
            ['name' => 'Editar Usuarios', 'description' => 'Editar usuarios existentes']
        );

        // Permisos de Roles
        $showRoles = Permission::firstOrCreate(
            ['slug' => 'Roles.showRoles'],
            ['name' => 'Ver Roles', 'description' => 'Ver listado de roles']
        );
        $createRoles = Permission::firstOrCreate(
            ['slug' => 'Roles.createRoles'],
            ['name' => 'Crear Roles', 'description' => 'Crear nuevos roles']
        );
        $updateRoles = Permission::firstOrCreate(
            ['slug' => 'Roles.updateRoles'],
            ['name' => 'Editar Roles', 'description' => 'Editar roles y permisos']
        );
        $deleteRoles = Permission::firstOrCreate(
            ['slug' => 'Roles.deleteRoles'],
            ['name' => 'Eliminar Roles', 'description' => 'Eliminar roles']
        );

        $allPermissions = Permission::all();

        // -----------------------------------------
        // 3. Asignar permisos a roles
        // -----------------------------------------

        // ADMIN → Todos los permisos
        $admin->permissions()->sync($allPermissions->pluck('id'));

        // EDITOR → Solo ver, crear y editar blogs; ver secciones
        $editor->permissions()->sync([
            $showBlogs->id,
            $createBlogs->id,
            $updateBlogs->id,
            $showSections->id,
        ]);

        // VISITANTE → sin permisos (solo ve contenido público)
        // relación queda vacía
    }
}
