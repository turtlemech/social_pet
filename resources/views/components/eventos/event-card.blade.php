@props(['evento'])

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

$cuposDisponibles = max(
    0,
    $evento->capacidad_eve - $evento->mascotasParticipantes->count()
);

$mascotasDisponibles = auth()->check()
    ? auth()->user()->mascotas
        ->whereNotIn('id', $mascotasParticipando)
    : collect();

@endphp

<div
    class="group bg-white rounded-[28px] overflow-hidden border border-gray-100 shadow-sm hover:shadow-[0_25px_80px_rgba(0,0,0,0.18)] transition duration-500

    @if(($evento->estado_temp ?? $evento->est_eve) == 'cancelado')
        opacity-60 grayscale
    @endif
"
>

    <!-- IMAGE -->
    <div class="relative h-56 overflow-hidden">

        <img
            src="{{ $evento->img_eve
                ? asset('storage/' . $evento->img_eve)
                : 'https://images.unsplash.com/photo-1517849845537-4d257902454a?q=80&w=1400&auto=format&fit=crop'
            }}"
            class="w-full h-full object-cover group-hover:scale-105 transition duration-700"
        >

        <!-- OVERLAY -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

        <!-- DESTACADO -->
        @if($evento->destacado)

            <div class="absolute top-4 right-4">

                <span class="bg-yellow-400 text-black text-xs px-3 py-1 rounded-full font-bold shadow-lg">
                    ⭐ DESTACADO
                </span>

            </div>

        @endif

        <!-- CATEGORY -->
        <div class="absolute top-4 left-4">

            <span
                class="bg-white/90 backdrop-blur-md text-gray-800 text-xs px-3 py-1 rounded-full font-semibold shadow"
            >

                {{ $evento->cat_eve ?? 'General' }}

            </span>

        </div>

        <!-- ESTADO -->
        <div class="absolute top-11 right-4">

            @if(($evento->estado_temp ?? $evento->est_eve) == 'activo')

                <span class="bg-emerald-500/90 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-semibold">
                    ⏰ {{ \Carbon\Carbon::parse($evento->fch_eve)->format('H:i') }}
                </span>

            @elseif(($evento->estado_temp ?? $evento->est_eve) == 'en_curso')

                <span class="bg-cyan-500/90 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-bold animate-pulse">
                    🔥 EN CURSO
                </span>

            @elseif(($evento->estado_temp ?? $evento->est_eve) == 'finalizado')

                <span class="bg-gray-700/90 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-semibold">
                    ✔ FINALIZADO
                </span>

            @elseif(($evento->estado_temp ?? $evento->est_eve) == 'cancelado')

                <span class="bg-red-500/90 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-semibold">
                    ✖ CANCELADO
                </span>

            @endif

        </div>

        <!-- DATE + TITLE -->
        <div class="absolute bottom-4 left-4 text-white">

            <p class="text-sm opacity-80">
                {{ \Carbon\Carbon::parse($evento->fch_eve)->format('d M Y') }}
            </p>

            <h3 class="text-2xl font-black leading-tight mt-1">
                {{ $evento->nom_eve }}
            </h3>

            @if(($evento->estado_temp ?? $evento->est_eve) == 'en_curso')

                <div class="flex items-center gap-2 mt-2 text-cyan-300 text-sm font-bold">

                    <span class="w-2 h-2 bg-cyan-300 rounded-full animate-ping"></span>

                    Evento en vivo

                </div>

            @endif

        </div>

    </div>

    <!-- CONTENT -->
    <div class="p-5">

        <!-- DESCRIPTION -->
        <p class="text-gray-600 text-sm leading-6 line-clamp-2">
            {{ $evento->des_eve }}
        </p>

        <!-- INFO -->
        <div class="mt-5 space-y-3 text-sm">

            <!-- LOCATION -->
            <div class="flex items-center text-gray-500">

                <span class="mr-2">📍</span>

                {{ optional($evento->ubicacion)->nom_ubi ?? 'Sin ubicación' }}

            </div>

            <!-- PARTICIPANTS -->
            <div class="flex items-center text-gray-500">

                <span class="mr-2">👥</span>

                {{ $evento->mascotasParticipantes->count() }}

                {{ $evento->mascotasParticipantes->count() == 1
                    ? 'mascota participando'
                    : 'mascotas participando'
                }}

            </div>

            <!-- CAPACITY -->
            @if($evento->capacidad_eve)

                <div
                    class="flex items-center

                    @if($cuposDisponibles <= 3)
                        text-red-500
                    @else
                        text-gray-500
                    @endif
                "
                >

                    <span class="mr-2">🎟️</span>

                    {{ $cuposDisponibles }} cupos disponibles

                </div>

            @endif

        </div>

        <!-- BUTTONS -->
        <div class="mt-6 flex flex-col gap-3">

            {{-- DUEÑO DEL EVENTO --}}
            @if(auth()->check() && $evento->usuario_id === auth()->id())

                <!-- CANCELAR / REACTIVAR -->
                <form
                    action="{{ ($evento->estado_temp ?? $evento->est_eve) == 'cancelado'
                        ? route('eventos.reactivar', $evento)
                        : route('eventos.destroy', $evento)
                    }}"
                    method="POST"
                    class="w-full"
                >

                    @csrf

                    @if(($evento->estado_temp ?? $evento->est_eve) == 'cancelado')
                        @method('PATCH')
                    @else
                        @method('DELETE')
                    @endif

                    <button
                        class="w-full

                        @if(($evento->estado_temp ?? $evento->est_eve) == 'cancelado')
                            bg-emerald-500 hover:bg-emerald-600
                        @else
                            bg-red-500 hover:bg-red-600
                        @endif

                        text-white py-3 rounded-2xl font-semibold transition"
                    >

                        @if(($evento->estado_temp ?? $evento->est_eve) == 'cancelado')
                            Reactivar Evento
                        @else
                            Cancelar Evento
                        @endif

                    </button>

                </form>

                <!-- FINALIZAR -->
                @if(($evento->estado_temp ?? $evento->est_eve) == 'en_curso')

                    <form
                        action="{{ route('eventos.finalizar', $evento) }}"
                        method="POST"
                        class="w-full"
                    >

                        @csrf
                        @method('PATCH')

                        <button
                            class="w-full bg-gray-900 hover:bg-black text-white py-3 rounded-2xl font-semibold transition"
                        >

                            Finalizar Evento

                        </button>

                    </form>

                @endif

            {{-- USUARIO NO PARTICIPA --}}
            @elseif(

                ($evento->estado_temp ?? $evento->est_eve) != 'cancelado'

                &&

                ($evento->estado_temp ?? $evento->est_eve) != 'finalizado'

                &&

                !$todasParticipando

            )

                @if(auth()->check())

                    <!-- JOIN -->
                    <button
                        onclick="abrirModalMascotas({{ $evento->id }})"
                        class="w-full bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 hover:scale-[1.02] active:scale-[0.99] duration-300 text-white py-3 rounded-2xl font-semibold shadow-xl"
                    >

                        Participar

                    </button>

                    <!-- MODAL -->
                    <div
                        id="modalMascotas-{{ $evento->id }}"
                        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center p-6"
                    >

                        <div class="bg-white w-full max-w-lg rounded-[32px] p-8 relative">

                            <!-- CERRAR -->
                            <button
                                onclick="cerrarModalMascotas({{ $evento->id }})"
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

                @else

                    <a
                        href="{{ route('login') }}"
                        class="w-full bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 text-white py-3 rounded-2xl font-semibold shadow-xl text-center"
                    >

                        Inicia sesión para participar

                    </a>

                @endif

            {{-- YA PARTICIPA --}}
            @elseif($todasParticipando)

                <div class="w-full bg-emerald-100 text-emerald-700 py-3 rounded-2xl text-center font-semibold">

                    ✔ Todas tus mascotas participan

                </div>

            {{-- EVENTO NO DISPONIBLE --}}
            @else

                <div class="w-full bg-gray-100 text-gray-500 py-3 rounded-2xl text-center font-semibold">

                    Evento no disponible

                </div>

            @endif

            <!-- DETAILS -->
            <a
                href="{{ route('eventos.show', $evento) }}"
                class="w-full border border-gray-200 text-gray-700 py-3 rounded-2xl font-medium text-center hover:bg-gray-100 transition"
            >

                Ver detalles

            </a>

        </div>

    </div>

</div>

<script>

function abrirModalMascotas(id)
{
    const modal = document.getElementById(`modalMascotas-${id}`);

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.body.style.overflow = 'hidden';
}

function cerrarModalMascotas(id)
{
    const modal = document.getElementById(`modalMascotas-${id}`);

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    document.body.style.overflow = 'auto';
}

</script>