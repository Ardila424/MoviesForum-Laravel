<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Crear Nuevo Usuario') }}
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

                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <!-- Nombre -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                Nombre Completo
                                <span class="text-purple-600">*</span>
                            </label>
                            <input 
                                class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none @error('name') border-red-500 @enderror" 
                                id="name" 
                                name="name" 
                                type="text" 
                                value="{{ old('name') }}" 
                                placeholder="Juan Pérez"
                                required>
                            @error('name')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                Correo Electrónico
                                <span class="text-purple-600">*</span>
                            </label>
                            <input 
                                class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none @error('email') border-red-500 @enderror" 
                                id="email" 
                                name="email" 
                                type="email" 
                                value="{{ old('email') }}" 
                                placeholder="usuario@ejemplo.com"
                                required>
                            @error('email')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                Contraseña
                                <span class="text-purple-600">*</span>
                            </label>
                            <input 
                                class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none @error('password') border-red-500 @enderror" 
                                id="password" 
                                name="password" 
                                type="password"
                                placeholder="Mínimo 8 caracteres"
                                required>
                            @error('password')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                                Confirmar Contraseña
                                <span class="text-purple-600">*</span>
                            </label>
                            <input 
                                class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none" 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                type="password"
                                placeholder="Repite la contraseña"
                                required>
                        </div>

                        <!-- Rol -->
                        <div class="mb-8">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="role_id">
                                Rol
                                <span class="text-purple-600">*</span>
                            </label>
                            <select 
                                name="role_id" 
                                id="role_id" 
                                class="w-full px-4 py-3 border-2 border-purple-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 focus:outline-none @error('role_id') border-red-500 @enderror"
                                required>
                                <option value="">Selecciona un rol</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
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
                                    Crear Usuario
                                </span>
                            </button>
                            <a 
                                href="{{ route('admin.users.index') }}" 
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
