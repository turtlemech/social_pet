<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    public function toggle($postId)
    {
        $userId = auth()->id();

        // Buscar si ya existe el like
        $like = Like::where('id_usuario', $userId)
                    ->where('id_publicacion', $postId)
                    ->first();

        if ($like) {
            // Si existe → quitar like
            $like->delete();
        } else {
            // Si no existe → crear like
            Like::create([
                'id_usuario' => $userId,
                'id_publicacion' => $postId,
                'tipo' => 'like'
            ]);
        }

        return back();
    }
}