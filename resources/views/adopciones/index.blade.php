@extends('layouts.app')

@section('content')

<style>
    .adoption-header {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 60%, #115e59 100%);
    }
    .adoption-card {
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
    }
    .adoption-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 50px -12px rgba(13, 148, 136, 0.25);
        border-color: #0d9488;
    }
    .adoption-image {
        transition: transform 0.5s ease;
    }
    .adoption-card:hover .adoption-image {
        transform: scale(1.08);
    }
    .btn-sp {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
        transition: all 0.3s ease;
    }
    .btn-sp:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(13, 148, 136, 0.4);
    }
    .status-badge {
        background: #ccfbf1;
        color: #0d9488;
    }
    .filter-btn.active {
        background: #0d9488;
        color: white;
        border-color: #0d9488;
    }
</style>

<div class="min-h-screen bg-[#f3f4f6] py-8 px-4 sm:px-6">

    <div class="max-w-7xl mx-auto">

        {{-- ================= HEADER ================= --}}
        <div class="adoption-header rounded-2xl shadow-lg overflow-hidden mb-8 relative">

            <div class="flex items-center justify-between flex-wrap gap-5 p-6 lg:p-8 relative z-10">

                <div class="flex items-center gap-4">
                    <div class="bg-white/20 backdrop-blur-sm w-16 h-16 rounded-full flex items-center justify-center border border-white/30">
                        <span class="text-3xl">🏠</span>
                    </div>
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-bold text-white tracking-tight">
                            Adopciones <span class="text-teal-200 font-normal">SocialPet</span>
                        </h1>
                        <p class="text-teal-100 mt-1 text-sm lg:text-base">
                            Encuentra una mascota para darle un hogar lleno de amor 💖
                        </p>
                    </div>
                </div>

                <a href="{{ route('adopciones.create') }}" class="bg-white text-[#0d9488] px-6 py-3 rounded-xl font-bold shadow hover:shadow-lg hover:scale-105 transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Publicar
                </a>

            </div>

        </div>

        {{-- ================= MENSAJE ================= --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ================= GRID ================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @forelse($adopciones as $ado)

                @php
                    $nombreDueno = trim(($ado->nom_us ?? 'Usuario') . ' ' . ($ado->app_us ?? '') . ' ' . ($ado->apm_us ?? ''));
                @endphp

                <div class="adoption-card bg-white rounded-2xl overflow-hidden shadow-sm flex flex-col h-full">

                    {{-- IMAGEN --}}
                    <div class="relative h-56 overflow-hidden group">
                        <img
                            src="{{ $ado->fot_mas ? asset('storage/' . $ado->fot_mas) : 'https://ui-avatars.com/api/?name='.urlencode($ado->nom_mas ?? 'Mascota').'&background=0d9488&color=fff&size=400' }}"
                            class="adoption-image w-full h-full object-cover"
                            alt="{{ $ado->nom_mas ?? 'Mascota' }}"
                            loading="lazy"
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($ado->nom_mas ?? 'Mascota') }}&background=0d9488&color=fff&size=400'"
                        >

                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        {{-- Badge estado --}}
                        <div class="absolute top-3 left-3">
                            <span class="status-badge px-3 py-1.5 rounded-full text-xs font-bold shadow-sm">
                                {{ $ado->est_ado == 'activo' ? '🟢 Disponible' : ($ado->est_ado ?? 'En proceso') }}
                            </span>
                        </div>

                        {{-- Dueño info flotante --}}
                        <div class="absolute bottom-3 left-3 right-3 flex items-center gap-2 bg-white/90 backdrop-blur-sm rounded-xl px-3 py-2 shadow-sm opacity-0 group-hover:opacity-100 transition-opacity">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($nombreDueno) }}&background=0d9488&color=fff&size=64" 
                                 class="w-8 h-8 rounded-full object-cover" 
                                 alt="{{ $nombreDueno }}">
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-gray-700 truncate">{{ $nombreDueno }}</p>
                                <p class="text-[10px] text-gray-400">Publicado {{ \Carbon\Carbon::parse($ado->created_at ?? now())->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- INFO --}}
                    <div class="p-5 flex flex-col flex-grow">

                        {{-- Nombre + sexo --}}
                        <div class="flex items-center justify-between mb-1">
                            <h2 class="text-xl font-bold text-gray-800">{{ $ado->nom_mas ?? 'Sin nombre' }}</h2>
                            <span class="text-lg" title="{{ $ado->sex_mas ?? 'No especificado' }}">
                                {{ ($ado->sex_mas ?? '') == 'Macho' ? '♂️' : (($ado->sex_mas ?? '') == 'Hembra' ? '♀️' : '⚪') }}
                            </span>
                        </div>

                        {{-- Especie --}}
                        @if($ado->especie ?? false)
                            <p class="text-sm text-[#0d9488] font-medium mb-2">{{ $ado->especie }}</p>
                        @endif

                        {{-- Descripción --}}
                        <p class="text-sm text-gray-500 line-clamp-3 mb-4 flex-grow">
                            {{ $ado->des_ado ?? 'Sin descripción.' }}
                        </p>

                        {{-- BOTÓN --}}
                        <button onclick="solicitarAdopcion({{ $ado->id }}, '{{ $ado->nom_mas ?? 'esta mascota' }}')" class="btn-sp w-full py-3 rounded-xl text-white font-bold flex items-center justify-center gap-2 shadow-md mt-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            Solicitar adopción
                        </button>

                    </div>

                </div>

            @empty

                {{-- VACÍO --}}
                <div class="col-span-full flex flex-col items-center justify-center py-20">
                    <div class="w-24 h-24 bg-[#ccfbf1] rounded-full flex items-center justify-center mb-6">
                        <span class="text-4xl">🏠</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">No hay adopciones disponibles</h2>
                    <p class="text-gray-500 mb-6 text-center max-w-md">
                        Sé el primero en publicar una mascota que necesite un hogar.
                    </p>
                    <a href="{{ route('adopciones.create') }}" class="btn-sp px-8 py-3 rounded-xl text-white font-bold shadow-lg inline-flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Publicar mascota
                    </a>
                </div>

            @endforelse

        </div>

    </div>

</div>

<script>
    function solicitarAdopcion(id, nombre) {
        alert('🐾 Próximamente: Formulario de solicitud para adoptar a ' + nombre + '\n\nID: ' + id);
    }
</script>

@endsection