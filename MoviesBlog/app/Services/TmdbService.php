<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TmdbService
{
    protected string $baseUrl;
    protected ?string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.tmdb.base_url', env('TMDB_BASE_URL', 'https://api.themoviedb.org/3'));
        $this->apiKey  = config('services.tmdb.api_key', env('TMDB_API_KEY'));
    }

    /**
     * Obtener una película por ID de TMDB.
     */
    public function getMovieById(int $tmdbId, string $language = 'es-ES'): ?array
    {
        if (! $this->apiKey) {
            return null;
        }

        // Leer si debemos verificar SSL o no (controlled via .env)
        $verify = config('services.tmdb.verify_ssl', true);

        $response = Http::withOptions([
            'verify' => $verify,
        ])->get("{$this->baseUrl}/movie/{$tmdbId}", [
            'api_key'  => $this->apiKey,
            'language' => $language,
        ]);

        if (! $response->successful()) {
            return null;
        }

        return $response->json();
    }

    /**
     * Buscar películas por nombre en TMDB.
     */
    public function searchMovies(string $query, int $page = 1, string $language = 'es-ES'): ?array
    {
        if (! $this->apiKey) {
            return null;
        }

        $verify = config('services.tmdb.verify_ssl', true);

        $response = Http::withOptions([
            'verify' => $verify,
        ])->get("{$this->baseUrl}/search/movie", [
            'api_key'       => $this->apiKey,
            'language'      => $language,
            'query'         => $query,
            'page'          => $page,
            'include_adult' => false,
        ]);

        if (! $response->successful()) {
            return null;
        }

        return $response->json();
    }
}
