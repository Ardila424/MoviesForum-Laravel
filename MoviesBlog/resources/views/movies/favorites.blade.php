<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Mis Películas Favoritas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="bg-white rounded-xl shadow-lg border border-purple-100 p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                            <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                            Mis Favoritas
                        </h1>
                        <p class="text-gray-600 mt-1">{{ $favorites->count() }} {{ $favorites->count() === 1 ? 'película' : 'películas' }}</p>
                    </div>
                    <a href="{{ route('movies.search') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-purple-500/50 transition-all">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Buscar Más
                        </span>
                    </a>
                </div>
            </div>

            {{-- Lista de favoritos --}}
            @if($favorites->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                    @foreach($favorites as $favorite)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                            <div class="relative group">
                                @if($favorite->tmdb_poster_path)
                                    <img src="{{ $favorite->poster_url }}" 
                                         alt="{{ $favorite->tmdb_title }}" 
                                         class="w-full h-80 object-cover">
                                @else
                                    <div class="w-full h-80 bg-gradient-to-br from-purple-200 to-purple-400 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 mb-1 line-clamp-2 min-h-[3rem]">{{ $favorite->tmdb_title }}</h3>
                                <div class="flex items-center justify-between text-sm text-gray-600 mb-3">
                                    @if($favorite->tmdb_release_date)
                                        <span>{{ $favorite->tmdb_release_date->format('Y') }}</span>
                                    @else
                                        <span>N/A</span>
                                    @endif
                                    @if($favorite->tmdb_vote_average)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            {{ $favorite->tmdb_vote_average }}
                                        </span>
                                    @endif
                                </div>
                                
                                <button 
                                    onclick="removeFavorite({{ $favorite->tmdb_id }}, this)"
                                    class="w-full py-2 px-4 rounded-lg font-semibold bg-red-100 text-red-700 border-2 border-red-300 hover:bg-red-200 transition-all duration-300">
                                    <span class="flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Quitar
                                    </span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Estado vacío --}}
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-purple-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">No tienes favoritas aún</h3>
                    <p class="text-gray-500 mb-6">Comienza a buscar y agregar tus películas favoritas</p>
                    <a href="{{ route('movies.search') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg hover:shadow-purple-500/50 transition-all">
                        Buscar Películas
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Script para quitar favoritos --}}
    <script>
        async function removeFavorite(tmdbId, button) {
            if (!confirm('¿Estás seguro de quitar esta película de favoritos?')) {
                return;
            }

            try {
                const response = await fetch(`/movies/favorites/${tmdbId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Eliminar la card con animación
                    const card = button.closest('.bg-white');
                    card.classList.add('opacity-0', 'scale-75');
                    setTimeout(() => {
                        card.remove();
                        
                        // Si no quedan más favoritos, recargar la página para mostrar estado vacío
                        if (document.querySelectorAll('.grid .bg-white').length === 0) {
                            location.reload();
                        } else {
                            // Actualizar contador
                            const count = document.querySelectorAll('.grid .bg-white').length;
                            document.querySelector('h1 + p').textContent = `${count} ${count === 1 ? 'película' : 'películas'}`;
                        }
                    }, 300);
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error al quitar de favoritos', 'error');
            }
        }

        function showNotification(message, type) {
            const notif = document.createElement('div');
            notif.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notif.textContent = message;
            document.body.appendChild(notif);
            
            setTimeout(() => {
                notif.remove();
            }, 3000);
        }
    </script>
</x-app-layout>
