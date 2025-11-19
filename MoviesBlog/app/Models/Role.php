<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Section;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')
                    ->withTimestamps();
    }
    public function sections()
    {
    return $this->belongsToMany(Section::class, 'role_sections')
                ->withPivot(['can_view', 'can_manage'])
                ->withTimestamps();
    }

}
