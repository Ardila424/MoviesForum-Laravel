<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_sections')
                    ->withPivot(['can_view', 'can_manage'])
                    ->withTimestamps();
    }
}
