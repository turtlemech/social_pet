<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Notificacion;
use App\Models\Publicacion;
use Illuminate\Http\Request;


class LikeController extends Controller
{
    public function toggle($postId)
    {
        $userId = auth()->id();

        if (!$userId) {

            return response()->json([
                'success' => false,
                'message' => 'No autenticado'
            ], 401);
        }

        $post = Publicacion::findOrFail($postId);

        // Buscar like existente
        $like = Like::where('id_usuario', $userId)
            ->where('id_publicacion', $postId)
            ->where('tip_rea', 'like')
            ->first();

        if ($like) {

            $like->delete();

            $liked = false;

        } else {

            Like::create([
                'id_usuario' => $userId,
                'id_publicacion' => $postId,
                'tip_rea' => 'like'
            ]);

            // 🔔 NOTIFICACIÓN
if ($post->us_id != $userId) {

    $existeNotificacion = Notificacion::where('usuario_id', $post->us_id)
        ->where('tip_not', 'like')
        ->where('url_not', route('usuario.profile', auth()->user()))
        ->where('men_not', auth()->user()->nom_us . ' le dio like a tu publicación')
        ->exists();

    if (!$existeNotificacion) {

        Notificacion::create([

            'tit_not' => 'Nuevo like',

            'men_not' => auth()->user()->nom_us .
                ' le dio like a tu publicación',

            'tip_not' => 'like',

            'lei_not' => false,

            'usuario_id' => $post->us_id,

            'url_not' => route(
                'usuario.profile',
                auth()->user()
            ),
        ]);
    }
}

            $liked = true;
        }

        $count = Like::where('id_publicacion', $postId)
            ->where('tip_rea', 'like')
            ->count();

        return response()->json([

            'success' => true,

            'liked' => $liked,

            'likes' => $count,

            'post_id' => $postId

        ]);
    }
}