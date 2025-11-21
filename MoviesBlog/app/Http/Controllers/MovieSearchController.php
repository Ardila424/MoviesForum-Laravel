<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovieSearchController extends Controller
{
    /**
     * Muestra la vista de búsqueda de películas
     */
    public function index()
    {
        // Obtener IDs de favoritos del usuario si está autenticado
        $userFavorites = [];
        if (auth()->check()) {
            $userFavorites = auth()->user()->favorites()->pluck('tmdb_id')->toArray();
        }

        return view('movies.search', compact('userFavorites'));
    }
}
