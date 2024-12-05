<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Método para mostrar las publicaciones
    public function index()
    {
        return Post::all(); // Devuelve todas las publicaciones
    }

    // Método para guardar una nueva publicación
    public function store(Request $request)
    {
        $data = $request->validate([
            'text' => 'nullable|string',
            'images' => 'nullable|array',
            'videos' => 'nullable|array',
            'documents' => 'nullable|array',
            'comments' => 'nullable|array',
            'likes' => 'nullable|integer',
            'liked' => 'nullable|boolean',
        ]);

        $post = Post::create($data); // Guardar la nueva publicación en la base de datos

        return response()->json($post, 201); // Devolver la publicación creada
    }

    // Método para actualizar una publicación
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'comments' => 'nullable|array',
            'likes' => 'nullable|integer',
        ]);

        $post->update($data);

        return response()->json($post);
    }
}

