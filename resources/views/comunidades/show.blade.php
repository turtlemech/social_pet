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

    {{-- Publicar --}}
    <div class="bg-white rounded-2xl shadow p-5 mt-6">

        <textarea
            class="w-full border rounded-xl p-3"
            rows="3"
            placeholder="¿Qué quieres compartir con la comunidad?"
        ></textarea>

        <button
            class="mt-3 bg-blue-600 text-white px-5 py-2 rounded-xl">
            Publicar
        </button>

    </div>

    {{-- Posts --}}
    <div class="bg-white rounded-2xl shadow p-5 mt-6">

        <h2 class="font-bold text-lg">
            Publicaciones
        </h2>

        <p class="text-gray-500 mt-3">
            Aquí aparecerán las publicaciones de la comunidad.
        </p>

    </div>

</div>

@endsection