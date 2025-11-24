@extends('layouts.app')

@section('title', isset($section) ? 'Sección: ' . $section->name . ' | MoviesBlog' : 'MoviesBlog')

@section('content')
    @php
        $tmdbImageBase = config('services.tmdb.image_url', 'https://image.tmdb.org/t/p');
    @endphp

    {{-- Hero / encabezado --}}
    <section
        class="mb-8 rounded-2xl bg-gradient-to-r from-purple-100 via-fuchsia-50 to-sky-50 border border-purple-100 px-6 py-6">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 mb-2">
            @isset($section)
                {{ $section->name }}
            @else
                Reseñas y noticias de cine
            @endisset
        </h1>
        <p class="text-sm text-slate-600 max-w-2xl">
            Explora reseñas, estrenos y noticias del mundo del cine. Toda la información se enriquece con datos reales
            de <span class="font-semibold text-purple-700">TMDB</span>.
        </p>
    </section>

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Sidebar de secciones --}}
        <aside class="w-full lg:w-1/4">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-4">
                <h2 class="text-sm font-semibold text-slate-800 mb-3">
                    Secciones
                </h2>
                <ul class="space-y-1 text-sm">
                    <li>
                        <a href="{{ route('home') }}"
                            class="block rounded-lg px-3 py-1.5
                           {{ !isset($section) ? 'bg-purple-100 text-purple-800 font-semibold' : 'text-slate-700 hover:bg-slate-100' }}">
                            Todas
                        </a>
                    </li>
                    @foreach ($sections as $sec)
                        <li>
                            <a href="{{ route('section.public', $sec->slug) }}"
                                class="block rounded-lg px-3 py-1.5
                               {{ isset($section) && $section->id === $sec->id
                                   ? 'bg-purple-100 text-purple-800 font-semibold'
                                   : 'text-slate-700 hover:bg-slate-100' }}">
                                {{ $sec->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        {{-- Listado de blogs --}}
        <section class="w-full lg:w-3/4">
            @if ($blogs->isEmpty())
                <div class="bg-white border border-slate-200 rounded-2xl p-6 text-sm text-slate-500">
                    Aún no hay publicaciones en esta sección.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach ($blogs as $blog)
                        <article
                            class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">
                            {{-- Imagen / poster --}}
                            @if ($blog->tmdb_poster_path)
                                <div class="aspect-[3/4] w-full overflow-hidden">
                                    <img src="{{ $tmdbImageBase }}/w342{{ $blog->tmdb_poster_path }}"
                                        alt="Póster de {{ $blog->tmdb_title ?? $blog->title }}"
                                        class="h-full w-full object-cover transition-transform duration-300 hover:scale-105">
                                </div>
                            @else
                                <div
                                    class="aspect-[3/4] w-full bg-gradient-to-br from-purple-100 via-slate-100 to-fuchsia-100 flex items-center justify-center text-4xl">
                                    🎬
                                </div>
                            @endif

                            {{-- Contenido de la tarjeta --}}
                            <div class="flex-1 flex flex-col p-4">
                                {{-- Chips arriba --}}
                                <div class="flex items-center gap-2 mb-2">
                                    @if ($blog->section)
                                        <span
                                            class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-medium text-slate-700">
                                            {{ $blog->section->name }}
                                        </span>
                                    @endif

                                    @if ($blog->tmdb_vote_average)
                                        <span
                                            class="inline-flex items-center rounded-full bg-purple-100 px-2 py-0.5 text-[11px] font-medium text-purple-700">
                                            ⭐ {{ number_format($blog->tmdb_vote_average, 1) }}/10 TMDB
                                        </span>
                                    @endif

                                    @if ($blog->tmdb_release_date)
                                        <span
                                            class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-medium text-slate-600">
                                            {{ \Illuminate\Support\Str::substr($blog->tmdb_release_date, 0, 4) }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Título --}}
                                <a href="{{ route('blog.show', $blog->slug) }}"
                                    class="text-base font-semibold text-slate-900 hover:text-purple-700 line-clamp-2">
                                    {{ $blog->title }}
                                </a>

                                {{-- Autor / fecha --}}
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $blog->author?->name ?? 'Autor desconocido' }}
                                    · {{ optional($blog->published_at ?? $blog->created_at)->format('d/m/Y') }}
                                </p>

                                {{-- Extracto --}}
                                <p class="mt-2 text-sm text-slate-600 line-clamp-3 flex-1">
                                    @if ($blog->excerpt)
                                        {{ \Illuminate\Support\Str::limit($blog->excerpt, 150) }}
                                    @else
                                        {{ \Illuminate\Support\Str::limit(strip_tags($blog->content), 150) }}
                                    @endif
                                </p>

                                {{-- Botón leer más --}}
                                <div class="mt-3 flex justify-between items-center">
                                    <a href="{{ route('blog.show', $blog->slug) }}"
                                        class="inline-flex items-center text-xs font-semibold text-purple-700 hover:text-purple-800">
                                        Leer reseña
                                        <span class="ml-1">→</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Paginación --}}
                <div class="mt-6">
                    {{ $blogs->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection
