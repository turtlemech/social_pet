<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Conversacion;
use Illuminate\Support\Str;

class SolicitudAdopcionController extends Controller
{
    // Mostrar formulario
    public function create($id)
    {
        $adopcion = DB::table('adopciones')
            ->join('mascotas', 'adopciones.mas_id', '=', 'mascotas.id')
            ->leftJoin('especies', 'mascotas.especie_id', '=', 'especies.id')
            ->where('adopciones.id', $id)
            ->select(
                'adopciones.*',
                'mascotas.nom_mas',
                'mascotas.fot_mas',
                'especies.nom_esp as especie'
            )
            ->first();

        if (!$adopcion) {
            abort(404);
        }

        return view(
            'adopciones.solicitar',
            compact('adopcion')
        );
    }

    // Guardar solicitud
    public function store(Request $request, $id)
    {
        $request->validate([
            'telefono' => 'required|max:20',
            'ciudad' => 'required|max:100',
            'direccion' => 'required',
            'tipo_vivienda' => 'required',
            'tenencia_vivienda' => 'required',
            'personas_hogar' => 'required|integer|min:1',
            'motivo_adopcion' => 'required|min:20',
        ],
        [

    'telefono.required' => 'Debes ingresar un teléfono.',

    'ciudad.required' => 'Debes ingresar una ciudad.',

    'direccion.required' => 'Debes ingresar una dirección.',

    'tipo_vivienda.required' => 'Selecciona el tipo de vivienda.',

    'tenencia_vivienda.required' => 'Selecciona la tenencia de la vivienda.',

    'personas_hogar.required' => 'Debes indicar cuántas personas viven en el hogar.',

    'personas_hogar.min' => 'Debe existir al menos una persona en el hogar.',

    'motivo_adopcion.required' => 'Debes explicar por qué deseas adoptar.',

    'motivo_adopcion.min' => 'La descripción es muy corta. Escribe al menos 20 caracteres.',

]

);

        $existe = DB::table('solicitudes_adopcion')
            ->where('adopcion_id', $id)
            ->where('usuario_id', auth()->id())
            ->exists();

        if ($existe) {
            return back()->with(
                'error',
                'Ya enviaste una solicitud para esta mascota.'
            );
        }

        DB::table('solicitudes_adopcion')->insert([
            

            'adopcion_id' => $id,
            'usuario_id' => auth()->id(),

            'telefono' => $request->telefono,
            'ciudad' => $request->ciudad,
            'direccion' => $request->direccion,

            'tipo_vivienda' => $request->tipo_vivienda,
            'tenencia_vivienda' => $request->tenencia_vivienda,

            'tiene_patio' => $request->has('tiene_patio'),

            'personas_hogar' => $request->personas_hogar,

            'hay_ninos' => $request->has('hay_ninos'),

            'tiene_mascotas' => $request->has('tiene_mascotas'),

            'detalle_mascotas' => $request->detalle_mascotas,

            'motivo_adopcion' => $request->motivo_adopcion,

            'estado' => 'pendiente',

            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()
            ->route('adopciones.index')
            ->with(
                'success',
                '🐾 Solicitud de adopción enviada correctamente.'
            );
    }

    // Ver solicitudes recibidas
    public function misSolicitudes()
    {
        $solicitudes = DB::table('solicitudes_adopcion')
            ->join(
                'adopciones',
                'solicitudes_adopcion.adopcion_id',
                '=',
                'adopciones.id'
            )
            ->join(
                'usuarios',
                'solicitudes_adopcion.usuario_id',
                '=',
                'usuarios.id'
            )
            ->join(
                'mascotas',
                'adopciones.mas_id',
                '=',
                'mascotas.id'
            )
            ->where(
                'adopciones.us_act',
                auth()->id()
            )
            ->select(
                'solicitudes_adopcion.*',
                'usuarios.nom_us',
                'usuarios.app_us',
                'usuarios.apm_us',
                'mascotas.nom_mas',
                'mascotas.fot_mas'
            )
            ->latest()
            ->get();

        return view(
            'adopciones.solicitudes',
            compact('solicitudes')
        );
    }

    // Aprobar solicitud
    public function aprobar($id)
    {
        $solicitud = DB::table('solicitudes_adopcion')
            ->where('id', $id)
            ->first();

        if (!$solicitud) {
            abort(404);
        }

        DB::table('solicitudes_adopcion')
            ->where('id', $id)
            ->update([
                'estado' => 'aprobada',
                'updated_at' => now()
            ]);

        $adopcion = DB::table('adopciones')
            ->where('id', $solicitud->adopcion_id)
            ->first();

        if ($adopcion) {

            $conversation = Conversacion::create([

    'cod_con' => strtoupper(Str::random(8)),

    'tip_con' => 'individual',

    'tipo' => 'adopcion',

    'adopcion_id' => $adopcion->id,

    'us_crea' => auth()->id(),

    'fch_act_con' => now(),

    'act_con' => true,

]);

            $conversation->participantes()->attach([

                auth()->id() => [
                    'cod_conv_us' => strtoupper(Str::random(8)),
                    'act_conv_us' => true,
                ],

                $solicitud->usuario_id => [
                    'cod_conv_us' => strtoupper(Str::random(8)),
                    'act_conv_us' => true,
                ]

            ]);
        }

        return back()->with(
            'success',
            '✅ Solicitud aprobada y chat de adopción creado.'
        );
    }

    // Rechazar solicitud
    public function rechazar($id)
    {
        DB::table('solicitudes_adopcion')
            ->where('id', $id)
            ->update([
                'estado' => 'rechazada',
                'updated_at' => now()
            ]);

        return back()->with(
            'success',
            '❌ Solicitud rechazada correctamente.'
        );
    }
}