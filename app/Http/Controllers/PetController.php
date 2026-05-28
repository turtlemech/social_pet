<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    // ===============================
    // Mostrar mascotas
    // ===============================
    public function index()
    {
        // Obtiene mascotas
        $pets = DB::table('mascotas')
            ->latest()
            ->get();

        // Retorna vista
        return view('pets.index', compact('pets'));
    }

    // ===============================
    // Guardar mascota
    // ===============================
    public function store(Request $request)
    {
        // Validación
        $request->validate([

            'nom_mas' => 'required|string|max:100',

            'sex_mas' => 'required|string|max:20',

            'des_mas' => 'nullable|string',

            'fot_mas' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'est_mas' => 'required|string|max:20',

            'especie_id' => 'required|integer',
        ]);

        // Variable imagen
        $foto = null;

        // Guarda imagen
        if ($request->hasFile('fot_mas')) {

            $foto = $request->file('fot_mas')
                ->store('mascotas', 'public');
        }

        // Inserta mascota
        DB::table('mascotas')->insert([

            'nom_mas' => $request->nom_mas,

            'sex_mas' => $request->sex_mas,

            'des_mas' => $request->des_mas,

            'fot_mas' => $foto,

            'est_mas' => $request->est_mas,

            'especie_id' => $request->especie_id,

            'usuario_id' => auth()->id(),

            'created_at' => now(),

            'updated_at' => now(),
        ]);

        // Redirecciona
        return redirect()
            ->route('pets.index')
            ->with('success', 'Mascota registrada correctamente');
    }
}