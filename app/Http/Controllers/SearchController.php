<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mascota;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function live(Request $request)
    {
        $query = $request->q;

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $usuarios = User::where('nom_us', 'like', "%{$query}%")

    ->orWhere('app_us', 'like', "%{$query}%")

    ->orWhere('apm_us', 'like', "%{$query}%")

    ->limit(5)

    ->get()

    ->map(function ($user) {

        return [

            'tipo' => 'usuario',

            'nombre' => trim(

                $user->nom_us . ' ' .

                $user->app_us . ' ' .

                $user->apm_us

            ),

            'url' => route('usuario.profile', $user),

        ];

    });

        $mascotas = Mascota::where('nom_mas', 'like', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($mascota) {
                return [
                    'tipo' => 'mascota',
                    'nombre' => $mascota->nom_mas,
                    'url' => route('pets.show', $mascota->id),
                ];
            });

        return response()->json([
            'usuarios' => $usuarios,
            'mascotas' => $mascotas
        ]);
    }
}