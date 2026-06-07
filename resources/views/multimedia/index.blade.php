@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#f0f2f5] py-6">

    <div class="max-w-4xl mx-auto px-4">

        <div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl p-6 mb-6 shadow-lg text-white flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">🎧 Multimedia</h1>
                <p class="text-teal-100 text-sm mt-1">
                    Música y audios compartidos por la comunidad.
                </p>
            </div>

            <a href="{{ route('multimedia.create') }}"
               class="bg-white text-teal-700 px-5 py-2.5 rounded-xl font-bold shadow hover:bg-gray-50 transition text-sm">
                + Publicar
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            @forelse($multimedia as $item)

                <div class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition">

                    <div class="h-44 bg-gradient-to-r from-teal-400 to-teal-600 flex items-center justify-center">
                        <span class="text-6xl opacity-40">🎵</span>
                    </div>

                    <div class="p-5">

                        <div class="mb-3">

                            <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-xs font-bold">

                                @if($item->tipo == 'musica')
    🎵 Música
@else
    🎙️ Audio
@endif

                            </span>

                        </div>

                        <h2 class="text-xl font-bold text-gray-800">
                            {{ $item->titulo }}
                        </h2>

                        <p class="text-gray-500 mt-1">
                            {{ $item->artista }}
                        </p>

                        <div class="mt-3 text-sm text-gray-500">

                            

                        </div>

                        <div class="mt-4">

                            @if(Str::contains($item->archivo, 'youtube'))

                                <a href="{{ $item->archivo }}"
                                   target="_blank"
                                   class="block w-full bg-red-500 hover:bg-red-600 text-white text-center py-3 rounded-xl font-bold">

                                    ▶ Escuchar en YouTube

                                </a>

                            @else

                                <audio controls class="w-full">
                                    <source src="{{ asset('storage/' . $item->archivo) }}">
                                </audio>

                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-span-2 bg-white rounded-2xl shadow-sm p-10 text-center">

                    <div class="text-5xl mb-3">
                        🎵
                    </div>

                    <h2 class="text-xl font-bold">
                        No hay multimedia todavía
                    </h2>

                    <p class="text-gray-500 mt-2">
                        Publica la primera canción o audio.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection