<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdopcionController extends Controller
{
    // ================= LISTAR ADOPCIONES =================
    public function index()
    {
        $adopciones = DB::table('adopciones')
            ->join('mascotas', 'adopciones.mas_id', '=', 'mascotas.id')
            ->leftJoin('usuarios', 'adopciones.us_act', '=', 'usuarios.id')
            ->leftJoin('especies', 'mascotas.especie_id', '=', 'especies.id')
            ->where('adopciones.est_ado', '!=', 'completado')
            ->select(
                'adopciones.*',
                'mascotas.nom_mas',
                'mascotas.fot_mas',
                'mascotas.sex_mas',
                'mascotas.des_mas as descripcion_mascota',
                'especies.nom_esp as especie',
                'usuarios.nom_us',
                'usuarios.app_us',
                'usuarios.apm_us'
            )
            ->orderBy('adopciones.created_at', 'desc')
            ->get();

        return view('adopciones.index', compact('adopciones'));
    }

    // ================= FORMULARIO =================
    public function create()
    {
        $mascotas = DB::table('mascotas')
            ->leftJoin('especies', 'mascotas.especie_id', '=', 'especies.id')
            ->where('mascotas.usuario_id', auth()->id())
            ->where('mascotas.est_mas', 'activo')
            ->select('mascotas.*', 'especies.nom_esp as especie')
            ->get();

        return view('adopciones.create', compact('mascotas'));
    }

    // ================= GUARDAR =================
    public function store(Request $request)
    {
        $request->validate([
            'des_ado' => 'required|string|min:20',
            'mas_id' => 'required|integer|exists:mascotas,id',
        ]);

       DB::table('adopciones')->insert([

    'des_ado' => $request->des_ado,
    'fch_pub_ado' => now(),
    'fch_sol_ado' => now(),
    'fch_res_ado' => now(),
    'est_ado' => '1',
    'mas_id' => $request->mas_id,
    'us_act' => auth()->id(),
    'us_sol' => auth()->id(),
    'created_at' => now(),
    'updated_at' => now(),

]);

        return redirect()
            ->route('adopciones.index')
            ->with('success', '¡Mascota publicada para adopción exitosamente! 🐾');
    }
}