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

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Contenido
                        </label>
                        <textarea name="content" rows="6"
                            class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 text-sm">{{ old('content', $blog->content) }}</textarea>
                        @error('content')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

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
</x-app-layout>
