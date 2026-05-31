<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\Like;
use App\Models\Evento;
use App\Models\Mascota;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Publicacion::with([

                'usuario',

                'mascota',

                'comentarios.usuario',

                'likes'

            ])
            ->where('est_pub', 'activo')
            ->orderBy('id', 'desc')
            ->get();

        foreach ($posts as $post) {

            // ================= TOTAL LIKES =================

            $post->likes_count = Like::where(
                    'id_publicacion',
                    $post->id
                )
                ->where(
                    'tip_rea',
                    'like'
                )
                ->count();

            // ================= USUARIO YA DIO LIKE =================

            $post->liked = Like::where(
                    'id_publicacion',
                    $post->id
                )
                ->where(
                    'id_usuario',
                    auth()->id()
                )
                ->where(
                    'tip_rea',
                    'like'
                )
                ->exists();
        }

        // ================= PRÓXIMO EVENTO =================

       $eventoProximo = Evento::with('ubicacion')
    ->where('fch_eve', '>=', now())
    ->where('est_eve', 'activo')
    ->orderBy('fch_eve')
    ->first();

$mascotasPopulares = Mascota::withCount('seguidores')
    ->having('seguidores_count', '>', 0)
    ->orderByDesc('seguidores_count')
    ->take(3)
    ->get();

return view(

    'user.dashboard',

    compact(

        'posts',

        'eventoProximo',

        'mascotasPopulares'

    )

);

    }

}