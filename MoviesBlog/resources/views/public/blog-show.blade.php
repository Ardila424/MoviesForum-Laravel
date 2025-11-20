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
@endsection
