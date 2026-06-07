<?php

namespace App\Http\Controllers;

use App\Models\Mascota;

class SugerenciaController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();

        $usuariosSeguidos = $usuario->siguiendo()
            ->pluck('usuarios.id');

        // ===============================
        // PRIORIDAD 1: USUARIOS SEGUIDOS
        // ===============================

        $seguidos = Mascota::with([
                'usuario',
                'especie',
                'seguidores'
            ])
            ->where('est_mas', 'activo')
            ->whereIn('usuario_id', $usuariosSeguidos)
            ->where('usuario_id', '!=', $usuario->id)
            ->get();

        // ===============================
        // PRIORIDAD 2: MÁS POPULARES
        // ===============================

        $populares = Mascota::with([
                'usuario',
                'especie',
                'seguidores'
            ])
            ->withCount('seguidores')
            ->where('est_mas', 'activo')
            ->where('usuario_id', '!=', $usuario->id)
            ->orderByDesc('seguidores_count')
            ->get();

        // ===============================
        // PRIORIDAD 3: ALEATORIAS
        // ===============================

        $aleatorias = Mascota::with([
                'usuario',
                'especie',
                'seguidores'
            ])
            ->where('est_mas', 'activo')
            ->where('usuario_id', '!=', $usuario->id)
            ->inRandomOrder()
            ->get();

        // ===============================
        // UNIR Y ELIMINAR DUPLICADOS
        // ===============================

        $mascotas = $seguidos
            ->concat($populares)
            ->concat($aleatorias)
            ->unique('id')
            ->take(20);

        return view(
            'sugerencias.index',
            compact('mascotas')
        );
    }
}