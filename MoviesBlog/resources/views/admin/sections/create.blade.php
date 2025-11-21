@extends('layouts.app')

@section('title', 'Nueva sección')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Crear nueva sección</h1>

    <div class="bg-white rounded-lg shadow p-4">
        <form action="{{ route('admin.sections.store') }}" method="POST">
            @include('admin.sections._form', ['section' => new \App\Models\Section()])
        </form>
    </div>
@endsection
