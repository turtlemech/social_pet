<?php

namespace App\Http\Controllers;

use App\Models\Like;
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

        $like = Like::where('id_usuario', $userId)
            ->where('id_publicacion', $postId)
            ->where('tipo', 'like')
            ->first();

        if ($like) {

            $like->delete();
            $liked = false;

        } else {

            Like::create([
                'id_usuario' => $userId,
                'id_publicacion' => $postId,
                'tipo' => 'like'
            ]);

            $liked = true;
        }

        $count = Like::where('id_publicacion', $postId)
            ->where('tipo', 'like')
            ->count();

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'count' => $count,
            'post_id' => $postId
        ]);
    }
}