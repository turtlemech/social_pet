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
            'content' => 'required|string|max:255'
        ]);

        // Guardar en la base de datos
        Post::create([
            'con_pub' => $request->content,
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