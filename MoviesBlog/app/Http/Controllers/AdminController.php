<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Section;
use App\Models\Blog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Muestra el panel principal de administración.
     */
    public function index()
    {
        $user = auth()->user();

        // Solo admin puede ver esto
        if (! $user || ! $user->hasRole('admin')) {
            abort(403, 'No tienes permisos para acceder al panel de administración.');
        }

        // Métricas simples para mostrar en el dashboard admin
        $totalUsers    = User::count();
        $totalSections = Section::count();
        $totalBlogs    = Blog::count();

        $latestBlogs = Blog::with('author', 'section')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.index', [
    'totalUsers'    => $totalUsers,
    'totalSections' => $totalSections,
    'totalBlogs'    => $totalBlogs,
    'latestBlogs'   => $latestBlogs,
]);
    }
}
