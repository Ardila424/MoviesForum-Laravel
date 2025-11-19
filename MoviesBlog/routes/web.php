<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PublicBlogController;
use App\Http\Controllers\TmdbController;
use Illuminate\Support\Facades\Route;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

// Página principal pública: últimos blogs publicados
Route::get('/', [PublicBlogController::class, 'index'])->name('home');

// Listar por sección
Route::get('/seccion/{slug}', [PublicBlogController::class, 'bySection'])
    ->name('section.public');

// Detalle público del blog
Route::get('/blog/{slug}', [PublicBlogController::class, 'show'])
    ->name('blog.show');



// Dashboard para usuarios autenticados
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===================== ZONA ADMIN (solo rol admin) =====================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Panel principal admin
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // Gestión de Usuarios y Roles
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);

        // CRUD de secciones
        Route::resource('sections', SectionController::class)->except(['show']);

        // CRUD de blogs
        Route::resource('blogs', BlogController::class)->except(['show']);

        // Búsqueda de películas en TMDB (AJAX)
        Route::get('/tmdb/search', [TmdbController::class, 'search'])
            ->name('tmdb.search');
    });
// =======================================================================

require __DIR__.'/auth.php';
