<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SectionController extends Controller
{
    /**
     * Muestra el listado de secciones (panel admin).
     */
    public function index()
    {
        $sections = Section::orderBy('name')->paginate(10);

        return view('admin.sections.index', compact('sections'));
    }

    /**
     * Formulario para crear una nueva sección.
     */
    public function create()
    {
        return view('admin.sections.create');
    }

    /**
     * Guarda una nueva sección en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Section::create($validated);

        return redirect()
            ->route('admin.sections.index')
            ->with('success', 'Sección creada correctamente.');
    }

    /**
     * Formulario para editar una sección existente.
     */
    public function edit(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    /**
     * Actualiza una sección.
     */
    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $section->update($validated);

        return redirect()
            ->route('admin.sections.index')
            ->with('success', 'Sección actualizada correctamente.');
    }

    /**
     * Elimina una sección.
     */
    public function destroy(Section $section)
    {
        // Más adelante podemos validar si tiene blogs asociados, etc.
        $section->delete();

        return redirect()
            ->route('admin.sections.index')
            ->with('success', 'Sección eliminada correctamente.');
    }
}
