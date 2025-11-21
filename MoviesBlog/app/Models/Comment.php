<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Campos asignables masivamente
     */
    protected $fillable = [
        'blog_id',
        'user_id',
        'author_name',
        'author_email',
        'content',
    ];

    /**
     * Relación: Un comentario pertenece a un blog
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    /**
     * Relación: Un comentario pertenece a un usuario (nullable)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor: Obtener el nombre del autor
     * Si es usuario autenticado, usar su nombre, sino el nombre del visitante
     */
    public function getAuthorNameAttribute($value)
    {
        return $this->user ? $this->user->name : $value;
    }
}
