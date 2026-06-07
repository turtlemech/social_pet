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

    $misComunidades = DB::table('miembro_comunidad')
        ->where('id', auth()->id())
        ->pluck('cod_com')
        ->toArray();

    return view(
        'comunidades.index',
        compact('comunidades', 'misComunidades')
    );
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
            'cat_com' => 'nullable|string|max:50',
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

    'cat_com' => $request->cat_com,

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

$esMiembro = DB::table('miembro_comunidad')
    ->where('cod_com', $cod_com)
    ->where('id', auth()->id())
    ->exists();

$publicaciones = DB::table('publicaciones_comunidad')

    ->leftJoin(

        'usuarios',

        'publicaciones_comunidad.id_usuario',

        '=',

        'usuarios.id'

    )

    ->select(

        'publicaciones_comunidad.*',

        'usuarios.nom_us',

        'usuarios.ava_us'

    )

    ->where('publicaciones_comunidad.cod_com', $cod_com)

    ->orderBy('publicaciones_comunidad.created_at', 'desc')

    ->get();

$comentarios = DB::table('comentarios_comunidad')
    ->orderBy('created_at', 'asc')
    ->get()
    ->groupBy('publicacion_id');

return view('comunidades.show', compact(
    'comunidad',
    'miembros',
    'esMiembro',
    'publicaciones',
    'comentarios'
));

}
public function salir($cod_com)
{
    DB::table('miembro_comunidad')
        ->where('cod_com', $cod_com)
        ->where('id', auth()->id())
        ->delete();

    return back()->with(
        'success',
        'Saliste de la comunidad'
    );
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
        $imagen = $request->file('imagen')
            ->store('publicaciones_comunidad', 'public');
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
        'anonima' => $request->anonima ?? 0,
    ]);

    return back()->with(
        'success',
        'Publicación creada correctamente.'
    );
}
public function like($id)
{
    $publicacion = DB::table('publicaciones_comunidad')
        ->where('id', $id)
        ->first();

    if (!$publicacion) {
        return back();
    }

    DB::table('publicaciones_comunidad')
        ->where('id', $id)
        ->increment('likes');

    if ($publicacion->id_usuario != auth()->id()) {

    $existeNotificacion = \App\Models\Notificacion::where(
        'usuario_id',
        $publicacion->id_usuario
    )
    ->where('tip_not', 'like_comunidad')
    ->where(
        'men_not',
        auth()->user()->nom_us .
        ' le dio like a tu publicación en una comunidad'
    )
    ->exists();

    if (!$existeNotificacion) {

        \App\Models\Notificacion::create([

            'tit_not' => 'Nuevo like en comunidad',

            'men_not' => auth()->user()->nom_us .
                ' le dio like a tu publicación en una comunidad',

            'tip_not' => 'like_comunidad',

            'lei_not' => false,

            'usuario_id' => $publicacion->id_usuario,

            'url_not' => route(
                'usuario.profile',
                auth()->user()
            ),
        ]);
    }
}

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

    return back()->with(
        'success',
        'Comentario agregado.'
    );
}
}