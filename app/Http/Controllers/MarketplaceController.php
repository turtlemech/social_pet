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
        $request->validate([
            'nom_pro' => 'required|string|max:255',
            'des_pro' => 'nullable|string',
            'pre_pro' => 'required|numeric|min:0',
            'cat_pro' => 'required|string',
            'img_pro' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $imagen = null;

        if ($request->hasFile('img_pro')) {
            $imagen = $request->file('img_pro')->store('productos', 'public');
        }

        // Código corto para evitar error de columna
        $codigo = 'PRO' . substr(str_shuffle('0123456789'), 0, 6);

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
}