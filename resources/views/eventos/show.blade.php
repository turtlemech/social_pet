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
        <div class="absolute top-8 left-8 z-20">

    <a
        href="{{ route('eventos.index') }}"
        class="flex items-center gap-2 bg-white/15 backdrop-blur-xl border border-white/20 hover:bg-white/25 text-white px-5 py-3 rounded-2xl font-semibold transition"
    >

        ← Volver

    </a>

</div>

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

            <div class="bg-white rounded-[28px] shadow-xl p-8 sticky top-10">

                <h2 class="text-2xl font-black text-gray-900 mb-6">
                    Información
                </h2>

                @php

    $mascotasUsuario = auth()->check()
        ? auth()->user()->mascotas
        : collect();

    $mascotasParticipando = auth()->check()
        ? $evento->mascotasParticipantes
            ->where('usuario_id', auth()->id())
            ->pluck('id')
            ->toArray()
        : [];

    $todasParticipando =
        $mascotasUsuario->count() > 0
        &&
        $mascotasUsuario->every(function ($mascota) use ($mascotasParticipando) {
            return in_array($mascota->id, $mascotasParticipando);
        });

    $cuposDisponibles = $evento->capacidad_eve
        ? max(0, $evento->capacidad_eve - $evento->mascotasParticipantes->count())
        : null;

    $tieneMascotas = auth()->check()
        && $mascotasUsuario->count() > 0;

@endphp

                <!-- INFO -->
                <div class="space-y-5 text-gray-600">

                    <!-- PARTICIPANTES -->
                    <div>

                        👥

                        {{ $evento->mascotasParticipantes->count() }}

                        {{ $evento->mascotasParticipantes->count() == 1
                            ? 'mascota participando'
                            : 'mascotas participando'
                        }}

                    </div>

                    <!-- CUPOS -->
                    <div class="flex items-center text-gray-500">

                        <span class="mr-2">🎟️</span>

                        @if($evento->capacidad_eve)

                            {{ $cuposDisponibles }}

                            {{ $cuposDisponibles == 1
                                ? 'cupo disponible'
                                : 'cupos disponibles'
                            }}

                        @else

                            Cupos ilimitados

                        @endif

                    </div>

                    <!-- ORGANIZADOR -->
                    <div>
                        🐾 Organizado por:
                        {{ $evento->usuario->nom_us ?? 'Usuario' }}
                    </div>

                </div>

                <!-- MASCOTAS PARTICIPANTES -->
                <div class="mt-8">

                    <h3 class="text-xl font-black text-gray-900 mb-4">
                        Mascotas participantes
                    </h3>

                    <div class="space-y-3">

                        @forelse($evento->mascotasParticipantes as $mascota)

                            <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-2xl">

                                <div class="w-14 h-14 rounded-full overflow-hidden bg-gray-200">

                                    @if($mascota->fot_mas)

                                        <img
                                            src="{{ asset('storage/' . $mascota->fot_mas) }}"
                                            class="w-full h-full object-cover"
                                        >

                                    @else

                                        <div class="w-full h-full flex items-center justify-center text-2xl">
                                            🐾
                                        </div>

                                    @endif

                                </div>

                                <div>

                                    <div class="font-bold text-gray-800">
                                        {{ $mascota->nom_mas }}
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        {{ $mascota->especie->nom_esp ?? 'Mascota' }}
                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="text-gray-500">
                                Aún no hay mascotas registradas.
                            </div>

                        @endforelse

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

                        @if($todasParticipando)

                            <div class="w-full bg-emerald-100 text-emerald-700 py-4 rounded-2xl text-center font-bold">

                                ✔ Ya participas en este evento

                            </div>

                        @elseif($evento->capacidad_eve && $cuposDisponibles <= 0)

                            <div class="w-full bg-red-100 text-red-600 py-4 rounded-2xl text-center font-bold">

                                Evento lleno

                            </div>

                        @elseif(auth()->check())

                            @if($tieneMascotas)

                                <button
                                    type="button"
                                    onclick="abrirModalMascotas()"
                                    class="w-full bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 text-white py-4 rounded-2xl font-bold shadow-xl hover:scale-[1.02] transition"
                                >

                                    Participar

                                </button>

                            @else

                                <div
                                    class="w-full bg-yellow-100 text-yellow-700 py-4 rounded-2xl text-center font-bold"
                                >

                                    Debes registrar una mascota para participar 🐾

                                </div>

                            @endif

                        @else

                            <a
                                href="{{ route('login') }}"
                                class="block w-full bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 text-white py-4 rounded-2xl font-bold shadow-xl text-center"
                            >

                                Inicia sesión para participar

                            </a>

                        @endif

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

<!-- MODAL -->
<div
    id="modalMascotas"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center p-6"
>

    <div class="bg-white w-full max-w-lg rounded-[32px] p-8 relative">

        <!-- CERRAR -->
        <button
            type="button"
            onclick="cerrarModalMascotas()"
            class="absolute top-5 right-5 w-10 h-10 rounded-full bg-gray-100 hover:bg-red-500 hover:text-white transition"
        >
            ✕
        </button>

        <div class="mb-8">

            <p class="text-teal-500 uppercase text-sm font-bold tracking-widest mb-2">
                Participar en evento
            </p>

            <h2 class="text-3xl font-black text-gray-900">
                Selecciona tus mascotas 🐾
            </h2>

        </div>

        <form
            action="{{ route('eventos.join', $evento) }}"
            method="POST"
        >

            @csrf

            <div class="space-y-4 max-h-80 overflow-y-auto pr-2">
                @php

$mascotasDisponibles = auth()->user()?->mascotas

    ->whereNotIn('id', $mascotasParticipando)

    ?? collect();

@endphp

                @forelse($mascotasDisponibles as $mascota)

                    <label
                        class="flex items-center gap-4 p-4 rounded-2xl border border-gray-200 hover:border-teal-400 hover:bg-teal-50 transition cursor-pointer"
                    >

                        <input
                            type="checkbox"
                            name="mascotas[]"
                            value="{{ $mascota->id }}"
                            class="w-5 h-5 text-teal-500 rounded"
                        >

                        <div class="w-14 h-14 rounded-full overflow-hidden bg-gray-200">

                            @if($mascota->fot_mas)

                                <img
                                    src="{{ asset('storage/' . $mascota->fot_mas) }}"
                                    class="w-full h-full object-cover"
                                >

                            @else

                                <div class="w-full h-full flex items-center justify-center text-2xl">
                                    🐾
                                </div>

                            @endif

                        </div>

                        <div>

                            <div class="font-bold text-gray-800">
                                {{ $mascota->nom_mas }}
                            </div>

                            <div class="text-sm text-gray-500">
                                {{ $mascota->especie->nom_esp ?? 'Mascota' }}
                            </div>

                        </div>

                    </label>

                @empty

                    <div class="text-center text-gray-500 py-10">

                        No tienes mascotas registradas.

                    </div>

                @endforelse

            </div>

            <button
                type="submit"
                class="w-full mt-8 bg-gradient-to-r from-teal-500 to-emerald-500 text-white py-4 rounded-2xl font-bold shadow-xl hover:scale-[1.02] transition"
            >

                Confirmar participación

            </button>

        </form>

    </div>

</div>

<script>

function abrirModalMascotas()
{
    const modal = document.getElementById('modalMascotas');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.body.style.overflow = 'hidden';
}

function cerrarModalMascotas()
{
    const modal = document.getElementById('modalMascotas');

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    document.body.style.overflow = 'auto';
}

</script>

@endsection