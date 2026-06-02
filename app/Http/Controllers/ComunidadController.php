<?php

namespace App\Http\Controllers;

use App\Models\Comunidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComunidadController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $comunidades = Comunidad::select('comunidad.*')
            ->selectRaw('(SELECT COUNT(*) FROM miembro_comunidad WHERE miembro_comunidad.cod_com = comunidad.cod_com) as total_miembros')
            ->selectRaw('(SELECT COUNT(*) FROM miembro_comunidad WHERE miembro_comunidad.cod_com = comunidad.cod_com AND miembro_comunidad.id = ?) as unido', [$userId])
            ->selectRaw('(SELECT COUNT(*) FROM publicaciones_comunidad WHERE publicaciones_comunidad.cod_com = comunidad.cod_com) as posts_count')
            ->latest('fch_cre_com')
            ->get();

        return view('comunidades.index', compact('comunidades'));
    }

    public function show(Comunidad $comunidad)
    {
        $userId = auth()->id();

        $comunidad->total_miembros = DB::table('miembro_comunidad')
            ->where('cod_com', $comunidad->cod_com)
            ->count();

        $comunidad->unido = DB::table('miembro_comunidad')
            ->where('cod_com', $comunidad->cod_com)
            ->where('id', $userId)
            ->exists();

        $publicaciones = DB::table('publicaciones_comunidad')
            ->where('cod_com', $comunidad->cod_com)
            ->orderBy('created_at', 'desc')
            ->get();

        $comentarios = DB::table('comentarios_comunidad')
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy('publicacion_id');

        return view('comunidades.show', compact('comunidad', 'publicaciones', 'comentarios'));
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

        $comunidad = Comunidad::create([
            'nom_com' => $request->nom_com,
            'des_com' => $request->des_com,
            'fot_com' => $foto,
            'pri_com' => $request->pri_com,
            'est_com' => 'activa',
            'usuario_id' => auth()->id(),
            'fch_cre_com' => now(),
        ]);

        DB::table('miembro_comunidad')->insert([
            'cod_mie_com' => 'M' . rand(1000, 9999),
            'cod_com' => $comunidad->cod_com,
            'id' => auth()->id(),
            'rol_mie_com' => 'admin',
            'fch_union_com' => now(),
        ]);

        return redirect()->route('comunidades.index')
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
                'cod_mie_com' => 'M' . rand(1000, 9999),
                'cod_com' => $cod_com,
                'id' => auth()->id(),
                'rol_mie_com' => 'miembro',
                'fch_union_com' => now(),
            ]);
        }

        return back()->with('success', 'Te uniste a la comunidad');
    }

    public function salir($cod_com)
    {
        DB::table('miembro_comunidad')
            ->where('cod_com', $cod_com)
            ->where('id', auth()->id())
            ->where('rol_mie_com', '!=', 'admin')
            ->delete();

        return back()->with('success', 'Saliste de la comunidad');
    }

    public function publicar(Request $request, $cod_com)
    {
        $request->validate([
            'contenido' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'tipo' => 'nullable|string',
        ]);

        $imagen = null;

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen')->store('publicaciones_comunidad', 'public');
        }

        DB::table('publicaciones_comunidad')->insert([
            'cod_com' => $cod_com,
            'id_usuario' => auth()->id(),
            'contenido' => $request->contenido,
            'imagen' => $imagen,
            'tipo' => $request->tipo ?? 'texto',
            'likes' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Publicación creada correctamente.');
    }

    public function like($id)
    {
        DB::table('publicaciones_comunidad')
            ->where('id', $id)
            ->increment('likes');

        return back();
    }

    public function comentar(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required|string|max:500',
        ]);

        DB::table('comentarios_comunidad')->insert([
            'publicacion_id' => $id,
            'id_usuario' => auth()->id(),
            'comentario' => $request->comentario,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Comentario agregado.');
    }
}