@extends('layouts.app')

@section('content')

<style>
    .match-header {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 60%, #115e59 100%);
    }
    .match-card {
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
    }
    .match-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(13, 148, 136, 0.3);
        border-color: #0d9488;
    }
    .match-image {
        transition: transform 0.6s ease;
    }
    .match-card:hover .match-image {
        transform: scale(1.08);
    }
    .match-badge {
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        animation: pulse-badge 2s infinite;
    }
    @keyframes pulse-badge {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    .btn-like {
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        transition: all 0.3s ease;
    }
    .btn-like:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 10px 25px -5px rgba(236, 72, 153, 0.4);
    }
    .btn-pass {
        transition: all 0.3s ease;
    }
    .btn-pass:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #fecaca;
    }
    .filter-btn.active {
        background: #0d9488;
        color: white;
        border-color: #0d9488;
    }
</style>

<div class="min-h-screen bg-[#f3f4f6] py-8 px-4 sm:px-6">

    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm p-4 mb-6">

    <form method="GET" action="{{ route('matches.index') }}">

        <label class="block text-sm font-bold text-gray-700 mb-2">
            Mascota para buscar pareja ❤️
        </label>

        <div class="flex gap-3">

            <select
                name="mascota"
                class="flex-1 border rounded-xl px-4 py-3"
                onchange="this.form.submit()"
            >

                @foreach($misMascotas as $m)

                    <option
                        value="{{ $m->id }}"
                        {{ request('mascota') == $m->id ? 'selected' : '' }}
                    >
                        {{ $m->nom_mas }}
                    </option>

                @endforeach

            </select>

        </div>

    </form>

</div>

        {{-- HEADER --}}
        <div class="match-header rounded-2xl shadow-lg overflow-hidden mb-8 relative">
            <div class="flex items-center justify-between flex-wrap gap-5 p-6 lg:p-8 relative z-10">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 backdrop-blur-sm w-16 h-16 rounded-full flex items-center justify-center border border-white/30">
                        <span class="text-3xl">❤️</span>
                    </div>
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-bold text-white tracking-tight">
                            Matches <span class="text-pink-200 font-normal">SocialPet</span>
                        </h1>
                        <p class="text-teal-100 mt-1 text-sm lg:text-base">
                            Encuentra la pareja perfecta para tu mascota 🐶🐱
                        </p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button onclick="filterMatches('all')" class="filter-btn active px-4 py-2 rounded-xl text-sm font-semibold border transition" data-filter="all">Todos</button>
                    <button onclick="filterMatches('perro')" class="filter-btn px-4 py-2 rounded-xl text-sm font-semibold bg-white/20 text-white border border-white/30 hover:bg-white hover:text-[#0d9488] transition" data-filter="perro">🐕 Perros</button>
                    <button onclick="filterMatches('gato')" class="filter-btn px-4 py-2 rounded-xl text-sm font-semibold bg-white/20 text-white border border-white/30 hover:bg-white hover:text-[#0d9488] transition" data-filter="gato">🐈 Gatos</button>
                </div>
            </div>
        </div>

        {{-- GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="matchesGrid">

            @forelse($mascotas as $pet)

                @php
                    $especie = strtolower($pet->especie ?? 'mascota');
                    $compatibilidad = $pet->compatibilidad;
                    $nombreDueno = trim(($pet->nom_us ?? 'Usuario') . ' ' . ($pet->app_us ?? '') . ' ' . ($pet->apm_us ?? ''));
                    
                    $emojiEspecie = match($especie) {
                        'perro' => '🐕',
                        'gato' => '🐈',
                        'conejo' => '🐰',
                        default => '🐾',
                    };
                @endphp

                <div class="match-card bg-white rounded-2xl overflow-hidden shadow-sm flex flex-col h-full" data-species="{{ $especie }}" id="card-{{ $pet->id }}">

                    {{-- IMAGEN --}}
                    <div class="relative h-72 overflow-hidden group">
                        <img
                            src="{{ $pet->fot_mas ? asset('storage/' . $pet->fot_mas) : 'https://ui-avatars.com/api/?name='.urlencode($pet->nom_mas).'&background=0d9488&color=fff&size=400' }}"
                            class="match-image w-full h-full object-cover"
                            alt="{{ $pet->nom_mas }}"
                            loading="lazy"
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($pet->nom_mas) }}&background=0d9488&color=fff&size=400'"
                        >

                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        {{-- Badge Match --}}
                        <div class="absolute top-3 right-3">
                            <span class="match-badge text-white px-3 py-1.5 rounded-full text-xs font-bold shadow-lg flex items-center gap-1">
                                <span>❤️</span>
                                <span>{{ $compatibilidad }}% Match</span>
                            </span>
                        </div>

                        {{-- Badge especie --}}
                        <div class="absolute top-3 left-3">
                            <span class="bg-white/90 backdrop-blur-sm text-gray-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1">
                                <span>{{ $emojiEspecie }}</span>
                                <span class="uppercase">{{ $pet->especie ?? 'Mascota' }}</span>
                            </span>
                        </div>

                        {{-- Anillo compatibilidad --}}
                        <div class="absolute bottom-3 right-3 w-14 h-14 rounded-full bg-white shadow-lg flex items-center justify-center border-2 border-white">
                            <div class="absolute inset-0 rounded-full" style="background: conic-gradient(from 0deg, #0d9488 {{ $compatibilidad * 3.6 }}deg, #e5e7eb {{ $compatibilidad * 3.6 }}deg)"></div>
                            <div class="absolute inset-1 bg-white rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold text-[#0d9488]">{{ $compatibilidad }}%</span>
                            </div>
                        </div>

                        {{-- Online --}}
                        <div class="absolute bottom-3 left-3 flex items-center gap-1.5 bg-white/90 backdrop-blur-sm rounded-full px-2.5 py-1 shadow-sm">
                            <div class="w-2.5 h-2.5 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-xs font-medium text-gray-600">Activo</span>
                        </div>
                    </div>

                    {{-- INFO --}}
                    <div class="p-5 flex flex-col flex-grow">

                        {{-- Nombre + sexo --}}
                        <div class="flex items-center justify-between mb-1">
                            <h2 class="text-xl font-bold text-gray-800">{{ $pet->nom_mas }}</h2>
                            <span class="text-lg" title="{{ $pet->sex_mas ?? 'No especificado' }}">

    {{ ($pet->sex_mas ?? '') == 'macho' ? '♂️' : (($pet->sex_mas ?? '') == 'hembra' ? '♀️' : '⚪') }}

</span>
                        </div>

                        {{-- Descripción --}}
                        @if($pet->per_mas)

    <div class="mb-3">

        <span class="bg-teal-50 text-teal-700 px-3 py-1 rounded-full text-xs font-semibold">
            🧠 {{ $pet->per_mas }}
        </span>

    </div>

@endif

<p class="text-sm text-gray-500 line-clamp-3 mb-4 flex-grow">
    {{ $pet->des_mas ?? 'Una mascota buscando nuevos amigos.' }}
</p>

                        {{-- Dueño --}}
                        <div class="flex items-center gap-2 mb-4 p-2 bg-gray-50 rounded-lg">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($nombreDueno) }}&background=0d9488&color=fff&size=64" 
                                 class="w-7 h-7 rounded-full object-cover" 
                                 alt="{{ $nombreDueno }}">
                            <p class="text-xs text-gray-600 truncate">{{ $nombreDueno }}</p>
                        </div>

                        {{-- BOTONES --}}
                        <div class="flex gap-3 mt-auto">
                            <button onclick="handleLike({{ $pet->id }}, '{{ $pet->nom_mas }}')" class="btn-like flex-1 py-3 rounded-xl text-white font-bold flex items-center justify-center gap-2 shadow-md">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                Me gusta
                            </button>
                            <button onclick="handlePass({{ $pet->id }})" class="btn-pass flex-1 py-3 rounded-xl font-bold flex items-center justify-center gap-2 border border-gray-200 text-gray-600 bg-white">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                Pasar
                            </button>
                        </div>

                    </div>

                </div>

            @empty

                <div class="col-span-full flex flex-col items-center justify-center py-20">
                    <div class="w-24 h-24 bg-pink-100 rounded-full flex items-center justify-center mb-6">
                        <span class="text-4xl">💔</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">No hay matches disponibles</h2>
                    <p class="text-gray-500 mb-6 text-center max-w-md">Aún no tenemos mascotas compatibles para mostrarte.</p>
                    <a href="{{ route('pets.create') }}" class="btn-like px-8 py-3 rounded-xl text-white font-bold shadow-lg inline-flex items-center gap-2">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                        Agregar mi mascota
                    </a>
                </div>

            @endforelse

        </div>

    </div>

</div>

<script>
    function handleLike(id, nombre) {
        const card = document.getElementById('card-' + id);
        card.style.transform = 'translateX(150px) rotate(15deg)';
        card.style.opacity = '0';
        setTimeout(() => {
            card.style.display = 'none';
            console.log('❤️ Like a ' + nombre);
        }, 400);
    }

    function handlePass(id) {
        const card = document.getElementById('card-' + id);
        card.style.transform = 'translateX(-150px) rotate(-15deg)';
        card.style.opacity = '0';
        setTimeout(() => {
            card.style.display = 'none';
            console.log('❌ Pass');
        }, 400);
    }

    function filterMatches(species) {
        const cards = document.querySelectorAll('.match-card');
        const buttons = document.querySelectorAll('.filter-btn');

        buttons.forEach(btn => {
            if (btn.dataset.filter === species) {
                btn.classList.add('active');
                btn.classList.remove('bg-white/20', 'text-white', 'border-white/30');
            } else {
                btn.classList.remove('active');
                btn.classList.add('bg-white/20', 'text-white', 'border-white/30');
            }
        });

        cards.forEach(card => {
            if (species === 'all' || card.dataset.species === species) {
                card.style.display = '';
                card.style.animation = 'fadeInUp 0.4s ease';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

@endsection