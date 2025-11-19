<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Listado de blogs / reseñas
     */
    public function index()
    {
        $user = auth()->user();

        if (! $user || (! $user->hasRole('admin') && ! $user->hasRole('editor'))) {
            abort(403, 'No tienes permisos para ver esta página.');
        }

        // Admin ve todos, editor solo los suyos
        $query = Blog::with('author', 'section')->orderByDesc('created_at');

        if ($user->hasRole('editor') && ! $user->hasRole('admin')) {
            $query->where('user_id', $user->id);
        }

        $blogs = $query->paginate(10);

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $user = auth()->user();

        if (! $user || (! $user->hasRole('admin') && ! $user->hasRole('editor'))) {
            abort(403);
        }

        $sections = Section::orderBy('name')->get();

        return view('admin.blogs.create', compact('sections'));
    }

    /**
     * Guardar nuevo blog
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (! $user || (! $user->hasRole('admin') && ! $user->hasRole('editor'))) {
            abort(403);
        }

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'section_id'  => ['required', 'exists:sections,id'],
            'excerpt'     => ['nullable', 'string', 'max:500'],
            'content'     => ['required', 'string'],
            'rating'      => ['nullable', 'integer', 'min:1', 'max:10'],
            'is_published'=> ['nullable', 'boolean'],
        ]);

        $slugBase = Str::slug($validated['title']);
        $slug = $this->generateUniqueSlug($slugBase);

        $blog = Blog::create([
            'user_id'      => $user->id,
            'section_id'   => $validated['section_id'],
            'title'        => $validated['title'],
            'slug'         => $slug,
            'excerpt'      => $validated['excerpt'] ?? null,
            'content'      => $validated['content'],
            'rating'       => $validated['rating'] ?? null,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ? now() : null,
        ]);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'El blog/reseña se creó correctamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit(Blog $blog)
    {
        $user = auth()->user();

        if (! $user || (! $user->hasRole('admin') && ! $user->hasRole('editor'))) {
            abort(403);
        }

        // Editor solo puede editar sus propios posts
        if ($user->hasRole('editor') && ! $user->hasRole('admin') && $blog->user_id !== $user->id) {
            abort(403);
        }

        $sections = Section::orderBy('name')->get();

        return view('admin.blogs.edit', compact('blog', 'sections'));
    }

    /**
     * Actualizar blog
     */
    public function update(Request $request, Blog $blog)
    {
        $user = auth()->user();

        if (! $user || (! $user->hasRole('admin') && ! $user->hasRole('editor'))) {
            abort(403);
        }

        if ($user->hasRole('editor') && ! $user->hasRole('admin') && $blog->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'section_id'  => ['required', 'exists:sections,id'],
            'excerpt'     => ['nullable', 'string', 'max:500'],
            'content'     => ['required', 'string'],
            'rating'      => ['nullable', 'integer', 'min:1', 'max:10'],
            'is_published'=> ['nullable', 'boolean'],
        ]);

        // Si cambia el título, opcionalmente podemos actualizar el slug
        if ($blog->title !== $validated['title']) {
            $slugBase = Str::slug($validated['title']);
            $blog->slug = $this->generateUniqueSlug($slugBase, $blog->id);
        }

        $blog->section_id   = $validated['section_id'];
        $blog->title        = $validated['title'];
        $blog->excerpt      = $validated['excerpt'] ?? null;
        $blog->content      = $validated['content'];
        $blog->rating       = $validated['rating'] ?? null;
        $blog->is_published = $request->boolean('is_published');
        $blog->published_at = $request->boolean('is_published')
            ? ($blog->published_at ?? now())
            : null;

        $blog->save();

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'El blog/reseña se actualizó correctamente.');
    }

    /**
     * Eliminar blog
     */
    public function destroy(Blog $blog)
    {
        $user = auth()->user();

        if (! $user || (! $user->hasRole('admin') && ! $user->hasRole('editor'))) {
            abort(403);
        }

        if ($user->hasRole('editor') && ! $user->hasRole('admin') && $blog->user_id !== $user->id) {
            abort(403);
        }

        $blog->delete();

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'El blog/reseña se eliminó correctamente.');
    }

    /**
     * Generar slug único
     */
    protected function generateUniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = $baseSlug;
        $i = 1;

        while (
            Blog::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        return $slug;
    }
}
