@props(['evento'])

<div
    class="group bg-white rounded-[28px] overflow-hidden border border-gray-100 shadow-sm hover:shadow-[0_25px_80px_rgba(0,0,0,0.18)] transition duration-500

    @if($evento->est_eve == 'cancelado')
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

            @if($evento->est_eve == 'activo')

                <span class="bg-emerald-500/90 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-semibold">

                    ⏰ {{ \Carbon\Carbon::parse($evento->fch_eve)->format('H:i') }}

                </span>

            @elseif($evento->est_eve == 'en_curso')

                <span class="bg-cyan-500/90 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-bold animate-pulse">

                    🔥 EN CURSO

                </span>

            @elseif($evento->est_eve == 'finalizado')

                <span class="bg-gray-700/90 backdrop-blur-md text-white text-xs px-3 py-1 rounded-full font-semibold">

                    ✔ FINALIZADO

                </span>

            @elseif($evento->est_eve == 'cancelado')

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

            @if($evento->est_eve == 'en_curso')

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

                {{ $evento->participantes->count() }} participantes

            </div>

            <!-- CAPACITY -->
            @if($evento->capacidad_eve)

                <div class="flex items-center text-gray-500">

                    <span class="mr-2">🎟️</span>

                    {{ $evento->capacidad_eve }} cupos

                </div>

            @endif

        </div>

        <!-- BUTTONS -->
        <div class="mt-6 flex flex-col gap-3">

          @if(auth()->check() && $evento->usuario_id === auth()->id())

    <!-- CANCELAR / REACTIVAR -->

    <form

        action="{{ route('eventos.destroy', $evento) }}"

        method="POST"

        class="w-full"

    >

        @csrf

        @method('DELETE')

        <button

            class="w-full

@if($evento->est_eve == 'cancelado')

    bg-emerald-500 hover:bg-emerald-600

@else

    bg-red-500 hover:bg-red-600

@endif

text-white py-3 rounded-2xl font-semibold transition"

        >

            @if($evento->est_eve == 'cancelado')

                Reactivar Evento

            @else

                Cancelar Evento

            @endif

        </button>

    </form>

@elseif(

    $evento->est_eve != 'cancelado'

    &&

    $evento->est_eve != 'finalizado'

    &&

    !$evento->participantes->contains(auth()->id())

)

    <!-- JOIN -->

    <form

        action="{{ route('eventos.join', $evento) }}"

        method="POST"

        class="w-full"

    >

        @csrf

        <button

            class="w-full bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 hover:scale-[1.02] active:scale-[0.99] duration-300 text-white py-3 rounded-2xl font-semibold shadow-xl"

        >

            Participar

        </button>

    </form>

@elseif($evento->participantes->contains(auth()->id()))

    <div class="w-full bg-emerald-100 text-emerald-700 py-3 rounded-2xl text-center font-semibold">

        ✔ Ya participas en este evento

    </div>

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