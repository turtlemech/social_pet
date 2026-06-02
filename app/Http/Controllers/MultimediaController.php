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
            'titulo' => 'required|string|max:150',
            'artista' => 'nullable|string|max:150',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:musica,audio',
            'archivo' => 'nullable|file|mimes:mp3,wav,ogg,m4a|max:20480',
            'url_audio' => 'nullable|url',
            'portada' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if (!$request->hasFile('archivo') && !$request->filled('url_audio')) {
            return back()
                ->withErrors([
                    'archivo' => 'Debes subir un archivo o ingresar una URL.'
                ])
                ->withInput();
        }

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo')
                ->store('multimedia/audios', 'public');
        } else {
            $archivo = $request->url_audio;
        }

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
    'tip_mul' => $request->tipo === 'musica' ? 1 : 2,
]);

        return redirect()
            ->route('multimedia.index')
            ->with('success', '🎵 Multimedia publicada correctamente.');
    }
}