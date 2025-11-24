<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Panel de Administración
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Tarjetas de métricas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-5 shadow">
                    <p class="text-sm text-gray-400">Usuarios registrados</p>
                    <p class="mt-2 text-3xl font-bold text-white">
                        {{ $totalUsers }}
                    </p>
                </div>

                <div class="bg-gray-800 border border-gray-700 rounded-lg p-5 shadow">
                    <p class="text-sm text-gray-400">Secciones creadas</p>
                    <p class="mt-2 text-3xl font-bold text-white">
                        {{ $totalSections }}
                    </p>
                </div>

                <div class="bg-gray-800 border border-gray-700 rounded-lg p-5 shadow">
                    <p class="text-sm text-gray-400">Blogs / Reseñas</p>
                    <p class="mt-2 text-3xl font-bold text-white">
                        {{ $totalBlogs }}
                    </p>
                </div>
            </div>

            {{-- Últimos posts --}}
            <div class="bg-gray-800 border border-gray-700 rounded-lg shadow">
                <div class="px-5 py-4 border-b border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">
                        Últimos blogs / reseñas creados
                    </h3>
                    {{-- Aquí más adelante pondremos un botón "Ver todos" --}}
                </div>

                <div class="divide-y divide-gray-700">
                    @forelse ($latestBlogs as $blog)
                        <div class="px-5 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-white font-medium">
                                    {{ $blog->title }}
                                </p>
                                <p class="text-sm text-gray-400">
                                    Sección: {{ $blog->section?->name ?? 'Sin sección' }} ·
                                    Autor: {{ $blog->author?->name ?? 'Sin autor' }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    Publicado: {{ $blog->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="mt-2 sm:mt-0">
                                @if ($blog->is_published)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-600/20 text-green-400">
                                        Publicado
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-yellow-600/20 text-yellow-400">
                                        Borrador
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="px-5 py-4 text-sm text-gray-400">
                            Aún no hay blogs ni reseñas creados.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
