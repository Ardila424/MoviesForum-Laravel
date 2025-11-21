@extends('layouts.app')

@section('title', 'Editar sección')

@section('content')
    <h1 class="text-2xl font-bold mb-4">
        Editar sección: {{ $section->name }}
    </h1>

    <div class="bg-white rounded-lg shadow p-4">
        <form action="{{ route('admin.sections.update', $section) }}" method="POST">
            @method('PUT')
            @include('admin.sections._form', ['section' => $section])
        </form>
    </div>
@endsection
