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

            // total likes
            $post->likes_count = Like::where('id_publicacion', $post->id)
                ->where('tipo', 'like')
                ->count();

            // usuario ya dio like?
            $post->liked = Like::where('id_publicacion', $post->id)
                ->where('id_usuario', auth()->id())
                ->where('tipo', 'like')
                ->exists();
        }

        return view('user.dashboard', compact('posts'));
    }
}