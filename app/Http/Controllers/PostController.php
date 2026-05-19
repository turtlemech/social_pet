<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'content' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $imagePath = null;

        // Guardar imagen
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')
                ->store('posts', 'public');
        }

        // Guardar publicación
        Post::create([
            'con_pub' => $request->content,
            'img_pub' => $imagePath,
            'us_id' => auth()->id()
        ]);

        // Redirigir
        return back()->with('success', 'Post creado correctamente');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // verificar dueño
        if ($post->us_id != auth()->id()) {

            abort(403);
        }

        $post->delete();

        return back()->with('success', 'Publicación eliminada');
    }
}