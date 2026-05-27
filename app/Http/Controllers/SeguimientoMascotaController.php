<?php

namespace App\Http\Controllers;

use App\Models\Mascota;

class SeguimientoMascotaController extends Controller
{
    public function toggle(Mascota $mascota)
    {
        $usuario = auth()->user();

        // evitar seguir mascota propia

        if ($mascota->usuario_id == $usuario->id) {

            return back();
        }

        $siguiendo = $usuario
            ->mascotasSeguidas()
            ->where('mas_seg', $mascota->id)
            ->exists();

        if ($siguiendo) {

            $usuario
                ->mascotasSeguidas()
                ->detach($mascota->id);

        } else {

            $usuario
                ->mascotasSeguidas()
                ->attach($mascota->id);
        }

        return back();
    }
}