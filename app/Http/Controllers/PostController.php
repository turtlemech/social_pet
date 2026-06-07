<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Publicacion;
use App\Models\Like;
use App\Models\Comentario;
use App\Models\Mascota;

class PostController extends Controller
{
    /**
     * Guardar publicación
     */
    public function store(Request $request)
    {
        // ================= VALIDACIÓN =================

        $request->validate([
            'content' => 'nullable|string|max:1000',
            'images' => 'nullable|array|max:5',

'images.*' => 'image|mimes:jpg,jpeg,png,gif|max:4096',
            'mascota_id' => 'nullable|exists:mascotas,id',
            'ubicacion' => 'nullable|string|max:255',
            'musica' => 'nullable|string|max:255',

'musica_artista' => 'nullable|string|max:255',

'musica_preview' => 'nullable|url',
        ]);

        // ================= VALIDAR PROPIETARIO =================

        if ($request->mascota_id) {

            $mascota = Mascota::findOrFail($request->mascota_id);

            // Evita publicar como mascota ajena
            if ($mascota->usuario_id !== auth()->id()) {

                abort(403, 'No puedes publicar como esta mascota');
            }
        }

        $imagenes = [];

if ($request->hasFile('images')) {

    foreach ($request->file('images') as $archivo) {

        $imagenes[] = $archivo->store(

            'posts',

            'public'

        );

    }

}

        // ================= CREAR PUBLICACIÓN =================
        Publicacion::create([

    'cod_pub' => strtoupper(Str::random(8)),

    'com_pub' => $request->content,
    'ubicacion' => $request->ubicacion,

'musica' => $request->musica,

'musica_artista' => $request->musica_artista,

'musica_preview' => $request->musica_preview,

    'img_pub'   => $imagenes[0] ?? null,
    'img_pub_2' => $imagenes[1] ?? null,
    'img_pub_3' => $imagenes[2] ?? null,
    'img_pub_4' => $imagenes[3] ?? null,
    'img_pub_5' => $imagenes[4] ?? null,

    'us_id' => auth()->id(),

    'mascota_id' => $request->mascota_id,

    'est_pub' => 'activo',

]);

        return back()->with(
            'success',
            'Publicación creada correctamente'
        );
    }

    /**
     * Eliminar publicación
     */
    public function destroy($id)
    {
        $post = Publicacion::findOrFail($id);

        // ================= VERIFICAR DUEÑO =================

        if ($post->us_id != auth()->id()) {

            abort(403, 'No tienes permiso para eliminar esta publicación');
        }

        // ================= ELIMINAR LIKES =================

        Like::where(
            'id_publicacion',
            $post->id
        )->delete();

        // ================= ELIMINAR COMENTARIOS =================

        Comentario::where(
            'id_publicacion',
            $post->id
        )->delete();

        // ================= ELIMINAR PUBLICACIÓN =================

        $post->delete();

        return back()->with(
            'success',
            'Publicación eliminada correctamente'
        );
    }
}