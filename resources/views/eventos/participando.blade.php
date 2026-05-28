@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#f4f7fb] px-6 py-12">

    <div class="max-w-7xl mx-auto">

        <h1 class="text-5xl font-black text-gray-900 mb-3">
            Eventos Participando 🐾
        </h1>

        <p class="text-gray-500 mb-10">
            Eventos a los que te uniste.
        </p>

        @if($eventos->count())

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                @foreach($eventos as $evento)

                    <x-eventos.event-card :evento="$evento" />

                @endforeach

            </div>

        @else

            <div class="bg-white rounded-3xl p-16 text-center shadow-xl">

                <h2 class="text-3xl font-black mb-4">
                    Aún no participas en eventos
                </h2>

            </div>

        @endif

    </div>

</div>

@endsection