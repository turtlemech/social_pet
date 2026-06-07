@extends('layouts.app')

@section('content')

@php

$otherUser = $conversation
    ->participantes
    ->where('id', '!=', auth()->id())
    ->first();

$conversations = auth()->user()

    ->conversaciones()

    ->where('tipo', 'marketplace')

    ->with('ultimoMensaje', 'participantes')

    ->latest('fch_act_con')

    ->get();

@endphp

<div class="h-[calc(100vh-72px)] bg-gradient-to-br from-slate-100 to-gray-200 p-4">

    <div class="h-full max-w-7xl mx-auto rounded-[32px] overflow-hidden shadow-2xl border border-white/40 backdrop-blur-xl bg-white/70 flex">

        <!-- SIDEBAR -->
        <div class="hidden md:flex md:w-[380px] bg-white/80 backdrop-blur-xl border-r border-gray-200 flex-col">

            <!-- HEADER -->
            <div class="p-6 border-b border-gray-100">

                <h1 class="text-2xl font-bold text-gray-800">
    🛒 Marketplace
</h1>

<p class="text-sm text-gray-500 mt-1">
    Conversaciones sobre productos
</p>

            </div>
            <div class="mx-6 mt-4 bg-teal-50 border border-teal-200 rounded-2xl p-4">

    <div class="flex items-center gap-3">

        <div class="text-3xl">
            🛒
        </div>

        <div>

            <h3 class="font-bold text-teal-700">
    Compra segura
</h3>

<p class="text-sm text-gray-600">
    Utiliza este chat para coordinar detalles, pagos y entrega del producto.
</p>

        </div>

    </div>

</div>

            <!-- CONVERSACIONES -->
            <div class="flex-1 overflow-y-auto p-3 space-y-2">

                @foreach($conversations as $conv)

                    @php

                        $user = $conv
                            ->participantes
                            ->where('id', '!=', auth()->id())
                            ->first();

                    @endphp

                    @if($user)

                    <a
                        href="{{ route('messages.show', $conv->id) }}"
                        class="flex items-center gap-4 p-4 rounded-3xl transition
                        {{ $conversation->id == $conv->id
                            ? 'bg-gradient-to-r from-teal-500 to-emerald-500 text-white shadow-lg'
                            : 'hover:bg-gray-100'
                        }}"
                    >

                        <img
                            src="{{ $user->ava_us
                                ? asset('storage/' . $user->ava_us)
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->nom_us)
                            }}"
                            class="w-14 h-14 rounded-full object-cover"
                        >

                        <div class="flex-1 min-w-0">

                            <div class="flex items-center justify-between">

                                <h3 class="font-semibold truncate">
                                    {{ $user->nom_us }}
                                </h3>

                                @if($conv->ultimoMensaje)

                                <span class="text-xs opacity-70">

                                    {{ $conv->ultimoMensaje->created_at->diffForHumans() }}

                                </span>

                                @endif

                            </div>

                            <p class="text-sm truncate opacity-80">

                                {{ $conv->ultimoMensaje->con_men ?? 'Sin mensajes' }}

                            </p>

                        </div>

                    </a>

                    @endif

                @endforeach

            </div>

        </div>

        <!-- CHAT -->
        <div class="flex-1 flex flex-col bg-gradient-to-br from-gray-50 to-slate-100">

            <!-- HEADER -->
            <div class="px-8 py-5 border-b border-gray-200 bg-white/70 backdrop-blur-xl flex items-center justify-between">

                <div class="flex items-center gap-4">

                   <a

    href="{{ route('messages.marketplace') }}"

    class="flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 transition"

>

    <span>←</span>

    <span class="text-sm font-medium">Volver</span>

</a>

                    <img
                        src="{{ $otherUser->ava_us
                            ? asset('storage/' . $otherUser->ava_us)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($otherUser->nom_us)
                        }}"
                        class="w-14 h-14 rounded-full object-cover"
                    >

                    <div>

                        <h2 class="font-bold text-xl text-gray-800">
                            {{ $otherUser->nom_us }}
                        </h2>

                        <p class="text-sm text-teal-600">
    🛒 Chat de Marketplace
</p>


                    </div>

</div>

</div>
@if(isset($productoInfo))

<div class="mx-6 mt-4">

    <div class="bg-white border border-gray-200 rounded-2xl p-4 flex items-center gap-4 shadow-sm">

        @if($productoInfo->img_pro)

        <img
            src="{{ asset('storage/' . $productoInfo->img_pro) }}"
            class="w-20 h-20 rounded-xl object-cover"
        >

        @endif

        <div>

            <p class="text-xs uppercase text-gray-500">
                Producto
            </p>

            <h3 class="font-bold text-lg text-gray-800">
                {{ $productoInfo->nom_pro }}
            </h3>

            <p class="text-sm text-gray-600 mt-2">
                {{ $productoInfo->des_pro }}
            </p>

            <p class="text-teal-600 font-bold mt-2">
                Bs. {{ number_format($productoInfo->pre_pro, 2) }}
            </p>

        </div>

    </div>

</div>

@endif

<!-- MENSAJES -->
            <div class="flex-1 overflow-y-auto px-6 md:px-8 py-8 space-y-6">

                @forelse($conversation->mensajes as $mensaje)

                    @if($mensaje->us_rem == auth()->id())

                        <!-- ENVIADO -->
                        <div class="flex justify-end">

                            <div class="bg-gradient-to-r from-teal-500 to-emerald-500 text-white px-5 py-4 rounded-[24px] rounded-br-md shadow-lg max-w-md">

                                <p>
                                    {{ $mensaje->con_men }}
                                </p>

                                <span class="text-xs text-white/70 mt-2 block">

                                    {{ $mensaje->created_at->format('h:i A') }}

                                </span>

                            </div>

                        </div>

                    @else

                        <!-- RECIBIDO -->
                        <div class="flex items-end gap-3">

                            <img
                                src="{{ $otherUser->ava_us
                                    ? asset('storage/' . $otherUser->ava_us)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($otherUser->nom_us)
                                }}"
                                class="w-10 h-10 rounded-full object-cover"
                            >

                            <div class="bg-white px-5 py-4 rounded-[24px] rounded-bl-md shadow-sm max-w-md">

                                <p class="text-gray-700">
                                    {{ $mensaje->con_men }}
                                </p>

                                <span class="text-xs text-gray-400 mt-2 block">

                                    {{ $mensaje->created_at->format('h:i A') }}

                                </span>

                            </div>

                        </div>

                    @endif

                @empty

                    <div class="h-full flex items-center justify-center">

                        <div class="text-center">

                            <div class="text-6xl mb-4">
                                🛒
                            </div>

                            <h2 class="text-2xl font-bold text-gray-700">
    Sin mensajes de marketplace todavía
</h2>

                            <p class="text-gray-500 mt-2">
                                Envía el primer mensaje
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>

            <!-- INPUT -->
            <div class="p-4 md:p-6 bg-white/80 backdrop-blur-xl border-t border-gray-200">

                <form
                    action="{{ route('messages.send', $conversation->id) }}"
                    method="POST"
                    class="flex items-center gap-4"
                >

                    @csrf

                    <input
                        type="text"
                        name="mensaje"
                        placeholder="Escribe un mensaje..."
                        class="flex-1 bg-gray-100 border-0 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-teal-500"
                        required
                    >

                    <button
                        type="submit"
                        class="px-7 py-4 rounded-2xl bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-semibold shadow-lg hover:scale-[1.02] transition"
                    >
                        Enviar
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection