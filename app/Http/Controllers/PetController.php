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
        $request->validate(

[
    'nom_mas' => 'required|min:2|max:100',

'especie_id' => 'required',

'sex_mas' => 'required',

'per_mas' => 'required',

'des_mas' => 'nullable|min:10|max:500',

'fot_mas' => 'nullable|image|max:2048'
],

[
    'nom_mas.required' => 'Debes ingresar el nombre de la mascota.',
    'nom_mas.min' => 'El nombre es demasiado corto.',
    'nom_mas.max' => 'El nombre es demasiado largo.',

    'especie_id.required' => 'Debes seleccionar una especie.',

    'sex_mas.required' => 'Debes seleccionar el sexo de la mascota.',

    'des_mas.min' => 'La descripción es muy corta. Escribe al menos 10 caracteres.',
    'des_mas.max' => 'La descripción no puede superar los 500 caracteres.',

    'fot_mas.image' => 'El archivo debe ser una imagen.',
    'fot_mas.max' => 'La imagen no puede superar los 2 MB.',
]

);

        $mascota = new Mascota();

        $mascota->nom_mas = $request->nom_mas;
        $mascota->especie_id = $request->especie_id;
        $mascota->sex_mas = $request->sex_mas;
        $mascota->per_mas = $request->per_mas;
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
        $pet = Mascota::with([

    'usuario',

    'especie',

    'seguidores'

])->findOrFail($id);

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
public function edit($id)
{
    $mascota = Mascota::findOrFail($id);

    if ($mascota->usuario_id != auth()->id()) {
        abort(403);
    }

    return view('pets.edit', compact('mascota'));
}
public function update(Request $request, $id)
{
    $mascota = Mascota::findOrFail($id);

    if ($mascota->usuario_id != auth()->id()) {
        abort(403);
    }

    $request->validate(

[

    'nom_mas' => 'required|min:2|max:100',

'sex_mas' => 'required',

'per_mas' => 'required',

'des_mas' => 'nullable|min:10|max:500',

'fot_mas' => 'nullable|image|max:2048'

],

[

    'nom_mas.required' => 'Debes ingresar el nombre de la mascota.',

    'nom_mas.min' => 'El nombre es demasiado corto.',

    'nom_mas.max' => 'El nombre es demasiado largo.',

    'sex_mas.required' => 'Debes seleccionar el sexo de la mascota.',

    'des_mas.min' => 'La descripción es muy corta. Escribe al menos 10 caracteres.',

    'des_mas.max' => 'La descripción no puede superar los 500 caracteres.',

    'fot_mas.image' => 'El archivo debe ser una imagen.',

    'fot_mas.max' => 'La imagen no puede superar los 2 MB.',

]

);

    $mascota->nom_mas = $request->nom_mas;
    $mascota->sex_mas = $request->sex_mas;
    $mascota->per_mas = $request->per_mas;
    $mascota->des_mas = $request->des_mas;

    // Nueva foto
    if ($request->hasFile('fot_mas')) {

        if (
            $mascota->fot_mas &&
            \Storage::disk('public')->exists($mascota->fot_mas)
        ) {
            \Storage::disk('public')->delete($mascota->fot_mas);
        }

        $path = $request->file('fot_mas')
            ->store('mascotas', 'public');

        $mascota->fot_mas = $path;
    }

    $mascota->save();

    return redirect()
        ->route('pets.show', $mascota->id)
        ->with('success', 'Mascota actualizada correctamente');
}
}