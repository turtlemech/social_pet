@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#f4f7fb]">

    <!-- HERO IMAGE -->
    <div class="relative h-[420px] overflow-hidden">

        <img
            src="{{ $evento->img_eve
                ? asset('storage/' . $evento->img_eve)
                : 'https://images.unsplash.com/photo-1517849845537-4d257902454a?q=80&w=1400&auto=format&fit=crop'
            }}"
            class="w-full h-full object-cover"
        >

        <div class="absolute inset-0 bg-black/50"></div>

        <div class="absolute bottom-10 left-10 text-white">

            <span class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm font-semibold">

                {{ $evento->cat_eve }}

            </span>

            <h1 class="text-5xl font-black mt-5">

                {{ $evento->nom_eve }}

            </h1>

            <p class="mt-3 text-lg text-white/80">

                📅 {{ \Carbon\Carbon::parse($evento->fch_eve)->format('d M Y - H:i') }}

            </p>

        </div>

    </div>

    <!-- CONTENT -->
    <div class="max-w-6xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- LEFT -->
        <div class="lg:col-span-2">

            <!-- DESCRIPTION -->
            <div class="bg-white rounded-[28px] shadow-xl p-8">

                <h2 class="text-3xl font-black text-gray-900 mb-6">
                    Descripción
                </h2>

                <p class="text-gray-600 leading-8 text-lg">

                    {{ $evento->des_eve }}

                </p>

            </div>

            <!-- MAP -->
            <div class="bg-white rounded-[28px] shadow-xl p-8 mt-8">

                <h2 class="text-3xl font-black text-gray-900 mb-6">
                    Ubicación
                </h2>

                <div class="rounded-2xl overflow-hidden">

                    <iframe
                        width="100%"
                        height="400"
                        style="border:0"
                        loading="lazy"
                        allowfullscreen
                        src="https://www.google.com/maps?q={{ $evento->ubicacion->latitud }},{{ $evento->ubicacion->longitud }}&hl=es&z=15&output=embed">
                    </iframe>

                </div>

                <div class="mt-5 text-gray-600">

                    <p>
                        📍 {{ $evento->ubicacion->nom_ubi }}
                    </p>

                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div>

            <!-- INFO -->
            <div class="bg-white rounded-[28px] shadow-xl p-8 sticky top-10">

                <h2 class="text-2xl font-black text-gray-900 mb-6">
                    Información
                </h2>

                <div class="space-y-5 text-gray-600">

                    <div>
                        👥
                        {{ $evento->participantes->count() }}
                        participantes
                    </div>

                    @if($evento->capacidad_eve)

                        <div>
                            🎟️
                            {{ $evento->capacidad_eve }}
                            cupos
                        </div>

                    @endif

                    <div>
                        🐾 Organizado por:
                        {{ $evento->usuario->nom_us ?? 'Usuario' }}
                    </div>

                </div>

                <!-- BUTTON -->
                <div class="mt-8">

                    @if(auth()->check() && $evento->usuario_id == auth()->id())

                        <form
                            action="{{ route('eventos.destroy', $evento) }}"
                            method="POST"
                        >

                            @csrf
                            @method('DELETE')

                            <button
                                class="w-full bg-red-500 hover:bg-red-600 text-white py-4 rounded-2xl font-bold transition"
                            >
                                Eliminar Evento
                            </button>

                        </form>

                    @else

                        <form
                            action="{{ route('eventos.join', $evento) }}"
                            method="POST"
                        >

                            @csrf

                            <button
                                class="w-full bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 text-white py-4 rounded-2xl font-bold shadow-xl hover:scale-[1.02] transition"
                            >
                                Participar
                            </button>

                        </form>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
