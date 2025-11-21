<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class RoleHelper
{
    /**
     * Verifica si el usuario autenticado tiene el permiso especificado.
     *
     * @param  string  $permission  Permiso en formato "Módulo.acción" (ej: "Blogs.createBlogs")
     * @return bool
     */
    public static function isAuthorized(string $permission): bool
    {
        $user = Auth::user();

        // Si no hay usuario autenticado, no está autorizado
        if (!$user) {
            return false;
        }

        // Verificar si el usuario tiene el permiso
        return $user->hasPermission($permission);
    }
}
