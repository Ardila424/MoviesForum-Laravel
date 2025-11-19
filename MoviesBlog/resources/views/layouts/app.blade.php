<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Movies Blog')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 text-slate-900">

    {{-- Navbar principal --}}
    <nav class="bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            {{-- Logo / brand --}}
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span
                        class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-purple-500/10 border border-purple-400/40">
                        🎬
                    </span>
                    <span class="font-bold text-lg tracking-tight text-purple-700">
                        MoviesBlog
                    </span>
                </a>
            </div>

            {{-- Links derecha --}}
            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('home') }}" class="text-slate-700 hover:text-purple-600">
                    Inicio
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="text-slate-700 hover:text-purple-600">
                        Dashboard
                    </a>

                    @if (auth()->user()->hasRole('admin'))
                        <div class="relative group">
                            <button class="text-slate-700 hover:text-purple-600 flex items-center gap-1 py-2">
                                Admin ▾
                            </button>
                            <div class="absolute right-0 top-full w-48 bg-white rounded-md shadow-lg py-1 hidden group-hover:block z-50 border border-gray-100">
                                <a href="{{ route('admin.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50">Panel Principal</a>
                                <a href="{{ route('admin.blogs.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50">Blogs / Reseñas</a>
                                <a href="{{ route('admin.sections.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50">Secciones</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50">Usuarios</a>
                                <a href="{{ route('admin.roles.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50">Roles y Permisos</a>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="text-rose-500 hover:text-rose-600">
                            Salir
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-slate-700 hover:text-purple-600">
                        Ingresar
                    </a>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center rounded-full border border-purple-300 bg-purple-50 px-3 py-1 text-xs font-medium text-purple-700 hover:bg-purple-100">
                        Registrarse
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Contenedor principal --}}
    <main class="max-w-6xl mx-auto py-8 px-4">
        @if (session('success'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 px-4 py-2 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header que usa x-app-layout (Breeze) --}}
        @isset($header)
            <header class="mb-6">
                {{ $header }}
            </header>
        @endisset

        {{--
            Soportar AMBOS modos:
            - Vistas públicas: @extends('layouts.app') -> @section('content')
            - Vistas internas (admin/dashboard): <x-app-layout> -> {{ $slot }}
        --}}
        @php
            $hasSectionContent = trim($__env->yieldContent('content')) !== '';
        @endphp

        @if ($hasSectionContent)
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>
</body>

</html>
