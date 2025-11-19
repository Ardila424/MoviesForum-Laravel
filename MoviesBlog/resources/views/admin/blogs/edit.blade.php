<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            Editar blog / reseña
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <form method="POST" action="{{ route('admin.blogs.update', $blog) }}">
                    @csrf
                    @method('PUT')

                    {{-- Título --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Título
                        </label>
                        <input type="text" name="title" value="{{ old('title', $blog->title) }}"
                            class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 text-sm">
                        @error('title')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Sección --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Sección
                        </label>
                        <select name="section_id"
                            class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 text-sm">
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}"
                                    {{ old('section_id', $blog->section_id) == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('section_id')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Buscar película en TMDB --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Buscar película en TMDB
                        </label>
                        <input type="text" id="tmdb-search"
                            placeholder="Escribe el nombre de la película para cambiarla (opcional)"
                            class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 text-sm">

                        <div id="tmdb-results"
                            class="mt-2 border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 max-h-60 overflow-y-auto text-sm hidden">
                        </div>

                        <p id="tmdb-selected" class="mt-2 text-xs text-green-500 dark:text-green-400">
                            @if ($blog->tmdb_id)
                                Película actual: {{ $blog->tmdb_title ?? $blog->title }}
                                @if ($blog->tmdb_release_date)
                                    ({{ \Illuminate\Support\Str::substr($blog->tmdb_release_date, 0, 4) }})
                                @endif
                                · ID TMDB: {{ $blog->tmdb_id }}
                            @else
                                No hay película de TMDB asociada todavía.
                            @endif
                        </p>

                        <input type="hidden" name="tmdb_id" id="tmdb_id"
                            value="{{ old('tmdb_id', $blog->tmdb_id) }}">

                        @error('tmdb_id')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Extracto --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Extracto
                        </label>
                        <textarea name="excerpt" rows="2"
                            class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 text-sm">{{ old('excerpt', $blog->excerpt) }}</textarea>
                        @error('excerpt')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contenido --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Contenido
                        </label>
                        <textarea name="content" rows="6"
                            class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 text-sm">{{ old('content', $blog->content) }}</textarea>
                        @error('content')
                            <pclass="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Rating + Publicado --}}
                    <div class="mb-4 flex gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Calificación (1–10)
                            </label>
                            <input type="number" name="rating" min="1" max="10"
                                value="{{ old('rating', $blog->rating) }}"
                                class="mt-1 w-24 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 text-sm">
                            @error('rating')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-end">
                            <label class="inline-flex items-center text-sm text-gray-700 dark:text-gray-300 mt-6">
                                <input type="checkbox" name="is_published" value="1"
                                    class="rounded border-gray-300 dark:border-gray-600"
                                    {{ old('is_published', $blog->is_published) ? 'checked' : '' }}>
                                <span class="ml-2">Publicado</span>
                            </label>
                        </div>
                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-end gap-3 mt-6">
                        <a href="{{ route('admin.blogs.index') }}"
                            class="px-4 py-2 text-sm rounded border border-gray-400 text-gray-700 dark:text-gray-200">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-4 py-2 text-sm rounded bg-blue-600 text-white hover:bg-blue-700">
                            Actualizar blog
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('tmdb-search');
            const resultsBox = document.getElementById('tmdb-results');
            const tmdbIdInput = document.getElementById('tmdb_id');
            const selectedInfo = document.getElementById('tmdb-selected');

            if (!searchInput) return;

            let timeoutId = null;

            searchInput.addEventListener('input', () => {
                const q = searchInput.value.trim();
                clearTimeout(timeoutId);

                if (q.length < 2) {
                    resultsBox.innerHTML = '';
                    resultsBox.classList.add('hidden');
                    return;
                }

                timeoutId = setTimeout(() => {
                    fetch(`{{ route('admin.tmdb.search') }}?q=${encodeURIComponent(q)}`)
                        .then(res => res.json())
                        .then(data => {
                            resultsBox.innerHTML = '';

                            const results = data.results || [];

                            if (!results.length) {
                                resultsBox.classList.add('hidden');
                                return;
                            }

                            resultsBox.classList.remove('hidden');

                            results.forEach(movie => {
                                const btn = document.createElement('button');
                                btn.type = 'button';
                                btn.className =
                                    'w-full text-left px-2 py-1 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 rounded';

                                const year = movie.release_date ? movie.release_date
                                    .substring(0, 4) : 'sin año';
                                const vote = movie.vote_average !== null && movie
                                    .vote_average !== undefined ?
                                    ` · TMDB ${Number(movie.vote_average).toFixed(1)}/10` :
                                    '';

                                btn.textContent = `${movie.title} (${year})${vote}`;

                                btn.addEventListener('click', () => {
                                    tmdbIdInput.value = movie.id;
                                    selectedInfo.textContent =
                                        `Película seleccionada: ${movie.title} (${year})${vote}`;
                                    resultsBox.innerHTML = '';
                                    resultsBox.classList.add('hidden');
                                });

                                resultsBox.appendChild(btn);
                            });
                        })
                        .catch(err => {
                            console.error('Error buscando en TMDB:', err);
                            resultsBox.classList.add('hidden');
                        });
                }, 400);
            });
        });
    </script>
</x-app-layout>
