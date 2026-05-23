@props([
    'title' => 'Evento',
    'date' => 'Próximamente',
    'location' => 'Ubicación',
    'image' => '🐾',
    'status' => 'activo'
])

<div class="relative overflow-hidden bg-gradient-to-br from-orange-50 via-white to-pink-50 rounded-3xl shadow-lg border border-orange-100 p-5

@if($status == 'cancelado')
    opacity-60 grayscale
@endif
">

    <!-- Glow -->
    <div class="absolute -top-10 -right-10 w-32 h-32 bg-orange-300/20 rounded-full blur-3xl"></div>

    <!-- STATUS -->
    <div class="absolute top-4 right-4 z-20">

        @if($status == 'activo')

            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold">
                Próximo
            </span>

        @elseif($status == 'en_curso')

            <span class="bg-cyan-100 text-cyan-700 px-3 py-1 rounded-full text-xs font-bold animate-pulse">
                En curso
            </span>

        @elseif($status == 'finalizado')

            <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-bold">
                Finalizado
            </span>

        @elseif($status == 'cancelado')

            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">
                Cancelado
            </span>

        @endif

    </div>

    <!-- Header -->
    <div class="flex items-center gap-3 relative z-10">

        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-400 to-pink-500 flex items-center justify-center text-2xl shadow-lg">
            {{ $image }}
        </div>

        <div>

            <p class="text-xs uppercase tracking-widest text-orange-500 font-bold">

                @if($status == 'en_curso')

                    Evento en vivo 🔥

                @else

                    Próximo Evento

                @endif

            </p>

            <h3 class="text-lg font-bold text-gray-900 leading-tight">
                {{ $title }}
            </h3>

        </div>

    </div>

    <!-- Info -->
    <div class="mt-5 space-y-3 relative z-10">

        <div class="flex items-center gap-3 text-gray-600">

            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center">
                📅
            </div>

            <span class="text-sm font-medium">
                {{ $date }}
            </span>

        </div>

        <div class="flex items-center gap-3 text-gray-600">

            <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center">
                📍
            </div>

            <span class="text-sm font-medium">
                {{ $location }}
            </span>

        </div>

    </div>

    <!-- Buttons -->
    <div class="mt-6 flex gap-2 relative z-10">

        <a
            href="{{ route('eventos.index') }}"
            class="flex-1 text-center bg-gradient-to-r from-orange-500 to-pink-500 text-white py-3 rounded-2xl font-semibold hover:scale-[1.02] transition shadow-lg"
        >
            Ver eventos
        </a>

        <a
            href="{{ route('eventos.index') }}"
            class="px-4 bg-white border border-orange-200 rounded-2xl hover:bg-orange-50 transition flex items-center justify-center text-lg"
        >
            🎟️
        </a>

    </div>

</div>