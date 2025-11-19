@extends('layouts.app')

@section('title', 'Panel de administración')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Panel de administración</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('admin.sections.index') }}" class="block bg-white rounded-lg shadow p-4 hover:shadow-md transition">
            <h2 class="font-semibold">Secciones</h2>
            <p class="text-sm text-gray-600 mt-1">
                Gestiona categorías como Reseñas, Noticias, Estrenos, etc.
            </p>
        </a>

        {{-- Más tarjetas después: Usuarios, Películas, Reseñas, etc. --}}
    </div>
@endsection
