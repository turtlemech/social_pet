<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\Like;
use App\Models\Evento;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Publicacion::with([
                'usuario',
                'comentarios.usuario'
            ])
            ->where('est_pub', 'activo')
            ->orderBy('id', 'desc')
            ->get();

        foreach ($posts as $post) {

            // total likes
            $post->likes_count = Like::where('id_publicacion', $post->id)
                ->where('tip_rea', 'like')
                ->count();

            // usuario ya dio like?
            $post->liked = Like::where('id_publicacion', $post->id)
                ->where('id_usuario', auth()->id())
                ->where('tip_rea', 'like')
                ->exists();
        }

        // Próximo evento
        $eventoProximo = Evento::with('ubicacion')
            ->where('fch_eve', '>=', now())
            ->orderBy('fch_eve')
            ->first();

        return view('user.dashboard', compact(
            'posts',
            'eventoProximo'
        ));
    }
}