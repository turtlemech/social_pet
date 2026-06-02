@extends('layouts.app')

@section('content')

<style>
    .tab-active {
        color: #0d9488;
        border-bottom: 3px solid #0d9488;
    }
    .tab-inactive {
        color: #65676b;
    }
    .tab-inactive:hover {
        background: #f0f2f5;
    }
</style>

<div class="min-h-screen bg-[#f0f2f5] py-6">

    <div class="max-w-4xl mx-auto px-4">

        {{-- Card principal con cover --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-4">

            {{-- Cover image --}}
            <div class="h-64 relative">
                @if($comunidad->fot_com)
                    <img src="{{ asset('storage/' . $comunidad->fot_com) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-r from-teal-500 to-teal-700 flex items-center justify-center">
                        <span class="text-8xl opacity-20">🐾</span>
                    </div>
                @endif
            </div>

            {{-- Info debajo del cover --}}
            <div class="px-6 pb-4">
                <div class="flex items-end gap-4 -mt-12 relative z-10">
                    <div class="w-24 h-24 bg-white rounded-2xl p-1 shadow-lg">
                        <div class="w-full h-full bg-gradient-to-br from-teal-400 to-teal-600 rounded-xl flex items-center justify-center text-4xl">
                            🐶
                        </div>
                    </div>
                    <div class="pb-2 flex-1">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $comunidad->nom_com }}</h1>
                        <p class="text-sm text-gray-500 mt-0.5">
                            <span class="bg-gray-100 px-2 py-0.5 rounded-md text-xs font-medium">{{ ucfirst($comunidad->pri_com) }}</span>
                            <span class="mx-1">·</span>
                            <span>{{ $comunidad->total_miembros ?? 0 }} miembros</span>
                        </p>
                    </div>
                </div>

                <p class="text-gray-600 mt-4 text-sm leading-relaxed">
                    {{ $comunidad->des_com ?? 'Comunidad para compartir experiencias sobre mascotas.' }}
                </p>

                {{-- Tabs --}}
                <div class="flex mt-6 border-b">
                    <button class="tab-active px-6 py-3 font-semibold text-sm">Publicaciones</button>
                    <button class="tab-inactive px-6 py-3 font-semibold text-sm rounded-t-lg transition">Miembros</button>
                    <button class="tab-inactive px-6 py-3 font-semibold text-sm rounded-t-lg transition">Eventos</button>
                    <button class="tab-inactive px-6 py-3 font-semibold text-sm rounded-t-lg transition">Fotos</button>
                </div>

                {{-- Botones de acción --}}
                <div class="flex gap-3 mt-4">
                    @if($comunidad->unido ?? false)
                        <form action="{{ route('comunidades.salir', $comunidad->cod_com) }}" method="POST" class="flex-1">
                         @csrf
                            <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 rounded-xl font-semibold transition text-sm">
                                <i class="fas fa-check mr-1"></i> Unido
                            </button>
                        </form>
                    @else
                        <form action="{{ route('comunidades.unirse', $comunidad->cod_com) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white py-2.5 rounded-xl font-semibold transition text-sm">
                                Unirme al grupo
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('comunidades.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 rounded-xl text-gray-600 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- CREAR PUBLICACIÓN --}}
<div class="bg-white rounded-2xl shadow-sm p-4 mb-4">

    <form action="{{ route('comunidades.publicar', $comunidad->cod_com) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <textarea
            name="contenido"
            rows="4"
            placeholder="¿Qué quieres compartir con {{ $comunidad->nom_com }}?"
            class="w-full bg-gray-100 rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-teal-500 resize-none"></textarea>

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

        <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold">
            🐾
        </div>

        <div>
            <p class="font-bold text-sm">
                Comunidad {{ $comunidad->nom_com }}
            </p>

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

        <form
            action="{{ route('comunidades.like', $publicacion->id) }}"
            method="POST">
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

        <button
            onclick="navigator.clipboard.writeText(window.location.href); alert('Enlace copiado')"
            class="font-semibold text-gray-600 hover:text-teal-600">
            ↗ Compartir
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
                class="flex-1 bg-gray-100 rounded-full px-4 py-2 focus:outline-none">

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

<div class="bg-white rounded-2xl shadow-sm p-12 text-center">

    <div class="w-16 h-16 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-4">
        🐾
    </div>

    <h3 class="text-lg font-bold text-gray-700 mb-2">
        Aún no hay publicaciones
    </h3>

    <p class="text-gray-500 text-sm">
        Sé el primero en compartir algo en esta comunidad
    </p>

</div>

@endforelse

        {{-- Crear publicación --}}
        <div class="bg-white rounded-2xl shadow-sm p-4 mb-4">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                    {{ substr(auth()->user()->name ?? 'GL', 0, 2) }}
                </div>
                <input type="text"
                       placeholder="¿Qué quieres compartir con {{ $comunidad->nom_com }}?"
                       class="flex-1 bg-gray-100 rounded-full px-5 py-2.5 focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm">
            </div>
            <div class="flex justify-around pt-3 border-t text-gray-500 text-sm font-medium">
                <button class="hover:bg-gray-100 px-4 py-2 rounded-lg transition"><i class="fas fa-image text-green-500 mr-1"></i> Foto</button>
                <button class="hover:bg-gray-100 px-4 py-2 rounded-lg transition"><i class="fas fa-video text-red-500 mr-1"></i> Video</button>
                <button class="hover:bg-gray-100 px-4 py-2 rounded-lg transition"><i class="fas fa-smile text-yellow-500 mr-1"></i> Sentimiento</button>
            </div>
        </div>

        {{-- Publicaciones vacías --}}
        <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
            <div class="w-16 h-16 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-paw text-teal-300 text-2xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-700 mb-2">Aún no hay publicaciones</h3>
            <p class="text-gray-500 text-sm">Sé el primero en compartir algo en esta comunidad</p>
        </div>

    </div>
</div>

@endsection