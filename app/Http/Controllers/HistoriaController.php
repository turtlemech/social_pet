<?php

namespace App\Http\Controllers;

use App\Models\Historia;
use App\Models\VisualizacionHistoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class HistoriaController extends Controller
{
    public function crear()
    {
        return view('historias.create');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,webm|max:20480'
        ]);

        $archivo = $request->file('media');

        $ruta = $archivo->store('historias', 'public');

        Historia::create([
            'usuario_id' => Auth::id(),
            'media' => $ruta,
            'tipo' => str_contains($archivo->getMimeType(), 'video')
                ? 'video'
                : 'imagen',
            'fecha_expiracion' => now()->addDay(),
        ]);

        return redirect()->route('historias.crear');
    }

    public function editor(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,webm|max:51200'
        ]);

        $archivo = $request->file('media');

        $ruta = $archivo->store('tempHistorias', 'public');

        return view('historias.editor', [
            'media' => asset('storage/' . $ruta),
            'rutaMedia' => $ruta,
            'tipo' => str_contains($archivo->getMimeType(), 'video')
                ? 'video'
                : 'imagen'
        ]);
    }

    public function guardarFinal(Request $request)
    {
        $request->validate([
            'media_path' => 'required|string',
            'tipo' => 'required|in:imagen,video',
            'musica' => 'nullable|string',
            'descripcion' => 'nullable|string|max:500',
            'texto_alternativo' => 'nullable|string',
            'elementos' => 'nullable|string',
            'es_destacada' => 'nullable|boolean',
        ]);

        $nuevaRuta = str_replace(

    'tempHistorias/',

    'historias/',

    $request->media_path

);

Storage::disk('public')->move(

    $request->media_path,

    $nuevaRuta

);

Historia::create([

    'usuario_id' => Auth::id(),

    'media' => $nuevaRuta,

    'tipo' => $request->tipo,

    'musica' => $request->musica,

    'descripcion' => $request->descripcion,

    'texto_alternativo' => $request->texto_alternativo,

    'elementos' => $request->elementos,

    'es_destacada' => $request->boolean('es_destacada'),

    'fecha_expiracion' => now()->addDay(),

]);

        return redirect()->route('dashboard');
    }

    public function eliminar(Historia $historia)
    {
        if (Auth::id() !== $historia->usuario_id) {
            abort(403);
        }

        Storage::disk('public')->delete($historia->media);

        $historia->delete();

        return back()->with(
            'success',
            'Historia eliminada correctamente'
        );
    }

    public function registrarVisualizacion(Historia $historia)
    {
        if (
            !Auth::check() ||
            Auth::id() === $historia->usuario_id
        ) {
            return response()->json([
                'estado' => 'ignorado'
            ]);
        }

        VisualizacionHistoria::updateOrCreate(
            [
                'historia_id' => $historia->id,
                'usuario_id' => Auth::id(),
            ],
            [
                'fecha_visualizacion' => now(),
            ]
        );

        return response()->json([
            'estado' => 'registrada'
        ]);
    }

    public function visualizaciones(Historia $historia)
    {
        if (Auth::id() !== $historia->usuario_id) {
            abort(403);
        }

        $visualizaciones = $historia->visualizaciones()
            ->with('usuario')
            ->latest('fecha_visualizacion')
            ->get()
            ->map(function ($visualizacion) {

                return [
                    'id' => $visualizacion->usuario->id,

                    'nombre' => trim(
                        $visualizacion->usuario->nom_us . ' ' .
                        $visualizacion->usuario->app_us . ' ' .
                        $visualizacion->usuario->apm_us
                    ),

                    'fecha_visualizacion' =>
                        $visualizacion->fecha_visualizacion
                        ->diffForHumans(),
                ];
            });

        return response()->json([
            'cantidad' => $visualizaciones->count(),
            'visualizaciones' => $visualizaciones,
        ]);
    }

    public function subir(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,webm|max:51200'
        ]);

        $archivo = $request->file('media');

        $ruta = $archivo->store('historias', 'public');

        return response()->json([
            'success' => true,
            'ruta' => $ruta,
            'url' => asset('storage/' . $ruta)
        ]);
    }

    public function seleccionarDestacadas()
{
    $historias = Historia::where(
        'usuario_id',
        Auth::id()
    )
    ->latest()
    ->get();

    return view(
        'historias.seleccionar_destacadas',
        compact('historias')
    );
}

    public function guardarDestacadas(Request $request)
    {
        $request->validate([
            'historia_ids' => 'required|array',
            'historia_ids.*' => 'exists:historias,id'
        ]);

        Historia::where(
            'usuario_id',
            Auth::id()
        )->update([
            'es_destacada' => false
        ]);

        Historia::whereIn(
            'id',
            $request->historia_ids
        )
        ->where(
            'usuario_id',
            Auth::id()
        )
        ->update([
            'es_destacada' => true
        ]);

        return back()->with(
            'success',
            'Historias destacadas actualizadas correctamente'
        );
    }
    public function ver(Request $request, User $usuario)
{
    $historias = $usuario->historias()
        ->where('fecha_expiracion', '>', now())
        ->orderBy('created_at')
        ->get();

    $origen = $request->get('origen', 'feed');

    return view(
        'historias.ver',
        compact('usuario', 'historias', 'origen')
    );
}
}