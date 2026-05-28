@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-10">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-10">

        <div>

            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                🐾 Mis Mascotas
            </h1>

            <p class="text-gray-500 text-lg">
                Gestiona los perfiles sociales de tus mascotas
            </p>

        </div>

        <!-- BOTÓN CREAR -->
        <a
            href="{{ route('pets.create') }}"
            class="mt-5 md:mt-0 inline-flex items-center gap-2 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white px-6 py-3 rounded-2xl font-semibold shadow-lg transition hover:scale-105"
        >

            <span class="text-xl">＋</span>

            Nueva Mascota

        </a>

    </div>
    <div class="flex gap-6 border-b border-gray-200 mb-10 pb-4">

    <button class="font-semibold text-teal-600 border-b-2 border-teal-600 pb-2">
        Mis mascotas
    </button>

    <button class="text-gray-500 hover:text-gray-700 transition">
        Publicaciones
    </button>

    <button class="text-gray-500 hover:text-gray-700 transition">
        Estadísticas
    </button>

</div>

    <!-- GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        @forelse($mascotas as $mascota)

            <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group">
                <!-- FOTO -->
                <div class="relative">

                    @if($mascota->fot_mas)

                        <img
                            src="{{ asset('storage/' . $mascota->fot_mas) }}"
                            class="w-full h-72 object-cover group-hover:scale-105 transition duration-500"
                        >
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/20 transition"></div>

                    @else

                        <div class="w-full h-72 bg-gradient-to-br from-teal-400 to-emerald-500 flex items-center justify-center text-7xl text-white">

                            🐾

                        </div>

                    @endif

                    <!-- STATUS -->
                    <div class="absolute top-4 right-4">

                        <span class="px-3 py-1 rounded-full text-xs font-bold
                            {{ $mascota->est_mas == 'activo'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-red-100 text-red-700'
                            }}"
                        >

                            {{ ucfirst($mascota->est_mas) }}

                        </span>

                    </div>

                </div>

                <!-- INFO -->
                <div class="p-6">

                    <div class="flex items-center justify-between mb-3">

                        <h2 class="text-2xl font-bold text-gray-800">
                            {{ $mascota->nom_mas }}
                        </h2>

                        <span class="text-sm bg-teal-100 text-teal-700 px-3 py-1 rounded-full font-medium">

                            {{ $mascota->especie->nom_esp ?? 'Mascota' }}

                        </span>

                    </div>

                    <!-- SEXO -->
                    <p class="text-sm text-gray-500 mb-3">

                        {{ ucfirst($mascota->sex_mas ?? 'Sin especificar') }}

                    </p>

                    <!-- DESCRIPCIÓN -->
                    <p class="text-gray-600 text-sm leading-6 mb-6 h-16 overflow-hidden">

                        {{ $mascota->des_mas ?? 'Esta mascota todavía no tiene descripción.' }}

                    </p>

    <div class="flex justify-between bg-gray-50 rounded-2xl px-4 py-3 text-sm text-gray-500 mb-6">

    <div class="text-center flex-1">

        <span class="block font-bold text-gray-800 text-lg">
            0
        </span>

        publicaciones

    </div>

    <div class="text-center flex-1">

        <span class="block font-bold text-gray-800 text-lg">
            0
        </span>

        seguidores

    </div>

</div>

                    <!-- BOTONES -->
                   <div class="flex gap-3">

    <!-- VER PERFIL -->
    <a
        href="{{ route('pets.show', $mascota->id) }}"
        class="flex-1 text-center bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white py-3 rounded-2xl font-semibold transition shadow-md hover:shadow-lg"
    >
        Ver Perfil
    </a>

    <!-- EDITAR -->
    <a
        href="{{ route('pets.edit', $mascota->id) }}"
        class="px-5 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium transition shadow-sm hover:shadow-md"
    >
        Editar
    </a>

    <!-- ELIMINAR -->
    <form
        action="{{ route('pets.destroy', $mascota->id) }}"
        method="POST"
        onsubmit="return confirm('¿Eliminar esta mascota?')"
    >
        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="px-5 py-3 rounded-2xl bg-red-100 hover:bg-red-200 text-red-700 font-medium transition shadow-sm hover:shadow-md"
        >
            Eliminar
        </button>

    </form>

</div>

                </div>

            </div>

        @empty

            <!-- EMPTY -->
            <div class="col-span-full">

                <div class="bg-white rounded-3xl shadow-sm p-16 text-center">

                    <div class="text-7xl mb-6">
                        🐶
                    </div>

                    <h2 class="text-3xl font-bold text-gray-800 mb-4">
                        Todavía no tienes mascotas
                    </h2>

                    <p class="text-gray-500 mb-8 text-lg">
                        Crea el primer perfil social de una mascota
                    </p>

                    <a
                        href="{{ route('pets.create') }}"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white px-8 py-4 rounded-2xl font-semibold shadow-lg transition hover:scale-105"
                    >

                        ＋ Crear Mascota

                    </a>

                </div>

            </div>

        @endforelse

    </div>

</div>

@endsection