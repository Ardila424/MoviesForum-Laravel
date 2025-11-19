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
    ];

    /**
     * Relación con blogs (cuando creemos el modelo Blog).
     * Una sección tiene muchos blogs/artículos.
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
