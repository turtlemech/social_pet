@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#f4f7fb] px-6 py-12">

    <div class="max-w-7xl mx-auto">

       <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10">

    <div>

        <h1 class="text-5xl font-black text-gray-900 mb-3">
            Mis Eventos 🎉
        </h1>

        <p class="text-gray-500">
            Aquí puedes administrar los eventos que creaste.
        </p>

    </div>

    <a
        href="{{ route('eventos.index') }}"
        class="mt-4 md:mt-0 bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-2xl font-bold shadow transition"
    >
        ⬅️ Volver a Eventos
    </a>

</div>
        @if($eventos->count())

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                @foreach($eventos as $evento)

                    <div>

                        <x-eventos.event-card :evento="$evento" />

                        <a
                            href="{{ route('eventos.edit', $evento) }}"
                            class="inline-block mt-4 bg-yellow-400 hover:bg-yellow-500 text-white px-5 py-3 rounded-2xl font-bold transition"
                        >
                            Editar Evento
                        </a>

                    </div>

                @endforeach

            </div>

        @else

            <div class="bg-white rounded-3xl p-16 text-center shadow-xl">

                <h2 class="text-3xl font-black mb-4">
                    No creaste eventos aún
                </h2>

            </div>

        @endif

    </div>

</div>

@endsection