<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /**
         * Aquí puedes personalizar middleware globales, grupos o alias.
         * Laravel ya registra por defecto 'auth', 'verified', 'guest', etc.
         * Solo añadimos nuestro alias extra para roles.
         */
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Aquí podrías personalizar el manejo de excepciones si lo necesitas.
    })
    ->create();
