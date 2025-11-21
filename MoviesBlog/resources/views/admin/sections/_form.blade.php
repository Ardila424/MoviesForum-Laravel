@csrf

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Nombre de la sección
    </label>
    <input type="text" name="name" value="{{ old('name', $section->name ?? '') }}"
        class="w-full border rounded px-3 py-2 text-sm @error('name') border-red-500 @enderror"
        placeholder="Ej: Reseñas, Noticias, Estrenos" required>
    @error('name')
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Descripción
    </label>
    <textarea name="description" rows="3"
        class="w-full border rounded px-3 py-2 text-sm @error('description') border-red-500 @enderror"
        placeholder="Descripción opcional de la sección">{{ old('description', $section->description ?? '') }}</textarea>
    @error('description')
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="flex justify-end gap-2">
    <a href="{{ route('admin.sections.index') }}" class="px-4 py-2 text-sm border rounded hover:bg-gray-50">
        Cancelar
    </a>

    <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
        Guardar
    </button>
</div>
