<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'section_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'rating',
        'is_published',
        'published_at',
        // Campos TMDB
        'tmdb_id',
        'tmdb_title',
        'tmdb_original_title',
        'tmdb_poster_path',
        'tmdb_backdrop_path',
        'tmdb_vote_average',
        'tmdb_release_date',
    ];

    protected $casts = [
        'is_published'       => 'boolean',
        'published_at'       => 'datetime',
        'tmdb_vote_average'  => 'decimal:1',
        'tmdb_release_date'  => 'date',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
