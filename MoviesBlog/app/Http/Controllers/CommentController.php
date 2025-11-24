<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Almacena un nuevo comentario en un blog
     */
    public function store(Request $request, $blogId)
    {
        // Validación condicional según autenticación
        $rules = [
            'content' => 'required|string|min:3|max:1000',
        ];

        // Si no hay usuario autenticado, requerir nombre y email
        if (!auth()->check()) {
            $rules['author_name'] = 'required|string|max:255';
            $rules['author_email'] = 'required|email|max:255';
        }

        $validated = $request->validate($rules);

        // Crear el comentario
        $commentData = [
            'blog_id' => $blogId,
            'content' => $validated['content'],
        ];

        if (auth()->check()) {
            // Usuario autenticado
            $commentData['user_id'] = auth()->id();
        } else {
            // Visitante
            $commentData['author_name'] = $validated['author_name'];
            $commentData['author_email'] = $validated['author_email'];
        }

        \App\Models\Comment::create($commentData);

        return redirect()->back()->with('success', '¡Comentario publicado correctamente!');
    }
}
