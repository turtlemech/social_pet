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
            'usuario_id' => auth()->id(),
            'titulo' => $request->titulo,
            'artista' => $request->artista,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'archivo' => $archivo,
            'portada' => $portada,
            'estado' => 'activo',
        ]);

        return redirect()
            ->route('multimedia.index')
            ->with('success', 'Multimedia publicada correctamente');
    }
}