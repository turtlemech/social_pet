<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class SugerenciaController extends Controller
{
    public function index()
    {
        $mascotas = DB::table('mascotas')
            ->leftJoin('usuarios', 'mascotas.usuario_id', '=', 'usuarios.id')
            ->leftJoin('especies', 'mascotas.especie_id', '=', 'especies.id')
            ->where('mascotas.est_mas', 'activo')
            ->select(
                'mascotas.id',
                'mascotas.nom_mas',
                'mascotas.fot_mas',
                'mascotas.sex_mas',
                'mascotas.des_mas',
                'mascotas.usuario_id',
                'especies.nom_esp as especie',
                'usuarios.nom_us',
                'usuarios.app_us',
                'usuarios.apm_us'
            )
            ->inRandomOrder()
            ->limit(12)
            ->get();

        return view('sugerencias.index', compact('mascotas'));
    }
}