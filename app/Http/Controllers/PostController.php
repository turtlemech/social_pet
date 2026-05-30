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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'mascota_id' => 'nullable|exists:mascotas,id',
        ]);

        // ================= VALIDAR PROPIETARIO =================

        if ($request->mascota_id) {

            $mascota = Mascota::findOrFail($request->mascota_id);

            // Evita publicar como mascota ajena
            if ($mascota->usuario_id !== auth()->id()) {

                abort(403, 'No puedes publicar como esta mascota');
            }
        }

        $imagePath = null;

        // ================= GUARDAR IMAGEN =================

        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')
                ->store('posts', 'public');
        }

        // ================= CREAR PUBLICACIÓN =================

        Publicacion::create([

            'cod_pub' => strtoupper(Str::random(8)),

            'com_pub' => $request->content,

            'img_pub' => $imagePath,

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