<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    /**
     * Campos asignables masivamente
     */
    protected $fillable = [
        'user_id',
        'tmdb_id',
        'tmdb_title',
        'tmdb_poster_path',
        'tmdb_release_date',
        'tmdb_vote_average',
    ];

    /**
     * Casts de tipos
     */
    protected $casts = [
        'tmdb_release_date' => 'date',
        'tmdb_vote_average' => 'decimal:1',
    ];

    /**
     * Relación: Un favorito pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor: Obtener la URL completa del póster
     */
    public function getPosterUrlAttribute()
    {
        if (!$this->tmdb_poster_path) {
            return null;
        }

        $tmdbImageBase = config('services.tmdb.image_url', 'https://image.tmdb.org/t/p');
        return "{$tmdbImageBase}/w342{$this->tmdb_poster_path}";
    }
}
