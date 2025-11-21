<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Muestra los favoritos del usuario autenticado
     */
    public function index()
    {
        $favorites = auth()->user()->favorites()->latest()->get();
        return view('movies.favorites', compact('favorites'));
    }

    /**
     * Agrega una película a favoritos
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tmdb_id' => 'required|integer',
            'tmdb_title' => 'required|string|max:255',
            'tmdb_poster_path' => 'nullable|string',
            'tmdb_release_date' => 'nullable|date',
            'tmdb_vote_average' => 'nullable|numeric|min:0|max:10',
        ]);

        // Verificar si ya existe en favoritos
        $exists = auth()->user()->favorites()
            ->where('tmdb_id', $validated['tmdb_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Esta película ya está en tus favoritos'
            ], 409);
        }

        // Crear favorito
        $favorite = auth()->user()->favorites()->create($validated);

        return response()->json([
            'success' => true,
            'message' => '¡Película agregada a favoritos!',
            'favorite' => $favorite
        ]);
    }

    /**
     * Elimina una película de favoritos
     */
    public function destroy($tmdbId)
    {
        $favorite = auth()->user()->favorites()
            ->where('tmdb_id', $tmdbId)
            ->first();

        if (!$favorite) {
            return response()->json([
                'success' => false,
                'message' => 'Película no encontrada en favoritos'
            ], 404);
        }

        $favorite->delete();

        return response()->json([
            'success' => true,
            'message' => 'Película eliminada de favoritos'
        ]);
    }
}
