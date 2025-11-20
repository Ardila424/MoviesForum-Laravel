<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Crear Nuevo Rol') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg border border-purple-100 overflow-hidden">
                <div class="p-8">

                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <strong class="font-bold">¡Ups!</strong>
                            <span class="block sm:inline">Por favor corrige los siguientes errores:</span>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf

                        <!-- Nombre -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                Nombre del Rol
                                <span class="text-purple-600">*</span>
                            </label>
                            <input 
                                class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none @error('name') border-red-500 @enderror" 
                                id="name" 
                                name="name" 
                                type="text" 
                                value="{{ old('name') }}" 
                                placeholder="Ejemplo: Moderador"
                                required>
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="slug">
                                Slug (identificador único)
                                <span class="text-purple-600">*</span>
                            </label>
                            <input 
                                class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none @error('slug') border-red-500 @enderror" 
                                id="slug" 
                                name="slug" 
                                type="text" 
                                value="{{ old('slug') }}" 
                                placeholder="moderador (solo letras, números, guiones)"
                                required>
                            <p class="text-gray-500 text-xs mt-1">Solo letras minúsculas, números y guiones. Sin espacios.</p>
                            @error('slug')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="mb-8">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                                Descripción (opcional)
                            </label>
                            <textarea 
                                class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none @error('description') border-red-500 @enderror" 
                                id="description" 
                                name="description" 
                                rows="4"
                                placeholder="Describe brevemente las responsabilidades de este rol...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Info adicional -->
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-6">
                            <p class="text-sm text-purple-800">
                                <svg class="inline w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <strong>Nota:</strong> Después de crear el rol, podrás asignarle permisos específicos desde la lista de roles.
                            </p>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center justify-between gap-4">
                            <button 
                                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-purple-500/50" 
                                type="submit">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Crear Rol
                                </span>
                            </button>
                            <a 
                                href="{{ route('admin.roles.index') }}" 
                                class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-6 rounded-lg">
                                Cancelar
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
