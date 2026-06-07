<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        // CARGAR RELACIONES
        $user->load([

    'seguidores',

    'siguiendo',

    'mascotas',

    'historiasDestacadas.historias'

]);

        // POSTS
        $posts = $user->publicaciones()
            ->with([
                'likes',
                'comentarios.usuario',
                'mascota'
            ])
            ->where('est_pub', 'activo')
            ->latest()
            ->get();

        // CONTADORES
        $seguidoresCount = $user->seguidores->count();

        $siguiendoCount = $user->siguiendo->count();

        $postsCount = $posts->count();

        // VERIFICAR SI SIGUE
        $siguiendo = auth()->user()
            ->sigueA($user->id);
            $tieneHistorias =
    $user->historiasActivas()
    ->exists();

$destacadas = $user->historiasDestacadas;

return view(
    'user.profile',
    compact(
        'user',
        'posts',
        'seguidoresCount',
        'siguiendoCount',
        'postsCount',
        'siguiendo',
        'tieneHistorias',
        'destacadas'
    )
);
    }
    public function buscar(Request $request)
{
    $q = $request->q;

    $usuarios = User::query()
    ->where('id', '!=', auth()->id())
    ->where(function ($query) use ($q) {

        $query->where('nom_us', 'like', "%{$q}%")
              ->orWhere('app_us', 'like', "%{$q}%")
              ->orWhere('apm_us', 'like', "%{$q}%");

    })
    ->limit(10)
    ->get([
        'id',
        'nom_us',
        'app_us',
        'apm_us',
        'ava_us'
    ]);

    return response()->json($usuarios);
}
}