<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Notificacion;
use App\Models\Publicacion;

class ComentarioController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required|max:255'
        ]);

        Comentario::create([
            'con_com' => $request->comentario,
            'id_publicacion' => $id,
            'id_usuario' => auth()->id(),
            'estado' => 'activo'
        ]);

        $post = Publicacion::findOrFail($id);

        // 🔔 NOTIFICACIÓN
        if ($post->us_id != auth()->id()) {

            Notificacion::create([

                'tit_not' => 'Nuevo comentario',

                'men_not' => auth()->user()->nom_us .
                    ' comentó tu publicación',

                'tip_not' => 'comentario',

                'lei_not' => false,

                'usuario_id' => $post->us_id,

                'url_not' => route(
                    'usuario.profile',
                    auth()->user()
                ),
            ]);
        }

        return back()->with(
            'success',
            'Comentario agregado'
        );
    }
}