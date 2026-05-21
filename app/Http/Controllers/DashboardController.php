<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::with([
                'user',
                'comentarios.usuario'
            ])
            ->orderBy('id', 'desc')
            ->get();

        foreach ($posts as $post) {

            // total likes - CAMBIA 'tipo' a 'tip_rea'
            $post->likes_count = Like::where('id_publicacion', $post->id)
                ->where('tip_rea', 'like')  // ← aquí
                ->count();

            // usuario ya dio like? - CAMBIA 'tipo' a 'tip_rea'
            $post->liked = Like::where('id_publicacion', $post->id)
                ->where('id_usuario', auth()->id())
                ->where('tip_rea', 'like')  // ← y aquí
                ->exists();
        }

        return view('user.dashboard', compact('posts'));
    }
}