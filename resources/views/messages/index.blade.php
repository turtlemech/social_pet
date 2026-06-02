@extends('layouts.app')

@section('content')

@php

$following = auth()->user()
    ->siguiendo()
    ->take(10)
    ->get();

$suggestedUsers = \App\Models\User::where('id', '!=', auth()->id())
    ->whereNotIn('id', $following->pluck('id'))
    ->latest()
    ->take(10)
    ->get();

@endphp

<div class="h-[calc(100vh-72px)] bg-gradient-to-br from-slate-100 to-gray-200 p-4">

    <div class="h-full max-w-7xl mx-auto rounded-[32px] overflow-hidden shadow-2xl border border-white/40 backdrop-blur-xl bg-white/70 flex">

        <!-- SIDEBAR -->
        <div class="w-full md:w-[380px] bg-white/80 backdrop-blur-xl border-r border-gray-200 flex flex-col">

            <!-- HEADER -->
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">

                <div>

                    <h1 class="text-2xl font-bold text-gray-800">
                        Mensajes
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Conecta con otros amantes de mascotas
                    </p>

                </div>


            </div>

            <!-- SEARCH -->
            <div class="p-4 border-b border-gray-100">

                <div class="relative">

                    <input
                        type="text"
                        placeholder="Buscar personas..."
                        class="w-full bg-gray-100 border-0 rounded-2xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-teal-500"
                    >

                    <svg
                        class="w-5 h-5 absolute left-4 top-3.5 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        />

                    </svg>

                </div>

            </div>

            <!-- CONTENIDO -->
            <div class="flex-1 overflow-y-auto p-4">

                <!-- CONVERSACIONES -->
                @if($conversations->count())

                <div class="mb-6">

                    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-400 px-2 mb-4">
                        Conversaciones
                    </h2>

                    <div class="space-y-2">

                        @foreach($conversations as $conversation)

                            @php

                                $chatUser = $conversation
                                    ->participantes
                                    ->where('id', '!=', auth()->id())
                                    ->first();

                            @endphp

                            @if($chatUser)

                            <a
                                href="{{ route('messages.show', $conversation->id) }}"
                                class="flex items-center gap-3 p-3 rounded-2xl hover:bg-gray-100 transition"
                            >

                                <img
                                    src="{{ $chatUser->ava_us
                                        ? asset('storage/' . $chatUser->ava_us)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($chatUser->nom_us)
                                    }}"
                                    class="w-14 h-14 rounded-full object-cover"
                                >

                                <div class="flex-1 min-w-0">

                                    <h3 class="font-semibold text-gray-800 truncate">
                                        {{ $chatUser->nom_us }}
                                    </h3>

                                    <p class="text-sm text-gray-500 truncate">

                                        {{ $conversation->ultimoMensaje->con_men ?? 'Sin mensajes' }}

                                    </p>

                                </div>

                            </a>

                            @endif

                        @endforeach

                    </div>

                </div>

                @endif

                <!-- PERSONAS QUE SIGUES -->
                <div class="mb-4">

                    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-400 px-2">
                        Personas que sigues
                    </h2>

                </div>

                <div class="space-y-3">

                    @forelse($following as $user)

                    <div class="bg-white rounded-3xl p-4 shadow-sm hover:shadow-md transition border border-gray-100">

                        <div class="flex items-center gap-4">

                            <div class="relative">

                                <img
                                    src="{{ $user->ava_us
                                        ? asset('storage/' . $user->ava_us)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->nom_us)
                                    }}"
                                    class="w-16 h-16 rounded-full object-cover"
                                >

                                <span class="absolute bottom-0 right-0 w-4 h-4 bg-green-400 border-2 border-white rounded-full"></span>

                            </div>

                            <div class="flex-1 min-w-0">

                                <h3 class="font-bold text-gray-800 truncate">
                                    {{ $user->nom_us }}
                                </h3>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ $user->ema_us }}
                                </p>

                            </div>

                        </div>

                        <div class="flex gap-2 mt-4">

                            <a
                                href="{{ route('usuario.profile', $user->id) }}"
                                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 rounded-2xl font-medium transition text-center"
                            >
                                Ver perfil
                            </a>

                            <form
                                action="{{ route('messages.start', $user->id) }}"
                                method="POST"
                                class="flex-1"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="w-full bg-gradient-to-r from-teal-500 to-emerald-500 text-white py-2.5 rounded-2xl font-medium hover:scale-[1.02] transition"
                                >
                                    Mensaje
                                </button>

                            </form>

                        </div>

                    </div>

                    @empty

                    <div class="text-center py-10 text-gray-500">
                        No sigues a nadie todavía
                    </div>

                    @endforelse

                </div>

                <!-- SUGERIDOS -->
                @if($suggestedUsers->count())

                <div class="mt-8 mb-4">

                    <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-400 px-2">
                        Personas sugeridas
                    </h2>

                </div>

                <div class="space-y-3">

                    @foreach($suggestedUsers as $user)

                    <div class="bg-white rounded-3xl p-4 shadow-sm hover:shadow-md transition border border-gray-100">

                        <div class="flex items-center gap-4">

                            <img
                                src="{{ $user->ava_us
                                    ? asset('storage/' . $user->ava_us)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->nom_us)
                                }}"
                                class="w-16 h-16 rounded-full object-cover"
                            >

                            <div class="flex-1 min-w-0">

                                <h3 class="font-bold text-gray-800 truncate">
                                    {{ $user->nom_us }}
                                </h3>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ $user->ema_us }}
                                </p>

                            </div>

                        </div>

                        <div class="flex gap-2 mt-4">

                            <a
                                href="{{ route('usuario.profile', $user->id) }}"
                                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 rounded-2xl font-medium transition text-center"
                            >
                                Ver perfil
                            </a>

                            <form
                                action="{{ route('messages.start', $user->id) }}"
                                method="POST"
                                class="flex-1"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="w-full bg-gradient-to-r from-teal-500 to-emerald-500 text-white py-2.5 rounded-2xl font-medium"
                                >
                                    Mensaje
                                </button>

                            </form>

                        </div>

                    </div>

                    @endforeach

                </div>

                @endif

            </div>

        </div>

        <!-- EMPTY STATE -->
        <div class="hidden md:flex flex-1 items-center justify-center bg-gradient-to-br from-gray-50 to-slate-100">

            <div class="text-center max-w-md px-8">

                <div class="w-32 h-32 rounded-full bg-gradient-to-r from-teal-500 to-emerald-500 mx-auto flex items-center justify-center shadow-2xl mb-8">

                    <svg
                        class="w-16 h-16 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M21 10c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 18l1.395-3.72C3.512 13.042 3 11.574 3 10c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                        />

                    </svg>

                </div>

                <h2 class="text-4xl font-black text-gray-800 mb-4">
                    Tus mensajes
                </h2>

                <p class="text-gray-500 text-lg leading-relaxed">
                    Envía mensajes privados, conecta con otros usuarios y comparte historias sobre mascotas.
                </p>

            </div>

        </div>

    </div>

</div>

@endsection