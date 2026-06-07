<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\Like;
use App\Models\Evento;
use App\Models\Mascota;
use App\Models\Historia;
use App\Models\User;

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
    $usuario = auth()->user();

$usuariosSeguidos = $usuario->siguiendo()->pluck('usuarios.id');

$mascotasYaSeguidas = $usuario->mascotasSeguidas()->pluck('mascotas.id');

// =====================================
// SUGERENCIAS INTELIGENTES
// =====================================

$mascotasSugeridas = Mascota::with(['usuario', 'especie'])
    ->whereIn('usuario_id', $usuariosSeguidos)
    ->whereNotIn('id', $mascotasYaSeguidas)
    ->where('usuario_id', '!=', $usuario->id)
    ->take(5)
    ->get();

if ($mascotasSugeridas->count() < 5) {

    $faltan = 5 - $mascotasSugeridas->count();

    $populares = Mascota::with(['usuario', 'especie'])

    ->withCount('seguidores')

    ->whereNotIn('id', $mascotasSugeridas->pluck('id'))

    ->whereNotIn('id', $mascotasYaSeguidas)

    ->where('usuario_id', '!=', $usuario->id)

    ->orderByDesc('seguidores_count')

    ->take($faltan)

    ->get();

    $mascotasSugeridas =
        $mascotasSugeridas->concat($populares);
}

if ($mascotasSugeridas->count() < 5) {

    $faltan = 5 - $mascotasSugeridas->count();

    $aleatorias = Mascota::with(['usuario', 'especie'])
    ->whereNotIn('id', $mascotasSugeridas->pluck('id'))
    ->whereNotIn('id', $mascotasYaSeguidas)
    ->where('usuario_id', '!=', $usuario->id)
    ->inRandomOrder()
    ->take($faltan)
    ->get();

    $mascotasSugeridas =
        $mascotasSugeridas->concat($aleatorias);
}

$mascotasSugeridas =
    $mascotasSugeridas->take(5)
    ->map(function ($mascota) {

        return [
            'id' => $mascota->id,
            'name' => $mascota->nom_mas,
            'breed' => $mascota->especie->nom_esp ?? 'Mascota',
            'distance' => $mascota->usuario->nom_us ?? 'Usuario',
            'avatar' => $mascota->foto_url,
        ];

    });
$historias = User::with([

    'historias' => function ($query) {

        $query->where('fecha_expiracion', '>', now())

              ->orderBy('created_at');

    }

])

->whereHas('historias', function ($query) {

    $query->where('fecha_expiracion', '>', now());

})

->get();
return view(

    'user.dashboard',

    compact(

    'posts',

    'eventoProximo',

    'mascotasPopulares',

    'mascotasSugeridas',

    'historias'

)

);

    }

}