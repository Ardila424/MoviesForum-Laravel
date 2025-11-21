@extends('layouts.app')

@section('title', 'Secciones')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Secciones</h1>

        <a href="{{ route('admin.sections.create') }}"
            class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
            + Nueva sección
        </a>
    </div>

    @if ($sections->isEmpty())
        <p class="text-sm text-gray-600">Aún no hay secciones creadas.</p>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Nombre</th>
                        <th class="px-4 py-2 text-left">Slug</th>
                        <th class="px-4 py-2 text-left">Descripción</th>
                        <th class="px-4 py-2 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sections as $section)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $section->name }}</td>
                            <td class="px-4 py-2 text-gray-500">{{ $section->slug }}</td>
                            <td class="px-4 py-2">
                                <span class="text-gray-700">
                                    {{ Str::limit($section->description, 80) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right space-x-2">
                                <a href="{{ route('admin.sections.edit', $section) }}"
                                    class="text-blue-600 hover:underline text-sm">
                                    Editar
                                </a>

                                <form action="{{ route('admin.sections.destroy', $section) }}" method="POST" class="inline"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar esta sección?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $sections->links() }}
        </div>
    @endif
@endsection
