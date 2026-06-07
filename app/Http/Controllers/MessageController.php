<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\User;
use App\Models\Conversacion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    // LISTA DE CONVERSACIONES
    public function index()
    {
        $conversations = auth()->user()

    ->conversaciones()

    ->where('tipo', 'normal')

    ->with('ultimoMensaje')

    ->latest('fch_act_con')

    ->get();

        return view('messages.index', [

    'conversations' => $conversations

]);
    }
    public function adopciones()
{
    $conversations = auth()->user()
        ->conversaciones()
        ->where('tipo', 'adopcion')
        ->with('ultimoMensaje')
        ->latest('fch_act_con')
        ->get();

    return view(
        'messages.adopciones',
        compact('conversations')
    );
}

    // VER CHAT
    public function show($id)
{
    $conversation = Conversacion::with([
        'mensajes.remitente',
        'participantes'
    ])->findOrFail($id);

    // ADOPCIONES
    if ($conversation->tipo === 'adopcion') {

        $adopcionInfo = DB::table('adopciones')
            ->join(
                'mascotas',
                'adopciones.mas_id',
                '=',
                'mascotas.id'
            )
            ->where(
                'adopciones.id',
                $conversation->adopcion_id
            )
            ->select(
                'adopciones.id',
                'adopciones.des_ado',
                'mascotas.nom_mas',
                'mascotas.fot_mas'
            )
            ->first();

        return view(
            'messages.show-adopcion',
            compact(
                'conversation',
                'adopcionInfo'
            )
        );
    }

    // MARKETPLACE
    if ($conversation->tipo === 'marketplace') {

        $productoInfo = DB::table('productos')
            ->where(
                'id',
                $conversation->producto_id
            )
            ->first();

        return view(
            'messages.show-marketplace',
            compact(
                'conversation',
                'productoInfo'
            )
        );
    }

    // CHAT NORMAL
    return view(
        'messages.show',
        compact('conversation')
    );
}
   

    // CREAR O ABRIR CHAT
    public function start($userId)
    {
        $authId = auth()->id();

        // Buscar conversación existente
        $conversation = Conversacion::whereHas(
            'participantes',
            fn($q) => $q->where('usuarios.id', $authId)
        )
        ->whereHas(
            'participantes',
            fn($q) => $q->where('usuarios.id', $userId)
        )
        ->first();

        // Si no existe → crear
        if (!$conversation) {

            $conversation = Conversacion::create([

    'cod_con' => strtoupper(Str::random(8)),

    'tip_con' => 'individual',

    'tipo' => 'normal',

    'us_crea' => $authId,

    'fch_act_con' => now(),

    'act_con' => true,

]);

            $conversation->participantes()->attach([

    $authId => [

        'cod_conv_us' => strtoupper(Str::random(8)),

        'act_conv_us' => true,

    ],

    $userId => [

        'cod_conv_us' => strtoupper(Str::random(8)),

        'act_conv_us' => true,

    ]

]);
        }

        return redirect()->route(
            'messages.show',
            $conversation->id
        );
    }

    // ENVIAR MENSAJE
    public function send(Request $request, $id)
    {
        $request->validate([
            'mensaje' => 'required|string|max:5000'
        ]);

        $conversation = Conversacion::findOrFail($id);

        Mensaje::create([
            'cod_mens' => strtoupper(Str::random(8)),
            'con_men' => $request->mensaje,
            'tip_men' => 'texto',
            'con_id' => $conversation->id,
            'us_rem' => auth()->id(),
        ]);

        $conversation->update([
            'fch_act_con' => now()
        ]);

        return back();
    }
    public function startAdopcion($userId, $adopcionId)
{
    $authId = auth()->id();

    $conversation = Conversacion::where('tipo', 'adopcion')
        ->where('adopcion_id', $adopcionId)
        ->whereHas(
            'participantes',
            fn($q) => $q->where('usuarios.id', $authId)
        )
        ->whereHas(
            'participantes',
            fn($q) => $q->where('usuarios.id', $userId)
        )
        ->first();

    if (!$conversation) {

        $conversation = Conversacion::create([

            'cod_con' => strtoupper(Str::random(8)),
            'tip_con' => 'individual',
            'tipo' => 'adopcion',
            'adopcion_id' => $adopcionId,
            'us_crea' => $authId,
            'fch_act_con' => now(),
            'act_con' => true,

        ]);

        $conversation->participantes()->attach([

            $authId => [
                'cod_conv_us' => strtoupper(Str::random(8)),
                'act_conv_us' => true,
            ],

            $userId => [
                'cod_conv_us' => strtoupper(Str::random(8)),
                'act_conv_us' => true,
            ]

        ]);
    }

    return redirect()->route(
        'messages.show',
        $conversation->id
    );

}
public function marketplace()

{

    $conversations = auth()->user()

        ->conversaciones()

        ->where('tipo', 'marketplace')

        ->with([

            'participantes',

            'ultimoMensaje'

        ])

        ->latest('fch_act_con')

        ->get();

    return view(

        'messages.marketplace',

        compact('conversations')

    );

}
public function startMarketplace($userId, $productoId)
{
    $authId = auth()->id();

    $conversation = Conversacion::where('tipo', 'marketplace')
        ->where('producto_id', $productoId)
        ->whereHas(
            'participantes',
            fn($q) => $q->where('usuarios.id', $authId)
        )
        ->whereHas(
            'participantes',
            fn($q) => $q->where('usuarios.id', $userId)
        )
        ->first();

    if (!$conversation) {

        $conversation = Conversacion::create([

            'cod_con' => strtoupper(Str::random(8)),
            'tip_con' => 'individual',
            'tipo' => 'marketplace',
            'producto_id' => $productoId,
            'us_crea' => $authId,
            'fch_act_con' => now(),
            'act_con' => true,

        ]);

        $conversation->participantes()->attach([

            $authId => [
                'cod_conv_us' => strtoupper(Str::random(8)),
                'act_conv_us' => true,
            ],

            $userId => [
                'cod_conv_us' => strtoupper(Str::random(8)),
                'act_conv_us' => true,
            ]

        ]);

        Mensaje::create([
            'cod_mens' => strtoupper(Str::random(8)),
            'con_men' => 'Hola, estoy interesado en este producto.',
            'tip_men' => 'texto',
            'con_id' => $conversation->id,
            'us_rem' => $authId,
        ]);
    }

    return redirect()->route(
        'messages.show',
        $conversation->id
    );
}

}