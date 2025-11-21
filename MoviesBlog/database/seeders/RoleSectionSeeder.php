<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Section;

class RoleSectionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Role::where('slug', 'admin')->first();
        $creator = Role::where('slug', 'content_creator')->first();
        $user = Role::where('slug', 'user')->first();

        $sections = Section::all();

        // Admin: acceso completo a todas las secciones
        foreach ($sections as $section) {
            $admin->sections()->syncWithoutDetaching([
                $section->id => ['can_view' => true, 'can_manage' => true]
            ]);
        }

        // Content Creator: solo puede manejar Reseñas
        $reviews = Section::where('slug', 'resenas')->first();
        if ($reviews) {
            $creator->sections()->syncWithoutDetaching([
                $reviews->id => ['can_view' => true, 'can_manage' => true]
            ]);
        }

        // Usuario normal: solo puede ver todo
        foreach ($sections as $section) {
            $user->sections()->syncWithoutDetaching([
                $section->id => ['can_view' => true, 'can_manage' => false]
            ]);
        }
    }
}
