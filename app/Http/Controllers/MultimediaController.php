<?php

namespace App\Http\Controllers;

use App\Models\Multimedia;
use Illuminate\Http\Request;

class MultimediaController extends Controller
{
    public function index()
    {
        $multimedia = Multimedia::latest()->get();

        return view('multimedia.index', compact('multimedia'));
    }

    public function create()
    {
        return view('multimedia.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'tipo' => 'required',
            'archivo' => 'required',
        ]);

        $archivo = $request->file('archivo')
            ->store('multimedia/audios', 'public');

        $portada = null;

        if ($request->hasFile('portada')) {
            $portada = $request->file('portada')
                ->store('multimedia/portadas', 'public');
        }

        Multimedia::create([
    'nom_mul' => $request->titulo,
    'art_mul' => $request->artista,
    'gen_mul' => 'General',
    'dur_mul' => 0,
    'url_mul' => $archivo,
    'tip_mul' => $request->tipo,
]);

        return redirect()
            ->route('multimedia.index')
            ->with('success', 'Multimedia publicada correctamente');
    }
}