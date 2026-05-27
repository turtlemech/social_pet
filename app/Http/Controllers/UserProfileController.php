<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserProfileController extends Controller
{
    public function show(User $user)
    {
        // CARGAR RELACIONES
        $user->load([
            'seguidores',
            'siguiendo',
            'mascotas'
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

        return view(
            'user.profile',
            compact(
                'user',
                'posts',
                'seguidoresCount',
                'siguiendoCount',
                'postsCount',
                'siguiendo'
            )
        );
    }
}