<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class EventoController extends Controller
{
    // MOSTRAR EVENTOS
    public function index()
    {
        $query = Evento::with([

    'usuario',

    'ubicacion',

    'participantes',

    'mascotasParticipantes',

    'mascotasParticipantes.especie'

])->withCount('mascotasParticipantes');

        // BUSCADOR
        if (request('buscar')) {

            $query->where(
                'nom_eve',
                'like',
                '%' . request('buscar') . '%'
            );
        }

        // FILTRO CATEGORÍA
        if (request('categoria')) {

            $query->where(
                'cat_eve',
                request('categoria')
            );
        }

        // FILTRO FECHA
        if (request('fecha')) {

            $query->whereDate(
                'fch_eve',
                request('fecha')
            );
        }

        $eventos = $query->get();

        foreach ($eventos as $evento) {

            $inicio = Carbon::parse($evento->fch_eve);

            // DURACIÓN DEL EVENTO
            $finEvento = $inicio->copy()->addHours(2);

            $diasRestantes = now()->diffInDays(
                $evento->fch_eve,
                false
            );

            $puntajeFecha = 0;

            // ESTADO EN TIEMPO REAL
            if (
    $evento->est_eve != 'cancelado'
    &&
    $evento->est_eve != 'finalizado'
) {

    if (now()->between($inicio, $finEvento)) {

        $evento->estado_temp = 'en_curso';

    } elseif (now()->gt($finEvento)) {

        $evento->estado_temp = 'finalizado';

    } else {

        $evento->estado_temp = 'activo';
    }

} else {

    $evento->estado_temp = $evento->est_eve;
}

            // SI YA FINALIZÓ
            if (
    in_array(
        ($evento->estado_temp ?? $evento->est_eve),
        ['finalizado', 'cancelado']
    )
) {

    if ($evento->destacado) {

        Evento::where('id', $evento->id)
            ->update([
                'destacado' => false
            ]);
    }

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
                ($evento->mascotas_participantes_count * 2)
                + $puntajeFecha;

            // DESTACADO AUTOMÁTICO
            $nuevoDestacado = $score >= 80;

            if ($evento->destacado != $nuevoDestacado) {

                Evento::where('id', $evento->id)
                    ->update([
                        'destacado' => $nuevoDestacado
                    ]);
            }

            // SCORE TEMPORAL SOLO PARA ORDENAR
            $evento->score_temp = $score;
        }

        // FILTRAR POR ESTADO EN TIEMPO REAL
        if (request('estado')) {

            $eventos = $eventos->filter(function ($evento) {

                return
                    ($evento->estado_temp ?? $evento->est_eve)
                    == request('estado');
            });
        }

        // ORDENAR EVENTOS
        $eventos = $eventos->sortByDesc(function ($evento) {

    $estado = $evento->estado_temp ?? $evento->est_eve;

    // Cancelados al fondo
    if ($estado == 'cancelado') {
        return -999999;
    }

    // Finalizados encima de cancelados
    if ($estado == 'finalizado') {
        return -500000;
    }

    // Activos y en curso arriba
    return
        (($evento->destacado ? 1 : 0) * 10000)
        + ($evento->score_temp ?? 0);

})->values();
$page = request()->get('page', 1);

$perPage = 15;

$eventos = new LengthAwarePaginator(

    $eventos->forPage($page, $perPage),

    $eventos->count(),

    $perPage,

    $page,

    [

        'path' => request()->url(),

        'query' => request()->query(),

    ]

);

$eventosDestacados = Evento::where(

    'destacado',

    true

)->count();

        return view(

    'eventos.index',

    compact(

        'eventos',

        'eventosDestacados'

    )

);
    }

    // MIS EVENTOS
    public function misEventos()
    {
        $eventos = Evento::with([

    'usuario',

    'ubicacion',

    'participantes',

    'mascotasParticipantes',

    'mascotasParticipantes.especie'

])
        ->where(
            'usuario_id',
            auth()->id()
        )
        ->latest()
        ->get();

        return view(
            'eventos.mis-eventos',
            compact('eventos')
        );
    }

    // EVENTOS DONDE PARTICIPO
    public function participando()
{
    $eventos = auth()->user()
        ->eventosParticipando()
        ->with([
            'usuario',
            'ubicacion',
            'participantes',
            'mascotasParticipantes',
            'mascotasParticipantes.especie'
        ])
        ->get();

    foreach ($eventos as $evento) {

        $inicio = Carbon::parse($evento->fch_eve);
        $finEvento = $inicio->copy()->addHours(2);

        if (
    $evento->est_eve != 'cancelado'
    &&
    $evento->est_eve != 'finalizado'
) {

    if (now()->between($inicio, $finEvento)) {

        $evento->estado_temp = 'en_curso';

    } elseif (now()->gt($finEvento)) {

        $evento->estado_temp = 'finalizado';

    } else {

        $evento->estado_temp = 'activo';
    }

} else {

    $evento->estado_temp = $evento->est_eve;
}
    }

    // SOLO EVENTOS DONDE TENGO AL MENOS UNA MASCOTA INSCRITA
    $eventos = $eventos->filter(function ($evento) {

        return $evento
            ->mascotasParticipantes()
            ->wherePivot('usuario_id', auth()->id())
            ->exists();

    });

    // ORDENAR
    $eventos = $eventos->sortByDesc(function ($evento) {

        switch ($evento->estado_temp) {

            case 'en_curso':
                return 4000000000;

            case 'activo':
                return 3000000000 + strtotime($evento->fch_eve);

            case 'finalizado':
                return 2000000000;

            case 'cancelado':
                return 1000000000;

            default:
                return 0;
        }

    });

    return view(
        'eventos.participando',
        compact('eventos')
    );
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
        $evento->participantes()->attach(
            auth()->id(),
            [
                'est_par' => 'aceptada'
            ]
        );

        return redirect()->to('/eventos?creado=1');
    }

    // UNIRSE A EVENTO
    public function join(Request $request, Evento $evento)

{

    $inicio = Carbon::parse($evento->fch_eve);

    $finEvento = $inicio->copy()->addHours(2);

    // ESTADO EN TIEMPO REAL

    if (

        $evento->est_eve != 'cancelado'

        &&

        $evento->est_eve != 'finalizado'

    ) {

        if (now()->between($inicio, $finEvento)) {

            $estadoActual = 'en_curso';

        } elseif (now()->gt($finEvento)) {

            $estadoActual = 'finalizado';

        } else {

            $estadoActual = 'activo';

        }

    } else {

        $estadoActual = $evento->est_eve;

    }

    // NO permitir eventos cancelados/finalizados

    if (

    $estadoActual == 'cancelado'

    ||

    $estadoActual == 'finalizado'

    ||

    $estadoActual == 'en_curso'

) {

    return back();

}

    // EL CREADOR YA PARTICIPA

    if ($evento->usuario_id == auth()->id()) {

        return back();

    }

    // MASCOTAS SELECCIONADAS

    $mascotas = $request->mascotas ?? [];

    if (count($mascotas) <= 0) {

        return back()->with(

            'error',

            'Selecciona al menos una mascota'

        );

    }

    // CUPOS OCUPADOS

    $cuposOcupados = $evento

        ->mascotasParticipantes()

        ->count();

    $nuevosCupos = count($mascotas);

    // VALIDAR CAPACIDAD

    if (

        $evento->capacidad_eve

        &&

        ($cuposOcupados + $nuevosCupos)

        > $evento->capacidad_eve

    ) {

        return back()->with(

            'error',

            'No hay suficientes cupos disponibles'

        );

    }

    // REGISTRAR USUARIO

    if (

        !$evento->participantes()

        ->where('usuario_id', auth()->id())

        ->exists()

    ) {

        $evento->participantes()->attach(

            auth()->id(),

            [

                'est_par' => 'aceptada'

            ]

        );

    }

    // REGISTRAR MASCOTAS

    foreach ($mascotas as $mascotaId) {

        // VALIDAR QUE LA MASCOTA SEA DEL USUARIO

        $mascota = auth()->user()

            ->mascotas()

            ->where('id', $mascotaId)

            ->first();

        if (!$mascota) {

            continue;

        }

        // EVITAR DUPLICADOS

        if (

              !$evento->mascotasParticipantes()

        ->where('mascota_id', $mascotaId)

        ->exists()

        ) {

            $evento->mascotasParticipantes()

                ->attach(

                    $mascotaId,

                    [

                        'usuario_id' => auth()->id()

                    ]

                );

        }

    }

    return back()->with(

        'success',

        'Participación registrada'

    );

}

    // VER DETALLES
    public function show(Evento $evento)
    {
        $evento->load([

    'usuario',

    'ubicacion',

    'participantes',

    'mascotasParticipantes',

    'mascotasParticipantes.especie'

]);

        $inicio = Carbon::parse($evento->fch_eve);

        $finEvento = $inicio->copy()->addHours(2);

        if (

    $evento->est_eve != 'cancelado'

    &&

    $evento->est_eve != 'finalizado'

) {

    if (now()->between($inicio, $finEvento)) {

        $evento->estado_temp = 'en_curso';

    } elseif (now()->gt($finEvento)) {

        $evento->estado_temp = 'finalizado';

    } else {

        $evento->estado_temp = 'activo';
    }

} else {

    $evento->estado_temp = $evento->est_eve;
}

        return view(
            'eventos.show',
            compact('evento')
        );
    }

    // EDITAR EVENTO
    public function edit(Evento $evento)
    {
        if ($evento->usuario_id != auth()->id()) {

            abort(403);
        }

        $evento->load('ubicacion');

        return view(
            'eventos.edit',
            compact('evento')
        );
    }

    // ACTUALIZAR EVENTO
    public function update(
        Request $request,
        Evento $evento
    ) {
        if ($evento->usuario_id != auth()->id()) {

            abort(403);
        }

        $inicio = Carbon::parse($evento->fch_eve);

        $finEvento = $inicio->copy()->addHours(2);

        if (now()->gt($finEvento)) {

            return back();
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
        $participantesActuales = $evento

    ->mascotasParticipantes()

    ->count();

if (

    $request->capacidad_eve

    &&

    $request->capacidad_eve < $participantesActuales

) {

    return back()->with(

        'error',

        'La capacidad no puede ser menor a las mascotas registradas'

    );

}

        // ACTUALIZAR UBICACIÓN
        $evento->ubicacion->update([
            'nom_ubi' => $request->nom_ubi,
        ]);

        // NUEVA IMAGEN
        if ($request->hasFile('img_eve')) {

            if ($evento->img_eve) {

                Storage::disk('public')
                    ->delete($evento->img_eve);
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
            ->with(
                'success',
                'Evento actualizado'
            );
    }

    // CANCELAR EVENTO
    public function destroy(Evento $evento)
    {
        if ($evento->usuario_id != auth()->id()) {

            abort(403);
        }

        $inicio = Carbon::parse($evento->fch_eve);

        $finEvento = $inicio->copy()->addHours(2);

        if (now()->lt($finEvento)) {

            $evento->update([
                'est_eve' => 'cancelado'
            ]);
        }

        return redirect()->to('/eventos?cancelado=1');
    }

    // REACTIVAR EVENTO
    public function reactivar(Evento $evento)
    {
        if ($evento->usuario_id != auth()->id()) {

            abort(403);
        }

        $inicio = Carbon::parse($evento->fch_eve);

        $finEvento = $inicio->copy()->addHours(2);

        if (

            $evento->est_eve == 'cancelado'

            &&

            now()->lt($finEvento)

        ) {

            $evento->update([
                'est_eve' => 'activo'
            ]);
        }

        return redirect()->to(
            '/eventos?reactivado=1'
        );
    }
    // FINALIZAR EVENTO
public function finalizar(Evento $evento)

{

    if ($evento->usuario_id != auth()->id()) {

        abort(403);

    }

    $evento->update([

        'est_eve' => 'finalizado'

    ]);

    return redirect()->to('/eventos?finalizado=1');

}
}