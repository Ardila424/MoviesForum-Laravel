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

// ===================== ZONA ADMIN (con permisos granulares) =====================
// Las rutas ahora verifican permisos específicos usando AuthorizedMiddleware
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Panel principal admin (requiere estar autenticado, sin permiso específico)
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // Gestión de Usuarios (con permisos granulares)
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])
            ->name('users.index')
            ->middleware('authorized:Usuarios.showUsers');
        Route::get('/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])
            ->name('users.create')
            ->middleware('authorized:Usuarios.createUsers');
        Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])
            ->name('users.store')
            ->middleware('authorized:Usuarios.createUsers');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])
            ->name('users.edit')
            ->middleware('authorized:Usuarios.updateUsers');
        Route::put('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])
            ->name('users.update')
            ->middleware('authorized:Usuarios.updateUsers');

        // Gestión de Roles (con permisos granulares)
        Route::get('/roles', [\App\Http\Controllers\Admin\RoleController::class, 'index'])
            ->name('roles.index')
            ->middleware('authorized:Roles.showRoles');
        Route::get('/roles/create', [\App\Http\Controllers\Admin\RoleController::class, 'create'])
            ->name('roles.create')
            ->middleware('authorized:Roles.createRoles');
        Route::post('/roles', [\App\Http\Controllers\Admin\RoleController::class, 'store'])
            ->name('roles.store')
            ->middleware('authorized:Roles.createRoles');
        Route::get('/roles/{role}/edit', [\App\Http\Controllers\Admin\RoleController::class, 'edit'])
            ->name('roles.edit')
            ->middleware('authorized:Roles.updateRoles');
        Route::put('/roles/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'update'])
            ->name('roles.update')
            ->middleware('authorized:Roles.updateRoles');
        Route::delete('/roles/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'destroy'])
            ->name('roles.destroy')
            ->middleware('authorized:Roles.deleteRoles');

        // CRUD de secciones (con permisos granulares)
        Route::get('/sections', [SectionController::class, 'index'])
            ->name('sections.index')
            ->middleware('authorized:Secciones.showSections');
        Route::get('/sections/create', [SectionController::class, 'create'])
            ->name('sections.create')
            ->middleware('authorized:Secciones.createSections');
        Route::post('/sections', [SectionController::class, 'store'])
            ->name('sections.store')
            ->middleware('authorized:Secciones.createSections');
        Route::get('/sections/{section}/edit', [SectionController::class, 'edit'])
            ->name('sections.edit')
            ->middleware('authorized:Secciones.updateSections');
        Route::put('/sections/{section}', [SectionController::class, 'update'])
            ->name('sections.update')
            ->middleware('authorized:Secciones.updateSections');
        Route::delete('/sections/{section}', [SectionController::class, 'destroy'])
            ->name('sections.destroy')
            ->middleware('authorized:Secciones.deleteSections');

        // CRUD de blogs (con permisos granulares)
        Route::get('/blogs', [BlogController::class, 'index'])
            ->name('blogs.index')
            ->middleware('authorized:Blogs.showBlogs');
        Route::get('/blogs/create', [BlogController::class, 'create'])
            ->name('blogs.create')
            ->middleware('authorized:Blogs.createBlogs');
        Route::post('/blogs', [BlogController::class, 'store'])
            ->name('blogs.store')
            ->middleware('authorized:Blogs.createBlogs');
        Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])
            ->name('blogs.edit')
            ->middleware('authorized:Blogs.updateBlogs');
        Route::put('/blogs/{blog}', [BlogController::class, 'update'])
            ->name('blogs.update')
            ->middleware('authorized:Blogs.updateBlogs');
        Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])
            ->name('blogs.destroy')
            ->middleware('authorized:Blogs.deleteBlogs');

        // Búsqueda de películas en TMDB (AJAX)
        Route::get('/tmdb/search', [TmdbController::class, 'search'])
            ->name('tmdb.search');
    });
// =======================================================================

require __DIR__.'/auth.php';
