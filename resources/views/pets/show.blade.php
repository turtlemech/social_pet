@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-4 py-10">

    <!-- CARD PRINCIPAL -->
<div class="bg-white/80 backdrop-blur-xl rounded-[36px] shadow-2xl overflow-hidden border border-white/40">
        <!-- PORTADA -->
        <div class="relative">

            @if($mascota->fot_mas)

                <img
                    src="{{ asset('storage/' . $mascota->fot_mas) }}"
class="w-full h-[500px] object-cover"                >

                <div class="absolute inset-0 bg-black/20"></div>

            @else

                <div class="w-full h-[420px] bg-gradient-to-r from-teal-500 to-emerald-500 flex items-center justify-center text-white text-9xl">

                    🐾

                </div>

            @endif

        </div>

        <!-- INFO -->
        <div class="p-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                <div>

                    <div class="flex items-center gap-3 mb-3">

                        <h1 class="text-5xl font-bold text-gray-800">
                            {{ $mascota->nom_mas }}
                        </h1>

                        <span class="bg-teal-100 text-teal-700 px-4 py-1 rounded-full text-sm font-semibold">

                            {{ $mascota->especie->nom_esp ?? 'Mascota' }}

                        </span>

                    </div>

                    <p class="text-gray-500 text-lg">

                        {{ ucfirst($mascota->sex_mas ?? 'Sin especificar') }}

                    </p>

                </div>

                <!-- BOTONES -->
                
@if($mascota->usuario_id == auth()->id())

<div class="flex gap-3">

    <a
        href="{{ route('pets.edit', $mascota->id) }}"
        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-2xl font-semibold transition"
    >
        ✏️ Editar
    </a>

</div>

@else

@php

    $siguiendo = auth()->user()
        ->mascotasSeguidas()
        ->where('mas_seg', $mascota->id)
        ->exists();

@endphp

<form
    action="{{ route('mascotas.seguir', $mascota->id) }}"
    method="POST"
>

    @csrf

    <button
        type="submit"
        class="{{ $siguiendo
            ? 'bg-gray-200 text-gray-800'
            : 'bg-teal-500 text-white'
        }} px-6 py-3 rounded-2xl font-semibold transition hover:scale-105"
    >

        {{ $siguiendo ? 'Siguiendo' : 'Seguir' }}

    </button>

</form>

@endif

            </div>

            <!-- STATS -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-10">

                <div class="bg-gradient-to-br from-gray-50 to-white rounded-3xl p-6 text-center border border-gray-100 shadow-sm hover:shadow-md transition">

                    <div class="text-3xl font-bold text-gray-800">
                        {{ $mascota->publicaciones->count() ?? 0 }}
                    </div>

                    <div class="text-sm text-gray-500 mt-1">
                        publicaciones
                    </div>

                </div>

                <div class="bg-gradient-to-br from-gray-50 to-white rounded-3xl p-6 text-center border border-gray-100 shadow-sm hover:shadow-md transition">

                    <div class="text-3xl font-bold text-gray-800">

    <button

    onclick="openFollowersModal()"

    class="hover:text-teal-500 transition"

>

    {{ $mascota->seguidores()->count() }}

</button>

</div>

                    <div class="text-sm text-gray-500 mt-1">
                        seguidores
                    </div>

                </div>


                <div class="bg-gray-50 rounded-2xl p-5 text-center">

                    <div class="text-3xl font-bold text-gray-800">

    {{ $posts->sum('likes_count') }}

</div>

<div class="text-sm text-gray-500 mt-1">

    likes

</div>

                </div>

            </div>

            <!-- DESCRIPCIÓN -->
            <div class="mt-10">

                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    Sobre mí
                </h2>

                <div class="bg-gradient-to-br from-gray-50 to-white rounded-3xl p-7 text-gray-700 leading-8 border border-gray-100">
                    {{ $mascota->des_mas ?? 'Esta mascota todavía no tiene descripción.' }}

                </div>

            </div>
            @if($mascota->usuario_id == auth()->id())
            <!-- PUBLICAR -->
            <div class="mt-10">

                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    Nueva publicación
                </h2>

                <div class="bg-gradient-to-br from-gray-50 to-white rounded-[28px] p-6 border border-gray-100 shadow-sm">

                    <form
                        action="{{ route('posts.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        @csrf

                        <input
                            type="hidden"
                            name="mascota_id"
                            value="{{ $mascota->id }}"
                        >

                        <textarea
                            name="content"
                            rows="4"
                            placeholder="¿Qué está pensando {{ $mascota->nom_mas }}?"
                            class="w-full border border-gray-200 rounded-2xl p-4 resize-none focus:outline-none focus:ring-2 focus:ring-teal-500"
                        ></textarea>

                        <div class="mt-4">

                            <input
                                type="file"
                                name="image"
                                class="block w-full text-sm text-gray-500"
                            >

                        </div>

                        <div class="mt-5 flex justify-end">

                            <button
                                type="submit"
                                class="bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white px-6 py-3 rounded-2xl font-semibold transition shadow-md hover:shadow-lg"
                            >

                                Publicar

                            </button>

                        </div>

                    </form>

                </div>

            </div>
            @endif

            <!-- PUBLICACIONES -->
            <div class="mt-12">

                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    Publicaciones
                </h2>

                <div class="space-y-6">

                    @forelse($posts as $post)

                        <div class="hover:scale-[1.01] transition duration-300">

    <x-posts.post-card :post="$post" />

</div>

                    @empty

                        <div class="bg-gray-50 rounded-3xl p-10 text-center text-gray-500">

                            Esta mascota todavía no tiene publicaciones.

                        </div>

                    @endforelse

                </div>

            </div>

            <!-- DUEÑO -->
            <div class="mt-10">

                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    Humano responsable
                </h2>

                <div class="bg-white border border-gray-100 rounded-2xl p-5 flex items-center justify-between gap-4 shadow-sm">

                    <div class="flex items-center gap-4">

    <div class="w-14 h-14 rounded-full bg-teal-500 flex items-center justify-center text-white text-xl font-bold">

        {{ strtoupper(substr($mascota->usuario->nom_us ?? 'U', 0, 1)) }}

    </div>

    <div>

        <div class="font-bold text-gray-800">

            {{ $mascota->usuario->nom_us ?? 'Usuario' }}

        </div>

        <div class="text-sm text-gray-500">

            Dueño del perfil

        </div>

    </div>

</div>

@if($mascota->usuario_id != auth()->id())

<form

    action="{{ route('messages.start', $mascota->usuario->id) }}"

    method="POST"

>

    @csrf

    <button

        type="submit"

        class="bg-gradient-to-r from-teal-500 to-emerald-500 text-white px-5 py-2.5 rounded-2xl font-semibold hover:scale-105 transition"

    >

        Mensaje

    </button>

</form>

@endif

                </div>

            </div>

        </div>

    </div>

</div>
<!-- MODAL SEGUIDORES -->

<div
    id="followers-modal"
    class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
>

    <div class="bg-white/90 backdrop-blur-xl w-full max-w-md rounded-[32px] overflow-hidden shadow-2xl border border-white/30">

        <!-- HEADER -->
        <div class="flex items-center justify-between p-5 border-b">

            <h2 class="text-2xl font-bold text-gray-800">

                Seguidores

            </h2>

            <button
                onclick="closeFollowersModal()"
                class="text-gray-500 hover:text-black text-xl"
            >
                ✕
            </button>

        </div>

        <!-- LISTA -->
        <div class="max-h-[500px] overflow-y-auto p-4 space-y-3">

            @forelse($mascota->seguidores as $seguidor)

                <a
                    href="{{ route('usuario.profile', $seguidor->id) }}"
                    class="flex items-center gap-3 p-3 rounded-2xl hover:bg-gray-50 transition"
                >

                    <img
                        src="{{ $seguidor->ava_us
                            ? asset('storage/' . $seguidor->ava_us)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($seguidor->nom_us)
                        }}"
                        class="w-14 h-14 rounded-full object-cover"
                    >

                    <div>

                        <div class="font-semibold text-gray-800">

                            {{ $seguidor->nom_us }}

                        </div>

                        <div class="text-sm text-gray-500">

                            Ver perfil

                        </div>

                    </div>

                </a>

            @empty

                <div class="text-center text-gray-500 py-10">

                    Esta mascota todavía no tiene seguidores.

                </div>

            @endforelse

        </div>

    </div>

</div>

<script>

function openFollowersModal() {

    document
        .getElementById('followers-modal')
        .classList.remove('hidden');

}

function closeFollowersModal() {

    document
        .getElementById('followers-modal')
        .classList.add('hidden');

}

</script>

@endsection