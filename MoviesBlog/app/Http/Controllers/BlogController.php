<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Section;
use App\Services\TmdbService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    protected TmdbService $tmdb;

    public function __construct(TmdbService $tmdb)
    {
        $this->tmdb = $tmdb;
    }

    /**
     * Listado de blogs / reseñas en el admin.
     */
    public function index()
    {
        $user = auth()->user();
        $query = Blog::with('author', 'section')->orderByDesc('created_at');

        // Los editores solo ven sus propios blogs
        if ($user->hasRole('editor') && ! $user->hasRole('admin')) {
            $query->where('user_id', $user->id);
        }

        $blogs = $query->paginate(10);

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        $sections = Section::orderBy('name')->get();

        return view('admin.blogs.create', compact('sections'));
    }

    /**
     * Guardar nuevo blog.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'section_id'   => ['required', 'exists:sections,id'],
            'excerpt'      => ['nullable', 'string', 'max:500'],
            'content'      => ['required', 'string'],
            'rating'       => ['nullable', 'integer', 'min:1', 'max:10'],
            'is_published' => ['nullable', 'boolean'],
            'tmdb_id'      => ['nullable', 'integer', 'min:1'],
        ]);

        $slugBase = Str::slug($validated['title']);
        $slug     = $this->generateUniqueSlug($slugBase);

        // Datos de TMDB si se pasó tmdb_id
        $tmdbData = null;
        if (! empty($validated['tmdb_id'])) {
            $tmdbData = $this->tmdb->getMovieById((int) $validated['tmdb_id']);
        }

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

            // Campos TMDB
            'tmdb_id'             => $tmdbData['id'] ?? null,
            'tmdb_title'          => $tmdbData['title'] ?? null,
            'tmdb_original_title' => $tmdbData['original_title'] ?? null,
            'tmdb_poster_path'    => $tmdbData['poster_path'] ?? null,
            'tmdb_backdrop_path'  => $tmdbData['backdrop_path'] ?? null,
            'tmdb_vote_average'   => $tmdbData['vote_average'] ?? null,
            'tmdb_release_date'   => $tmdbData['release_date'] ?? null,
        ]);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'El blog/reseña se creó correctamente.');
    }

    /**
     * Formulario de edición.
     */
    public function edit(Blog $blog)
    {
        $user = auth()->user();

        // Los editores solo pueden editar sus propios blogs
        if ($user->hasRole('editor') && ! $user->hasRole('admin') && $blog->user_id !== $user->id) {
            abort(403, 'No puedes editar blogs de otros usuarios.');
        }

        $sections = Section::orderBy('name')->get();

        return view('admin.blogs.edit', compact('blog', 'sections'));
    }

    /**
     * Actualizar blog.
     */
    public function update(Request $request, Blog $blog)
    {
        $user = auth()->user();

        // Los editores solo pueden actualizar sus propios blogs
        if ($user->hasRole('editor') && ! $user->hasRole('admin') && $blog->user_id !== $user->id) {
            abort(403, 'No puedes editar blogs de otros usuarios.');
        }

        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'section_id'   => ['required', 'exists:sections,id'],
            'excerpt'      => ['nullable', 'string', 'max:500'],
            'content'      => ['required', 'string'],
            'rating'       => ['nullable', 'integer', 'min:1', 'max:10'],
            'is_published' => ['nullable', 'boolean'],
            'tmdb_id'      => ['nullable', 'integer', 'min:1'],
        ]);

        // Slug si cambia el título
        if ($blog->title !== $validated['title']) {
            $slugBase   = Str::slug($validated['title']);
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

        // Si se pasó tmdb_id, refrescar datos de TMDB
        $tmdbData = null;
        if (! empty($validated['tmdb_id'])) {
            $tmdbData = $this->tmdb->getMovieById((int) $validated['tmdb_id']);
        }

        if ($tmdbData) {
            $blog->tmdb_id             = $tmdbData['id'] ?? null;
            $blog->tmdb_title          = $tmdbData['title'] ?? null;
            $blog->tmdb_original_title = $tmdbData['original_title'] ?? null;
            $blog->tmdb_poster_path    = $tmdbData['poster_path'] ?? null;
            $blog->tmdb_backdrop_path  = $tmdbData['backdrop_path'] ?? null;
            $blog->tmdb_vote_average   = $tmdbData['vote_average'] ?? null;
            $blog->tmdb_release_date   = $tmdbData['release_date'] ?? null;
        }

        $blog->save();

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'El blog/reseña se actualizó correctamente.');
    }

    /**
     * Eliminar blog.
     */
    public function destroy(Blog $blog)
    {
        $user = auth()->user();

        // Los editores solo pueden eliminar sus propios blogs
        if ($user->hasRole('editor') && ! $user->hasRole('admin') && $blog->user_id !== $user->id) {
            abort(403, 'No puedes eliminar blogs de otros usuarios.');
        }

        $blog->delete();

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'El blog/reseña se eliminó correctamente.');
    }

    /**
     * Generar slug único.
     */
    protected function generateUniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = $baseSlug;
        $i    = 1;

        while (
            Blog::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
