<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use App\Models\Publicacion;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Formulario crear mascota
     */
    public function create()
    {
        return view('pets.create');
    }

    /**
     * Guardar mascota
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_mas' => 'required|max:100',
            'especie_id' => 'required',
            'sex_mas' => 'required',
            'des_mas' => 'nullable|max:500',
            'fot_mas' => 'nullable|image|max:2048'
        ]);

        $mascota = new Mascota();

        $mascota->nom_mas = $request->nom_mas;
        $mascota->especie_id = $request->especie_id;
        $mascota->sex_mas = $request->sex_mas;
        $mascota->des_mas = $request->des_mas;

        // usuario dueño
        $mascota->usuario_id = auth()->id();

        // foto
        if ($request->hasFile('fot_mas')) {

            $path = $request->file('fot_mas')
                ->store('mascotas', 'public');

            $mascota->fot_mas = $path;
        }

        $mascota->save();

        return redirect()
            ->route('my-pets')
            ->with('success', 'Mascota creada correctamente');
    }

    /**
     * Mostrar perfil mascota
     */
    public function show($id)
    {
        $pet = Mascota::findOrFail($id);

        $posts = Publicacion::with([
                'usuario',
                'mascota',
                'comentarios.usuario',
                'likes.usuario'
            ])
            ->withCount([
                'likes as likes_count' => function ($q) {
                    $q->where('tip_rea', 'like');
                }
            ])
            ->where('mascota_id', $pet->id)
            ->where('est_pub', 'activo')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($posts as $post) {

            $post->liked = auth()->check()

                ? $post->likes()
                    ->where('id_usuario', auth()->id())
                    ->where('tip_rea', 'like')
                    ->exists()

                : false;
        }

        return view('pets.show', [
            'mascota' => $pet,
            'posts' => $posts
        ]);
    }
    public function destroy($id)

{

    $mascota = Mascota::findOrFail($id);

    // Verificar dueño

    if ($mascota->usuario_id != auth()->id()) {

        abort(403);

    }

    // Eliminar foto

    if (

        $mascota->fot_mas &&

        \Storage::disk('public')->exists($mascota->fot_mas)

    ) {

        \Storage::disk('public')->delete($mascota->fot_mas);

    }

    $mascota->delete();

    return redirect()

        ->route('my-pets')

        ->with('success', 'Mascota eliminada correctamente');

}
}