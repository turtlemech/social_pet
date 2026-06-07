<?php

namespace App\Http\Controllers;

use App\Models\Historia;
use App\Models\HistoriaDestacada;
use Illuminate\Http\Request;

class HistoriaDestacadaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:50',
            'historias' => 'required|array'
        ]);

        $destacada = HistoriaDestacada::create([
            'usuario_id' => auth()->id(),
            'titulo' => $request->titulo,
        ]);

        $destacada->historias()
            ->attach($request->historias);

        $primeraHistoria = Historia::find(
            $request->historias[0]
        );

        if ($primeraHistoria) {

            $destacada->update([
                'portada' => $primeraHistoria->media
            ]);
        }

        return redirect()->route(

    'usuario.profile',

    auth()->id()

)->with(

    'success',

    'Historia destacada creada'

);
    }

    public function show(HistoriaDestacada $destacada)

{

    $historias = $destacada->historias()

        ->orderBy('created_at')

        ->get();

    return view(

        'historias.destacada',

        compact('destacada', 'historias')

    );

}
    public function destroy(HistoriaDestacada $destacada)
{
    if ($destacada->usuario_id != auth()->id()) {
        abort(403);
    }

    $destacada->delete();

    return redirect()->route(
        'usuario.profile',
        auth()->id()
    )->with(
        'success',
        'Historia destacada eliminada correctamente'
    );
}
}