<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\User;
use App\Models\Conversacion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    // LISTA DE CONVERSACIONES
    public function index()
    {
        $conversations = auth()->user()
            ->conversaciones()
            ->with('ultimoMensaje')
            ->latest()
            ->get();

        return view('messages.index', [

    'conversations' => $conversations

]);
    }

    // VER CHAT
    public function show($id)
    {
        $conversation = Conversacion::with([
            'mensajes.remitente',
            'participantes'
        ])->findOrFail($id);

        return view('messages.show', compact('conversation'));
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
}