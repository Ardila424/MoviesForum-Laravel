<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Verifica que el usuario autenticado tenga alguno de los roles dados.
     * Uso en rutas: ->middleware('role:admin') o ->middleware('role:admin,content_creator')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'No autenticado.');
        }

        // Si el user no tiene rol asociado, bloqueamos
        if (! $user->role) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        // Si el slug del rol del usuario está dentro de la lista, pasa
        if (in_array($user->role->slug, $roles, true)) {
            return $next($request);
        }

        abort(403, 'No tienes permisos para acceder a esta sección.');
    }
}
