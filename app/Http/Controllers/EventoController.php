<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EventoController extends Controller
{
    // MOSTRAR EVENTOS
    public function index()
    {
        $query = Evento::with([
                'usuario',
                'ubicacion',
                'participantes'
            ])
            ->withCount('participantes');

        // BUSCADOR
        if(request('buscar')) {

            $query->where('nom_eve', 'like', '%' . request('buscar') . '%');
        }

        // FILTRO CATEGORÍA
        if(request('categoria')) {

            $query->where('cat_eve', request('categoria'));
        }

        // FILTRO FECHA
        if(request('fecha')) {

            $query->whereDate('fch_eve', request('fecha'));
        }

        // FILTRO ESTADO
        if(request('estado')) {

            $query->where('est_eve', request('estado'));
        }

        $eventos = $query->get();

        foreach ($eventos as $evento) {

            $inicio = Carbon::parse($evento->fch_eve);

            // DURACIÓN SIMULADA DEL EVENTO
            $finEvento = $inicio->copy()->addMinutes(15);

            $diasRestantes = now()->diffInDays($evento->fch_eve, false);

            $puntajeFecha = 0;

            // CAMBIO AUTOMÁTICO DE ESTADO
            if (
                $evento->est_eve != 'cancelado'
                &&
                $evento->est_eve != 'finalizado'
            ) {

                if (now()->between($inicio, $finEvento)) {

                    $evento->est_eve = 'en_curso';

                } elseif (now()->gt($finEvento)) {

                    $evento->est_eve = 'finalizado';

                } else {

                    $evento->est_eve = 'activo';
                }

                $evento->save();
            }

            // SI YA FINALIZÓ
            if ($evento->est_eve == 'finalizado') {

                $evento->destacado = false;

                $evento->save();

                continue;
            }

            // PUNTAJE POR FECHA
            if ($diasRestantes <= 1) {

                $puntajeFecha = 100;

            } elseif ($diasRestantes <= 3) {

                $puntajeFecha = 70;

            } elseif ($diasRestantes <= 7) {

                $puntajeFecha = 40;

            } elseif ($diasRestantes <= 15) {

                $puntajeFecha = 20;
            }

            // SCORE TOTAL
            $score =
                ($evento->participantes_count * 2)
                + $puntajeFecha;

            // DESTACADO AUTOMÁTICO
            $nuevoDestacado = $score >= 80;

            if ($evento->destacado != $nuevoDestacado) {

                $evento->destacado = $nuevoDestacado;

                $evento->save();
            }

            // SCORE TEMPORAL SOLO PARA ORDENAR
            $evento->score_temp = $score;
        }

        // ORDENAR EVENTOS
        $eventos = $eventos->sortByDesc(function ($evento) {

            return
                (($evento->destacado ? 1 : 0) * 10000)
                + ($evento->score_temp ?? 0);

        })->values();

        return view('eventos.index', compact('eventos'));
    }

    // MIS EVENTOS
    public function misEventos()
    {
        $eventos = Evento::with([
                'usuario',
                'ubicacion',
                'participantes'
            ])
            ->where('usuario_id', auth()->id())
            ->latest()
            ->get();

        return view('eventos.mis-eventos', compact('eventos'));
    }

    // EVENTOS DONDE PARTICIPO
    public function participando()
    {
        $eventos = auth()->user()
            ->eventosParticipando()
            ->with([
                'usuario',
                'ubicacion',
                'participantes'
            ])
            ->get();

        return view('eventos.participando', compact('eventos'));
    }

    // CREAR EVENTO
    public function store(Request $request)
    {
        $request->validate([
            'nom_eve' => 'required|max:30',
            'des_eve' => 'required',
            'fch_eve' => 'required|date|after:now',
            'cat_eve' => 'required',
            'capacidad_eve' => 'nullable|integer',
            'img_eve' => 'nullable|image|max:4096',
            'nom_ubi' => 'required|max:150',
            'latitud' => 'required',
            'longitud' => 'required',
        ]);

        // CREAR UBICACIÓN
        $ubicacion = Ubicacion::create([
            'nom_ubi' => $request->nom_ubi,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
        ]);

        // SUBIR IMAGEN
        $rutaImagen = null;

        if ($request->hasFile('img_eve')) {

            $rutaImagen = $request
                ->file('img_eve')
                ->store('eventos', 'public');
        }

        // CREAR EVENTO
        $evento = Evento::create([
            'nom_eve' => $request->nom_eve,
            'des_eve' => $request->des_eve,
            'img_eve' => $rutaImagen,
            'cat_eve' => $request->cat_eve,
            'capacidad_eve' => $request->capacidad_eve,
            'est_eve' => 'activo',
            'fch_eve' => $request->fch_eve,
            'usuario_id' => auth()->id(),
            'id_ubicacion' => $ubicacion->id,
        ]);

        // EL CREADOR PARTICIPA AUTOMÁTICAMENTE
        $evento->participantes()->attach(auth()->id(), [
            'est_par' => 'aceptada'
        ]);

        return redirect()->to('/eventos?creado=1');
    }

    // UNIRSE A EVENTO
    public function join(Evento $evento)
    {
        $evento->participantes()->syncWithoutDetaching([
            auth()->id() => [
                'est_par' => 'aceptada'
            ]
        ]);

        return back()->with('success', 'Te uniste al evento');
    }

    // VER DETALLES
    public function show(Evento $evento)
    {
        $evento->load([
            'usuario',
            'ubicacion',
            'participantes'
        ]);

        return view('eventos.show', compact('evento'));
    }

    // EDITAR EVENTO
    public function edit(Evento $evento)
    {
        if ($evento->usuario_id != auth()->id()) {

            abort(403);
        }

        $evento->load('ubicacion');

        return view('eventos.edit', compact('evento'));
    }

    // ACTUALIZAR EVENTO
    public function update(Request $request, Evento $evento)
    {
        if ($evento->usuario_id != auth()->id()) {

            abort(403);
        }

        $request->validate([
            'nom_eve' => 'required|max:30',
            'des_eve' => 'required',
            'fch_eve' => 'required|date|after:now',
            'cat_eve' => 'required',
            'capacidad_eve' => 'nullable|integer',
            'img_eve' => 'nullable|image|max:4096',
            'nom_ubi' => 'required|max:150',
            'est_eve' => 'required',
        ]);

        // ACTUALIZAR UBICACIÓN
        $evento->ubicacion->update([
            'nom_ubi' => $request->nom_ubi,
        ]);

        // NUEVA IMAGEN
        if ($request->hasFile('img_eve')) {

            // ELIMINAR ANTERIOR
            if ($evento->img_eve) {

                Storage::disk('public')->delete($evento->img_eve);
            }

            $evento->img_eve = $request
                ->file('img_eve')
                ->store('eventos', 'public');
        }

        // ACTUALIZAR EVENTO
        $evento->update([
            'nom_eve' => $request->nom_eve,
            'des_eve' => $request->des_eve,
            'fch_eve' => $request->fch_eve,
            'cat_eve' => $request->cat_eve,
            'capacidad_eve' => $request->capacidad_eve,
            'img_eve' => $evento->img_eve,
            'est_eve' => $request->est_eve,
        ]);

        return redirect('/mis-eventos')
            ->with('success', 'Evento actualizado');
    }

    // CANCELAR EVENTO
    public function destroy(Evento $evento)
    {
        if ($evento->usuario_id != auth()->id()) {

            abort(403);
        }

        $evento->update([
            'est_eve' => 'cancelado'
        ]);

        return redirect()->to('/eventos?cancelado=1');
    }
}