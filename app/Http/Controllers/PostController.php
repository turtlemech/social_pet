<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Publicacion;
use App\Models\Like;
use App\Models\Comentario;

class PostController extends Controller
{
    /**
     * Guardar publicación
     */
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'content' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $imagePath = null;

        // Guardar imagen
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')
                ->store('posts', 'public');
        }

        // Crear publicación
        Publicacion::create([
            'cod_pub' => strtoupper(Str::random(8)),
            'com_pub' => $request->content,
            'img_pub' => $imagePath,
            'us_id' => auth()->id(),
            'est_pub' => 'activo',
        ]);

        return back()->with('success', 'Publicación creada correctamente');
    }

    /**
     * Eliminar publicación
     */
    public function destroy($id)
    {
        $post = Publicacion::findOrFail($id);

        // Verificar dueño
        if ($post->us_id != auth()->id()) {

            abort(403);
        }

        // Eliminar likes/reacciones
        Like::where('id_publicacion', $post->id)->delete();

        // Eliminar comentarios
        Comentario::where('id_publicacion', $post->id)->delete();

        // Eliminar publicación
        $post->delete();

        return back()->with('success', 'Publicación eliminada');
    }
}