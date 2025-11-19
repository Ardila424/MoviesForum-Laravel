<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Roles base
        $admin = Role::create([
            'name' => 'Administrador',
            'slug' => 'admin',
            'description' => 'Acceso total al sistema',
            'is_active' => true,
        ]);

        $userManager = Role::create([
            'name' => 'Gestor de usuarios',
            'slug' => 'user_manager',
            'description' => 'Gestiona usuarios',
            'is_active' => true,
        ]);

        $contentCreator = Role::create([
            'name' => 'Creador de contenido',
            'slug' => 'content_creator',
            'description' => 'Crea y gestiona blogs/secciones',
            'is_active' => true,
        ]);

        $basicUser = Role::create([
            'name' => 'Usuario',
            'slug' => 'user',
            'description' => 'Usuario estándar del sitio de películas',
            'is_active' => true,
        ]);

        // Ejemplo de algunos permisos (luego agregamos más según la matriz)
        $perms = [
            ['name' => 'Ver usuarios', 'slug' => 'users.index'],
            ['name' => 'Crear usuario', 'slug' => 'users.create'],
            ['name' => 'Editar usuario', 'slug' => 'users.edit'],
            ['name' => 'Eliminar usuario', 'slug' => 'users.delete'],
        ];

        $permissions = collect($perms)->map(fn ($p) => Permission::create($p));

        // Asignar todos los permisos al admin
        $admin->permissions()->sync($permissions->pluck('id'));
    }
}
