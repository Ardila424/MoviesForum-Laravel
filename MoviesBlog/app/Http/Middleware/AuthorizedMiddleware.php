<?php

namespace App\Http\Middleware;

use App\Helpers\RoleHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthorizedMiddleware
{
    /**
     * Maneja la solicitud entrante.
     * Verifica si el usuario está autenticado y tiene el permiso específico requerido.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $permission  Permiso requerido en formato "Módulo.acción"
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $permission = null): Response
    {
        // Valida si hay sesión activa
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Si se especificó un permiso, verificar si el usuario lo tiene
        if (!empty($permission)) {
            $isAuthorized = RoleHelper::isAuthorized($permission);

            if (!$isAuthorized) {
                abort(403, 'No tienes autorización para acceder a este recurso.');
            }
        }

        return $next($request);
    }
}
