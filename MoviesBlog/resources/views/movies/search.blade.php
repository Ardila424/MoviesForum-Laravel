<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Buscar Películas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header con buscador más pequeño y cuadrado --}}
            <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-lg shadow-lg p-4 mb-6">
                <div class="max-w-xl mx-auto">
                    <div class="relative">
                        <input 
                            type="text" 
                            id="movieSearch" 
                            placeholder="Buscar película..."
                            class="w-full px-4 py-3 pr-12 rounded-lg border-2 border-purple-300 focus:border-white focus:ring-2 focus:ring-purple-300 focus:outline-none"
                            autocomplete="off">
                        <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Loading indicator --}}
            <div id="loadingIndicator" class="hidden text-center py-8">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600"></div>
                <p class="text-gray-600 mt-2">Buscando películas...</p>
            </div>

            {{-- Resultados de búsqueda (máximo 4 columnas) --}}
            <div id="searchResults" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                {{-- Se llenará con JavaScript --}}
            </div>

            {{-- Mensaje inicial --}}
            <div id="emptyState" class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-purple-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Busca tu película favorita</h3>
                <p class="text-gray-500">Los resultados aparecerán aquí</p>
            </div>
        </div>
    </div>

    {{-- Script para búsqueda AJAX --}}
    <script>
        // IDs de favoritos del usuario (desde PHP)
        const userFavorites = @json($userFavorites);
        const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};

        const searchInput = document.getElementById('movieSearch');
        const searchResults = document.getElementById('searchResults');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const emptyState = document.getElementById('emptyState');
        let searchTimeout;

        // Debounce para búsqueda
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(searchTimeout);

            if (query.length < 2) {
                searchResults.innerHTML = '';
                emptyState.classList.remove('hidden');
                loadingIndicator.classList.add('hidden');
                return;
            }

            loadingIndicator.classList.remove('hidden');
            emptyState.classList.add('hidden');

            searchTimeout = setTimeout(() => {
                searchMovies(query);
            }, 500);
        });

        // Buscar películas en TMDB
        async function searchMovies(query) {
            try {
                const response = await fetch(`/api/tmdb/search?q=${encodeURIComponent(query)}`);
                const data = await response.json();
                
                loadingIndicator.classList.add('hidden');
                
                if (data.results && data.results.length > 0) {
                    renderResults(data.results);
                } else {
                    searchResults.innerHTML = `
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500">No se encontraron resultados para "${query}"</p>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error:', error);
                loadingIndicator.classList.add('hidden');
                searchResults.innerHTML = `
                    <div class="col-span-full text-center py-8">
                        <p class="text-red-500">Error al buscar películas. Intenta de nuevo.</p>
                    </div>
                `;
            }
        }

        // Renderizar resultados
        function renderResults(movies) {
            searchResults.innerHTML = movies.map(movie => {
                const isFavorite = userFavorites.includes(movie.id);
                const posterUrl = movie.poster_path 
                    ? `https://image.tmdb.org/t/p/w342${movie.poster_path}`
                    : 'https://via.placeholder.com/342x513?text=Sin+Poster';
                
                const releaseYear = movie.release_date ? new Date(movie.release_date).getFullYear() : 'N/A';
                
                return `
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                        <div class="relative group">
                            <img src="${posterUrl}" 
                                 alt="${movie.title}" 
                                 class="w-full h-80 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 mb-1 line-clamp-2 min-h-[3rem]">${movie.title}</h3>
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-3">
                                <span>${releaseYear}</span>
                                ${movie.vote_average ? `<span class="flex items-center gap-1"><svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>${movie.vote_average}</span>` : ''}
                            </div>
                            
                            ${isAuthenticated ? `
                                <button 
                                    onclick="toggleFavorite(${movie.id}, '${movie.title}', '${movie.poster_path || ''}', '${movie.release_date || ''}', ${movie.vote_average || 0}, this)"
                                    class="w-full py-2 px-4 rounded-lg font-semibold transition-all duration-300 ${isFavorite 
                                        ? 'bg-purple-100 text-purple-700 border-2 border-purple-300'
                                        : 'bg-purple-600 text-white hover:bg-purple-700'}"
                                    data-movie-id="${movie.id}">
                                    ${isFavorite 
                                        ? '<span class="flex items-center justify-center gap-2"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>En Favoritos</span>'
                                        : '<span class="flex items-center justify-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>Agregar a Favoritos</span>'}
                                </button>
                            ` : `
                                <a href="/login" class="block w-full py-2 px-4 rounded-lg font-semibold bg-gray-200 text-gray-700 text-center hover:bg-gray-300">
                                    Inicia sesión para agregar
                                </a>
                            `}
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Toggle favorito
        async function toggleFavorite(tmdbId, title, posterPath, releaseDate, voteAverage, button) {
            const isFavorite = userFavorites.includes(tmdbId);
            
            try {
                if (isFavorite) {
                    // Eliminar de favoritos
                    const response = await fetch(`/movies/favorites/${tmdbId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        userFavorites.splice(userFavorites.indexOf(tmdbId), 1);
                        button.className = 'w-full py-2 px-4 rounded-lg font-semibold transition-all duration-300 bg-purple-600 text-white hover:bg-purple-700';
                        button.innerHTML = '<span class="flex items-center justify-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>Agregar a Favoritos</span>';
                        showNotification(data.message, 'success');
                    }
                } else {
                    // Agregar a favoritos
                    const response = await fetch('/movies/favorites', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            tmdb_id: tmdbId,
                            tmdb_title: title,
                            tmdb_poster_path: posterPath,
                            tmdb_release_date: releaseDate,
                            tmdb_vote_average: voteAverage
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        userFavorites.push(tmdbId);
                        button.className = 'w-full py-2 px-4 rounded-lg font-semibold transition-all duration-300 bg-purple-100 text-purple-700 border-2 border-purple-300';
                        button.innerHTML = '<span class="flex items-center justify-center gap-2"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>En Favoritos</span>';
                        showNotification(data.message, 'success');
                    } else {
                        showNotification(data.message, 'error');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error al procesar la solicitud', 'error');
            }
        }

        // Mostrar notificación
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
