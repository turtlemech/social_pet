<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MarketplaceController extends Controller
{
    public function index()
    {
        $productos = DB::table('productos')
            ->where('est_pro', 'activo')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('marketplace.index', compact('productos'));
    }

    public function create()
    {
        return view('marketplace.create');
    }

    public function store(Request $request)
{
    $request->validate(

[
    'nom_pro' => 'required|string|min:3|max:255',
    'des_pro' => 'required|string|min:10|max:1000',
    'pre_pro' => 'required|numeric|min:0.01',
    'cat_pro' => 'required|string',
    'img_pro' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
],

[
    'nom_pro.required' => 'Debes ingresar el nombre del producto.',
    'nom_pro.min' => 'El nombre del producto es muy corto.',
    'nom_pro.max' => 'El nombre del producto es demasiado largo.',

    'des_pro.required' => 'Debes ingresar una descripción.',
    'des_pro.min' => 'La descripción es muy corta. Escribe al menos 10 caracteres.',
    'des_pro.max' => 'La descripción es demasiado larga.',

    'pre_pro.required' => 'Debes ingresar un precio.',
    'pre_pro.numeric' => 'El precio debe ser un número válido.',
    'pre_pro.min' => 'El precio debe ser mayor a 0.',

    'cat_pro.required' => 'Debes seleccionar una categoría.',

    'img_pro.image' => 'El archivo seleccionado no es una imagen válida.',
    'img_pro.mimes' => 'Solo se permiten imágenes JPG, PNG o WEBP.',
    'img_pro.max' => 'La imagen no puede superar los 5 MB.',
]

);

    $imagen = null;

    if ($request->hasFile('img_pro')) {
        $imagen = $request->file('img_pro')->store('productos', 'public');
    }

    $codigo = 'PRO' . substr(str_shuffle('0123456789'), 0, 5);

    DB::table('productos')->insert([
        'cod_pro' => $codigo,
        'nom_pro' => $request->nom_pro,
        'des_pro' => $request->des_pro,
        'pre_pro' => $request->pre_pro,
        'cat_pro' => $request->cat_pro,
        'est_pro' => 'activo',
        'img_pro' => $imagen,
        'us_ven' => auth()->id(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('marketplace.index')
        ->with('success', '¡Producto publicado exitosamente!');
}
public function edit($id)
{
    $producto = DB::table('productos')->find($id);

    if (!$producto) {
        abort(404);
    }

    if ($producto->us_ven != auth()->id()) {
        abort(403);
    }

    return view('marketplace.edit', compact('producto'));
}

public function destroy($id)
{
    $producto = DB::table('productos')->find($id);

    if (!$producto) {
        abort(404);
    }

    if ($producto->us_ven != auth()->id()) {
        abort(403);
    }

    // eliminar imagen si existe
    if ($producto->img_pro) {
        Storage::disk('public')->delete($producto->img_pro);
    }

    DB::table('productos')->where('id', $id)->delete();

    return redirect()
        ->route('marketplace.index')
        ->with('success', 'Producto eliminado correctamente');
}
public function update(Request $request, $id)
{
    $producto = DB::table('productos')->find($id);

    if (!$producto) {
        abort(404);
    }

    if ($producto->us_ven != auth()->id()) {
        abort(403);
    }

    $request->validate(

[
    'nom_pro' => 'required|string|min:3|max:255',
    'des_pro' => 'required|string|min:10|max:1000',
    'pre_pro' => 'required|numeric|min:0.01',
    'cat_pro' => 'required|string',
    'img_pro' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
],

[
    'nom_pro.required' => 'Debes ingresar el nombre del producto.',
    'nom_pro.min' => 'El nombre del producto es muy corto.',
    'nom_pro.max' => 'El nombre del producto es demasiado largo.',

    'des_pro.required' => 'Debes ingresar una descripción.',
    'des_pro.min' => 'La descripción es muy corta. Escribe al menos 10 caracteres.',
    'des_pro.max' => 'La descripción es demasiado larga.',

    'pre_pro.required' => 'Debes ingresar un precio.',
    'pre_pro.numeric' => 'El precio debe ser un número válido.',
    'pre_pro.min' => 'El precio debe ser mayor a 0.',

    'cat_pro.required' => 'Debes seleccionar una categoría.',

    'img_pro.image' => 'El archivo seleccionado no es una imagen válida.',
    'img_pro.mimes' => 'Solo se permiten imágenes JPG, PNG o WEBP.',
    'img_pro.max' => 'La imagen no puede superar los 5 MB.',
]

);

    $imagen = $producto->img_pro;

    if ($request->hasFile('img_pro')) {

        if ($producto->img_pro) {
            Storage::disk('public')->delete($producto->img_pro);
        }

        $imagen = $request->file('img_pro')->store('productos', 'public');
    }

    DB::table('productos')
        ->where('id', $id)
        ->update([
            'nom_pro' => $request->nom_pro,
            'des_pro' => $request->des_pro,
            'pre_pro' => $request->pre_pro,
            'cat_pro' => $request->cat_pro,
            'img_pro' => $imagen,
            'updated_at' => now(),
        ]);

    return redirect()
        ->route('marketplace.index')
        ->with('success', 'Producto actualizado correctamente');
}

}