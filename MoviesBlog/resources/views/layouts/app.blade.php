<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Movies Blog')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 text-gray-900">

    <nav class="bg-gray-900 text-white px-6 py-4 flex justify-between">
        <div class="font-bold">
            <a href="{{ route('home') }}">🎬 MoviesBlog</a>
        </div>
        <div class="space-x-4 text-sm">
            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
                @if (auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.index') }}">Admin</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button class="text-red-300 hover:text-red-100">Salir</button>
                </form>
            @else
                <a href="{{ route('login') }}">Ingresar</a>
                <a href="{{ route('register') }}">Registrarse</a>
            @endauth
        </div>
    </nav>

    <main class="max-w-6xl mx-auto py-8 px-4">
        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 text-green-800 px-4 py-2 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>

</html>
