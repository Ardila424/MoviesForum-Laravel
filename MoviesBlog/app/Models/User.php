<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * Atributos ocultos.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts modernos (Laravel 10+)
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Hash automático
        ];
    }

    /**
     * Relación: un usuario pertenece a un rol.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Verificar rol por slug.
     */
    public function hasRole(string $slug): bool
    {
        return $this->role && $this->role->slug === $slug;
    }

    /**
     * Verificar permiso del usuario.
     */
    public function hasPermission(string $permissionSlug): bool
    {
        if (! $this->role) {
            return false;
        }

        return $this->role->permissions->contains('slug', $permissionSlug);
    }

    /**
     * Relación: Un usuario tiene muchos favoritos
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
