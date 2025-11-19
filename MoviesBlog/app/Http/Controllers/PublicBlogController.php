<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Section;
use Illuminate\Http\Request;

class PublicBlogController extends Controller
{
    /**
     * Página principal pública.
     * Muestra los últimos blogs publicados.
     */
    public function index()
    {
        $blogs = Blog::with('author', 'section')
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->paginate(6);

        $sections = Section::orderBy('name')->get();

        return view('public.home', compact('blogs', 'sections'));
    }

    /**
     * Listar blogs por sección.
     */
    public function bySection(string $slug)
    {
        $section = Section::where('slug', $slug)->firstOrFail();

        $blogs = Blog::with('author', 'section')
            ->where('section_id', $section->id)
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->paginate(6);

        $sections = Section::orderBy('name')->get();

        return view('public.home', compact('blogs', 'sections', 'section'));
    }

    /**
     * Detalle de un blog.
     */
    public function show(string $slug)
    {
        $blog = Blog::with('author', 'section')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('public.blog-show', compact('blog'));
    }
}
