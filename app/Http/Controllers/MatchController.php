<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class MatchController extends Controller
{
    public function index()
    {
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
                'mascotas.des_mas',
                'mascotas.especie_id',
                'especies.nom_esp as especie',
                'usuarios.nom_us',
                'usuarios.app_us',
                'usuarios.apm_us'
            )
            ->inRandomOrder()
            ->limit(20)
            ->get();

        return view('matches.index', compact('mascotas'));
    }
}