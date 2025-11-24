<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;
use Illuminate\Http\Request;

class TmdbController extends Controller
{
    public function __construct(protected TmdbService $tmdb)
    {
    }

    /**
     * Búsqueda de películas en TMDB por nombre (usado vía AJAX).
     */
    public function search(Request $request)
    {
        $query = trim((string) $request->query('q', ''));

        if (mb_strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $apiResult = $this->tmdb->searchMovies($query);

        if (! $apiResult) {
            return response()->json(['results' => []]);
        }

        $mapped = collect($apiResult['results'] ?? [])
            ->take(4)  // Limitar a 4 películas
            ->map(function ($movie) {
                return [
                    'id'            => $movie['id'] ?? null,
                    'title'         => $movie['title'] ?? ($movie['original_title'] ?? 'Sin título'),
                    'original_title'=> $movie['original_title'] ?? null,
                    'poster_path'   => $movie['poster_path'] ?? null,  // ¡Agregado!
                    'release_date'  => $movie['release_date'] ?? null,
                    'vote_average'  => $movie['vote_average'] ?? null,
                ];
            })
            ->values()
            ->all();

        return response()->json(['results' => $mapped]);
    }
}
