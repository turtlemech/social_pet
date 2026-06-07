@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto py-8">

    {{-- Portada --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <img
            src="{{ $comunidad->fot_com
                ? asset('storage/'.$comunidad->fot_com)
                : 'https://placehold.co/1200x300' }}"
            class="w-full h-72 object-cover"
        >

        <div class="p-6">

            <h1 class="text-4xl font-extrabold text-gray-800">
                {{ $comunidad->nom_com }}
            </h1>

            <p class="text-gray-600 mt-2">
                {{ $comunidad->des_com }}
            </p>

            <div class="mt-4 text-sm text-gray-500">
                {{ $miembros }} miembros
                @if($esMiembro)

    <span class="inline-block mt-3 bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
        ✓ Eres miembro
    </span>

@endif
            </div>
            @if($esMiembro)

    <form
        action="{{ route('comunidades.salir', $comunidad->cod_com) }}"
        method="POST"
        class="mt-4"
    >
        @csrf

        <button
            class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl font-semibold"
        >
            Salir de la comunidad
        </button>

    </form>

@endif

        </div>
    </div>

    {{-- CREAR PUBLICACIÓN --}}
<div class="bg-white rounded-2xl shadow-sm p-4 mb-4 mt-6">

    <form action="{{ route('comunidades.publicar', $comunidad->cod_com) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <textarea
            name="contenido"
            rows="4"
            placeholder="¿Qué quieres compartir con {{ $comunidad->nom_com }}?"
            class="w-full bg-gray-100 rounded-2xl p-4 focus:outline-none resize-none"></textarea>
            <div class="mt-3 flex gap-6">

    <label class="flex items-center gap-2">
        <input
            type="radio"
            name="anonima"
            value="0"
            checked>
        Pública
    </label>

    <label class="flex items-center gap-2">
        <input
            type="radio"
            name="anonima"
            value="1">
        Anónima
    </label>

</div>
        <div class="mt-4">
            <input
                type="file"
                name="imagen"
                class="w-full border rounded-xl p-3">
        </div>

        <input type="hidden" name="tipo" value="texto">

        <div class="flex justify-end mt-4">
            <button
                type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-xl font-bold">
                Publicar
            </button>
        </div>

    </form>

</div>

{{-- PUBLICACIONES --}}
@forelse($publicaciones as $publicacion)

<div class="bg-white rounded-2xl shadow-sm p-5 mb-4">

    <div class="flex items-center gap-3 mb-4">

        @if($publicacion->anonima)

    <div class="w-10 h-10 bg-gray-500 rounded-full flex items-center justify-center text-white">
        👤
    </div>

@else

    @if($publicacion->ava_us)

        <img
            src="{{ asset('storage/'.$publicacion->ava_us) }}"
            class="w-10 h-10 rounded-full object-cover">

    @else

        <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center text-white">
            🐾
        </div>

    @endif

@endif

<div>

    @if($publicacion->anonima)

        <p class="font-bold text-sm">
            🐾 Usuario Anónimo
        </p>

    @else

        <p class="font-bold text-sm">
            {{ $publicacion->nom_us }}
        </p>

    @endif

    <p class="text-xs text-gray-500">
        {{ \Carbon\Carbon::parse($publicacion->created_at)->diffForHumans() }}
    </p>

</div>

    </div>

    @if($publicacion->contenido)
        <p class="text-gray-700 mb-4">
            {{ $publicacion->contenido }}
        </p>
    @endif

    @if($publicacion->imagen)
        <img
            src="{{ asset('storage/' . $publicacion->imagen) }}"
            class="w-full rounded-2xl mb-4">
    @endif

    <div class="flex justify-between text-sm text-gray-500 border-t pt-3">

        <span>
            👍 {{ $publicacion->likes }}
        </span>

        <span>
            {{ isset($comentarios[$publicacion->id]) ? count($comentarios[$publicacion->id]) : 0 }}
            comentarios
        </span>

    </div>

    <div class="flex justify-around border-t mt-3 pt-3">

        <form action="{{ route('comunidades.like', $publicacion->id) }}" method="POST">
            @csrf

            <button class="font-semibold text-gray-600 hover:text-teal-600">
                👍 Me gusta
            </button>
        </form>

        <button
            onclick="document.getElementById('comentario-{{ $publicacion->id }}').classList.toggle('hidden')"
            class="font-semibold text-gray-600 hover:text-teal-600">
            💬 Comentar
        </button>

    </div>

    <div
        id="comentario-{{ $publicacion->id }}"
        class="hidden mt-4">

        <form
            action="{{ route('comunidades.comentar', $publicacion->id) }}"
            method="POST"
            class="flex gap-2">

            @csrf

            <input
                type="text"
                name="comentario"
                placeholder="Escribe un comentario..."
                class="flex-1 bg-gray-100 rounded-full px-4 py-2">

            <button
                class="bg-teal-600 text-white px-4 py-2 rounded-full">
                Enviar
            </button>

        </form>

    </div>

    @if(isset($comentarios[$publicacion->id]))

        <div class="mt-4 space-y-2">

            @foreach($comentarios[$publicacion->id] as $comentario)

                <div class="bg-gray-100 rounded-2xl px-4 py-2 text-sm">
                    💬 {{ $comentario->comentario }}
                </div>

            @endforeach

        </div>

    @endif

</div>

@empty

<div class="bg-white rounded-2xl shadow p-5 mt-6 text-center">

    <p class="text-gray-500">
        Aún no hay publicaciones en esta comunidad.
    </p>

</div>

@endforelse

</div>

@endsection