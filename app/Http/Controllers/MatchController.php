<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    public function index()
    {
        // Todas las mascotas del usuario
        $misMascotas = DB::table('mascotas')
            ->where('usuario_id', auth()->id())
            ->where('est_mas', 'activo')
            ->get();

        // Mascota seleccionada en el selector
        $mascotaSeleccionada = request('mascota');

        // Si no seleccionó ninguna, usar la primera
        if (!$mascotaSeleccionada && $misMascotas->count() > 0) {
            $mascotaSeleccionada = $misMascotas->first()->id;
        }

        // Mascota que se usará para calcular compatibilidad
        $miMascota = DB::table('mascotas')

    ->leftJoin('usuarios', 'mascotas.usuario_id', '=', 'usuarios.id')

    ->where('mascotas.id', $mascotaSeleccionada)

    ->where('mascotas.usuario_id', auth()->id())

    ->select(

        'mascotas.*',

        'usuarios.ubi_us'

    )

    ->first();

        // Mascotas candidatas
        $mascotas = DB::table('mascotas')
            ->leftJoin('usuarios', 'mascotas.usuario_id', '=', 'usuarios.id')
            ->leftJoin('especies', 'mascotas.especie_id', '=', 'especies.id')
            ->where('mascotas.est_mas', 'activo')
            ->where('mascotas.usuario_id', '!=', auth()->id())
            ->select(

    'mascotas.id',

    'mascotas.nom_mas',

    'mascotas.fot_mas',

    'mascotas.sex_mas',

    'mascotas.per_mas',

    'mascotas.des_mas',

    'mascotas.especie_id',

    'usuarios.ubi_us',

    'especies.nom_esp as especie',

    'usuarios.nom_us',

    'usuarios.app_us',

    'usuarios.apm_us'

            )
            ->get();

        // Calcular compatibilidad
        $mascotas = $mascotas->map(function ($pet) use ($miMascota) {

    $score = 0;

    /*
    |--------------------------------------------------------------------------
    | UBICACIÓN GEOGRÁFICA (40%)
    |--------------------------------------------------------------------------
    */
    if (
        $miMascota &&
        !empty($pet->ubi_us) &&
        !empty($miMascota->ubi_us) &&
        strtolower(trim($pet->ubi_us)) ==
        strtolower(trim($miMascota->ubi_us))
    ) {
        $score += 40;
    }

    /*
    |--------------------------------------------------------------------------
    | COMPATIBILIDAD FÍSICA (35%)
    |--------------------------------------------------------------------------
    */
    if (
        $miMascota &&
        $pet->especie_id == $miMascota->especie_id
    ) {
        $score += 35;
    }

    /*
    |--------------------------------------------------------------------------
    | COMPATIBILIDAD SOCIAL (25%)
    |--------------------------------------------------------------------------
    */
    if (
        $miMascota &&
        !empty($pet->per_mas) &&
        !empty($miMascota->per_mas) &&
        $pet->per_mas == $miMascota->per_mas
    ) {
        $score += 25;
    }

    $pet->compatibilidad = $score;

    return $pet;
});

        // Ordenar por compatibilidad
        $mascotas = $mascotas
            ->sortByDesc('compatibilidad')
            ->take(20);

        return view(
            'matches.index',
            compact(
                'mascotas',
                'misMascotas',
                'miMascota'
            )
        );
    }
}