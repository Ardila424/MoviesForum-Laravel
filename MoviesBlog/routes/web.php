<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

// Página principal pública
Route::get('/', function () {
    return view('welcome');
})->name('home');

// -------- RUTA DE TEST PARA VER ROLES / PERMISOS / USUARIOS --------
Route::get('/test', function () {
    $roles = Role::with('permissions')->get();
    $permissions = Permission::all();
    $users = User::with('role')->get();
    return view('test', compact('roles', 'permissions', 'users'));
})->name('test');
// -------------------------------------------------------------------

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

        // CRUD de secciones (Noticias, Reseñas, Estrenos...)
        Route::resource('sections', SectionController::class)->except(['show']);

        // 👉 CRUD de blogs / reseñas
        Route::resource('blogs', BlogController::class)->except(['show']);
    });
// =======================================================================

require __DIR__ . '/auth.php';
