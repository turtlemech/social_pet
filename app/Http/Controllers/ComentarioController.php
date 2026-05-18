<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;

class ComentarioController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required|max:255'
        ]);

        Comentario::create([
            'comentario' => $request->comentario,
            'id_publicacion' => $id,
            'id_usuario' => auth()->id()
        ]);

        return back()->with('success', 'Comentario agregado');
    }
}