<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

// ==== RUTA DE PRUEBA PARA VER ROLES, PERMISOS Y USUARIOS ====
Route::get('/test', function () {
    // Traemos todos los roles con sus permisos
    $roles = Role::with('permissions')->get();

    // Todos los permisos
    $permissions = Permission::all();

    // Todos los usuarios con su rol
    $users = User::with('role')->get();

    return view('test', compact('roles', 'permissions', 'users'));
})->name('test');
// ============================================================

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
