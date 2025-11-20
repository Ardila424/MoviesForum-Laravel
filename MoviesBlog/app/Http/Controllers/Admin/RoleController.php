<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Muestra la lista de roles.
     */
    public function index()
    {
        $roles = Role::withCount('users')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Muestra el formulario para crear un nuevo rol.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Guarda un nuevo rol en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles|alpha_dash',
            'description' => 'nullable|string|max:500',
        ]);

        // Crear el rol
        Role::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rol creado correctamente.');
    }

    /**
     * Muestra el formulario para editar los permisos de un rol.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Actualiza los permisos del rol.
     */
    public function update(Request $request, Role $role)
    {
        // Validamos que 'permissions' sea un array (puede estar vacío si se quitan todos)
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Sincronizamos los permisos (elimina los que no estén y agrega los nuevos)
        $role->permissions()->sync($request->input('permissions', []));

        return redirect()->route('admin.roles.index')
            ->with('success', 'Permisos del rol actualizados correctamente.');
    }

    /**
     * Elimina un rol de la base de datos.
     * Valida que no tenga usuarios asociados antes de eliminar.
     */
    public function destroy(Role $role)
    {
        // Verificar si el rol tiene usuarios asociados
        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'No se puede eliminar el rol porque tiene usuarios asociados.');
        }

        // Eliminar el rol
        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Rol eliminado correctamente.');
    }
}
