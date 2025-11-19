<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed de la base de datos de la aplicación.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name'  => 'Admin Demo',
            'email' => 'admin@example.com',
            'password' => 'password', // con el cast 'hashed' se cifra solo
            'role_id' => 1, // por ejemplo, rol administrador
        ]);

        // Seeder para roles y permisos / RolePermissionSeeder
        $this->call(RolePermissionSeeder::class);


    }
}
