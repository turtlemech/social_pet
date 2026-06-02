@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#f0f2f5] py-6">

    <div class="max-w-4xl mx-auto px-4">

        {{-- Header banner --}}
        <div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl p-6 mb-6 shadow-lg text-white flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Comunidades</h1>
                <p class="text-teal-100 text-sm mt-1">Descubre grupos para compartir fotos, consejos y eventos de mascotas.</p>
            </div>
            <a href="{{ route('comunidades.create') }}"
               class="bg-white text-teal-700 px-5 py-2.5 rounded-xl font-bold shadow hover:bg-gray-50 transition text-sm">
                + Crear comunidad
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-6 flex items-center gap-2">
                <i class="fas fa-check-circle text-green-500"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Tabs --}}
        <div class="flex gap-2 mb-6">
            <button class="px-5 py-2 rounded-full bg-teal-600 text-white font-semibold text-sm">Todas</button>
            <button class="px-5 py-2 rounded-full bg-white text-gray-600 font-semibold text-sm hover:bg-gray-50 transition shadow-sm">Mis comunidades</button>
            <button class="px-5 py-2 rounded-full bg-white text-gray-600 font-semibold text-sm hover:bg-gray-50 transition shadow-sm">Populares</button>
        </div>

        {{-- Grid de comunidades --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            @forelse($comunidades as $comunidad)

                <div class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition group">

                    {{-- Cover con huellas --}}
                    <div class="h-24 relative bg-gradient-to-r from-teal-500 to-teal-600">
                        {{-- Huellas decorativas --}}
                        <div class="absolute top-2 right-4 text-white opacity-20 text-2xl">🐾</div>
                        <div class="absolute top-6 right-12 text-white opacity-15 text-xl">🐾</div>
                        
                        {{-- Badge público/privado --}}
                        <div class="absolute top-3 left-3">
                            <span class="bg-white text-gray-700 text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                                {{ ucfirst($comunidad->pri_com) }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5">

                        {{-- Icono + Info --}}
                        <div class="flex items-start gap-3 mb-3">
                            <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-xl flex-shrink-0">
                                🐕
                            </div>
                            <div class="flex-1 min-w-0">
                                <h2 class="text-lg font-bold text-gray-800 truncate">{{ $comunidad->nom_com }}</h2>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $comunidad->posts_count ?? 0 }} publicaciones · 
                                    {{ $comunidad->fch_cre_com ? \Carbon\Carbon::parse($comunidad->fch_cre_com)->diffForHumans() : 'recientemente' }}
                                </p>
                            </div>
                        </div>

                        <p class="text-gray-500 text-sm line-clamp-2 mb-4">
                            {{ $comunidad->des_com ?? 'Comunidad para compartir experiencias sobre mascotas.' }}
                        </p>

                        {{-- Botones estilo captura --}}
                        <div class="flex gap-3">
                            <a href="{{ route('comunidades.show', $comunidad->cod_com) }}"
                               class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 rounded-xl font-semibold text-center text-sm transition">
                                Ver grupo
                            </a>

                            @if($comunidad->unido ?? false)
                                <form action="{{ route('comunidades.salir', $comunidad->cod_com) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full bg-white border border-gray-300 text-gray-600 py-2.5 rounded-xl font-semibold text-sm hover:bg-gray-50 transition">
                                        Unido
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('comunidades.unirse', $comunidad->cod_com) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full bg-white border border-gray-300 text-gray-600 py-2.5 rounded-xl font-semibold text-sm hover:bg-gray-50 transition">
                                        Unirme
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>

            @empty

                <div class="col-span-2 bg-white rounded-2xl shadow-sm p-12 text-center">
                    <div class="text-5xl mb-4">🐾</div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">No hay comunidades todavía</h2>
                    <p class="text-gray-500 mb-4">Crea la primera comunidad para amantes de mascotas.</p>
                    <a href="{{ route('comunidades.create') }}" class="bg-teal-600 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-teal-700 transition">
                        + Crear comunidad
                    </a>
                </div>

            @endforelse

        </div>

    </div>
</div>

@endsection