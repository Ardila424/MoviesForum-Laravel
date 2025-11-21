@extends('layouts.app')

@section('title', $blog->title . ' | MoviesBlog')

@section('content')
    @php
        $tmdbImageBase = config('services.tmdb.image_url', 'https://image.tmdb.org/t/p');
    @endphp

    {{-- Banner si hay backdrop --}}
    @if ($blog->tmdb_backdrop_path)
        <div class="mb-6 overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
            <div class="relative">
                <img src="{{ $tmdbImageBase }}/w780{{ $blog->tmdb_backdrop_path }}"
                    alt="Fondo de {{ $blog->tmdb_title ?? $blog->title }}" class="w-full h-48 md:h-60 object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                <div class="absolute bottom-3 left-4">
                    <p class="text-xs uppercase tracking-wide text-slate-200 mb-1">
                        Reseña de película
                    </p>
                    <h1 class="text-xl md:text-2xl font-bold text-white drop-shadow">
                        {{ $blog->title }}
                    </h1>
                </div>
            </div>
        </div>
    @endif

    <article class="max-w-4xl mx-auto bg-white border border-slate-200 shadow-sm rounded-2xl p-6 md:p-8">
        {{-- Encabezado / metadatos --}}
        @if (!$blog->tmdb_backdrop_path)
            <header class="mb-4">
                <p class="text-xs text-slate-500 mb-1">
                    {{ $blog->section?->name ?? 'Sin sección' }}
                    · {{ $blog->author?->name ?? 'Autor desconocido' }}
                    · {{ optional($blog->published_at ?? $blog->created_at)->format('d/m/Y') }}
                </p>

                <h1 class="text-2xl md:text-3xl font-bold text-slate-900">
                    {{ $blog->title }}
                </h1>
            </header>
        @else
            <header class="mb-4">
                <p class="text-xs text-slate-500 mb-1">
                    {{ $blog->section?->name ?? 'Sin sección' }}
                    · {{ $blog->author?->name ?? 'Autor desconocido' }}
                    · {{ optional($blog->published_at ?? $blog->created_at)->format('d/m/Y') }}
                </p>
            </header>
        @endif

        {{-- Rating propio --}}
        @if ($blog->rating)
            <p class="text-sm text-purple-700 font-medium mb-2">
                ⭐ Calificación personal: {{ $blog->rating }}/10
            </p>
        @endif

        {{-- Bloque TMDB --}}
        @if ($blog->tmdb_id)
            <section class="mb-6 rounded-xl border border-purple-100 bg-purple-50/70 px-4 py-4">
                <div class="flex flex-col md:flex-row gap-4">
                    {{-- Poster --}}
                    @if ($blog->tmdb_poster_path)
                        <div class="w-full md:w-40 lg:w-44 flex-shrink-0">
                            <img src="{{ $tmdbImageBase }}/w342{{ $blog->tmdb_poster_path }}"
                                alt="Póster de {{ $blog->tmdb_title ?? $blog->title }}"
                                class="w-full rounded-lg shadow-sm border border-purple-100">
                        </div>
                    @endif

                    {{-- Info TMDB --}}
                    <div class="flex-1 text-sm text-slate-800">
                        <p class="text-xs uppercase tracking-wide text-purple-700 font-semibold mb-1">
                            Datos de la película (TMDB)
                        </p>

                        <p class="text-base font-semibold text-slate-900">
                            {{ $blog->tmdb_title ?? $blog->title }}
                            @if ($blog->tmdb_release_date)
                                <span class="text-sm font-normal text-slate-600">
                                    ({{ \Illuminate\Support\Str::substr($blog->tmdb_release_date, 0, 4) }})
                                </span>
                            @endif
                        </p>

                        @if ($blog->tmdb_original_title && $blog->tmdb_original_title !== $blog->tmdb_title)
                            <p class="text-xs text-slate-500 mt-1">
                                Título original: <span class="italic">{{ $blog->tmdb_original_title }}</span>
                            </p>
                        @endif

                        @if ($blog->tmdb_vote_average)
                            <p class="mt-2 text-sm text-purple-800">
                                ⭐ Puntuación TMDB:
                                <span class="font-semibold">{{ number_format($blog->tmdb_vote_average, 1) }}/10</span>
                            </p>
                        @endif

                        @if ($blog->tmdb_release_date)
                            <p class="mt-1 text-xs text-slate-600">
                                Estreno: {{ \Carbon\Carbon::parse($blog->tmdb_release_date)->format('d/m/Y') }}
                            </p>
                        @endif

                        {{-- Link a TMDB --}}
                        <div class="mt-3">
                            <a href="https://www.themoviedb.org/movie/{{ $blog->tmdb_id }}" target="_blank"
                                class="inline-flex items-center text-xs font-semibold text-purple-700 hover:text-purple-900">
                                Ver película en TMDB
                                <span class="ml-1">↗</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- Extracto --}}
        @if ($blog->excerpt)
            <p class="italic text-sm text-slate-600 mb-4 border-l-4 border-purple-200 pl-3">
                “{{ $blog->excerpt }}”
            </p>
        @endif

        {{-- Contenido --}}
        <div class="text-sm md:text-base leading-relaxed text-slate-800 space-y-3">
            {!! nl2br(e($blog->content)) !!}
        </div>

        <footer class="mt-6 flex justify-between items-center text-xs text-slate-500">
            <a href="{{ url()->previous() }}" class="text-purple-700 hover:text-purple-900 hover:underline">
                ← Volver
            </a>
            <span>
                Publicado el {{ optional($blog->published_at ?? $blog->created_at)->format('d/m/Y H:i') }}
            </span>
        </footer>
    </article>

    {{-- Sección de Comentarios --}}
    <section class="max-w-4xl mx-auto mt-8">
        <div class="bg-white border border-purple-100 shadow-sm rounded-2xl p-6 md:p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                Comentarios ({{ $blog->comments->count() }})
            </h2>

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Lista de comentarios existentes --}}
            @if($blog->comments->count() > 0)
                <div class="space-y-4 mb-8">
                    @foreach($blog->comments()->latest()->get() as $comment)
                        <div class="bg-purple-50/50 border border-purple-100 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                {{-- Avatar --}}
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($comment->user ? $comment->user->name : $comment->author_name, 0, 1)) }}
                                    </div>
                                </div>
                                
                                {{-- Contenido --}}
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-semibold text-gray-900">
                                            {{ $comment->user ? $comment->user->name : $comment->author_name }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-700">{{ $comment->content }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8 mb-8">
                    Sé el primero en comentar sobre esta reseña 💬
                </p>
            @endif

            {{-- Formulario para agregar comentario --}}
            <div class="border-t border-purple-100 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Deja tu comentario</h3>
                
                <form action="{{ route('comments.store', $blog->id) }}" method="POST">
                    @csrf

                    {{-- Si no está autenticado, pedir nombre y email --}}
                    @guest
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="author_name">
                                    Tu nombre <span class="text-purple-600">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="author_name" 
                                    name="author_name" 
                                    value="{{ old('author_name') }}"
                                    class="w-full px-4 py-2 border-2 border-purple-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none @error('author_name') border-red-500 @enderror"
                                    placeholder="Juan Pérez"
                                    required>
                                @error('author_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="author_email">
                                    Tu email <span class="text-purple-600">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="author_email" 
                                    name="author_email" 
                                    value="{{ old('author_email') }}"
                                    class="w-full px-4 py-2 border-2 border-purple-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none @error('author_email') border-red-500 @enderror"
                                    placeholder="tu@email.com"
                                    required>
                                @error('author_email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endguest

                    {{-- Área de texto del comentario --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="content">
                            Comentario <span class="text-purple-600">*</span>
                        </label>
                        <textarea 
                            id="content" 
                            name="content" 
                            rows="4"
                            class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none @error('content') border-red-500 @enderror"
                            placeholder="Comparte tu opinión sobre esta reseña..."
                            required>{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button 
                        type="submit" 
                        class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-purple-500/50 transition-all">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Publicar Comentario
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
