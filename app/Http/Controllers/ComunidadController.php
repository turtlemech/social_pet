<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComunidadController extends Controller
{
    public function index()
    {
        $comunidades = DB::table('comunidad')
            ->latest('fch_cre_com')
            ->get();

        return view('comunidades.index', compact('comunidades'));
    }

    public function create()
    {
        return view('comunidades.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_com' => 'required|string|max:100',
            'des_com' => 'nullable|string',
            'fot_com' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'pri_com' => 'required|string',
        ]);

        $foto = null;

        if ($request->hasFile('fot_com')) {
            $foto = $request->file('fot_com')->store('comunidades', 'public');
        }

        $codigo = rand(100, 999);

        DB::table('comunidad')->insert([

    'id' => auth()->id(),

    'cod_com' => $codigo,

    'nom_com' => $request->nom_com,

    'des_com' => $request->des_com,

    'fot_com' => $foto,

    'pri_com' => $request->pri_com,

    'est_com' => 1,

    'fch_cre_com' => now(),

]);
        DB::table('miembro_comunidad')->insert([

    'cod_com' => $codigo,

    'id' => auth()->id(),

    'rol_mie_com' => 'admin',

    'fch_union_com' => now(),

]);

        return redirect()
            ->route('comunidades.index')
            ->with('success', '¡Comunidad creada correctamente!');
    }

    public function unirse($cod_com)
    {
        $existe = DB::table('miembro_comunidad')
            ->where('cod_com', $cod_com)
            ->where('id', auth()->id())
            ->exists();

        if (!$existe) {
            DB::table('miembro_comunidad')->insert([
    'cod_com' => $cod_com,
    'id' => auth()->id(),
    'rol_mie_com' => 'miembro',
    'fch_union_com' => now(),
]);
        }

        return redirect()
    ->route('comunidades.show', $cod_com)
    ->with('success', 'Te uniste a la comunidad');
    }
    public function show($cod_com)

{

    $comunidad = DB::table('comunidad')

        ->where('cod_com', $cod_com)

        ->first();

    if (!$comunidad) {

        abort(404);

    }

    $miembros = DB::table('miembro_comunidad')

        ->where('cod_com', $cod_com)

        ->count();

    return view('comunidades.show', compact(

        'comunidad',

        'miembros'

    ));

}
}