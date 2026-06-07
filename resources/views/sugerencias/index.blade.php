@extends('layouts.app')

@section('content')

<style>
    .pet-card {
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
    }
    .pet-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(13, 148, 136, 0.25);
        border-color: #0d9488;
    }
    .pet-image {
        transition: transform 0.5s ease;
    }
    .pet-card:hover .pet-image {
        transform: scale(1.1);
    }
    .btn-ver-perfil {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
        transition: all 0.3s ease;
    }
    .btn-ver-perfil:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(13, 148, 136, 0.4);
    }
    .follow-pet-btn {
    transition: all 0.2s ease;
}

.follow-pet-btn:hover {
    transform: scale(1.15);
}

.follow-pet-btn.liked {
    background: #fecaca !important;
    color: #dc2626 !important;
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
        <div class="mb-8 flex items-center justify-between flex-wrap gap-4">

            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[#0d9488] to-[#0f766e] flex items-center justify-center shadow-lg">
                        <span class="text-2xl">🐾</span>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 tracking-tight">
                        Mascotas <span class="text-[#0d9488]">Sugeridas</span>
                    </h1>
                </div>
                <p class="text-gray-500 text-lg ml-1">
                    Encuentra nuevas mascotas compatibles para tu peludito 💖
                </p>
            </div>

            {{-- Filtros --}}
            <div class="flex gap-2 flex-wrap">
                <button onclick="filterPets('all')" class="filter-btn active px-4 py-2 rounded-xl text-sm font-semibold border transition" data-filter="all">
                    Todas
                </button>
                <button onclick="filterPets('perro')" class="filter-btn px-4 py-2 rounded-xl text-sm font-semibold bg-white text-gray-600 border border-gray-200 hover:bg-[#0d9488] hover:text-white hover:border-[#0d9488] transition" data-filter="perro">
                    🐕 Perros
                </button>
                <button onclick="filterPets('gato')" class="filter-btn px-4 py-2 rounded-xl text-sm font-semibold bg-white text-gray-600 border border-gray-200 hover:bg-[#0d9488] hover:text-white hover:border-[#0d9488] transition" data-filter="gato">
                    🐈 Gatos
                </button>
                <button onclick="filterPets('otro')" class="filter-btn px-4 py-2 rounded-xl text-sm font-semibold bg-white text-gray-600 border border-gray-200 hover:bg-[#0d9488] hover:text-white hover:border-[#0d9488] transition" data-filter="otro">
                    🐰 Otros
                </button>
            </div>

        </div>

        {{-- ================= GRID ================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="petsGrid">

            @forelse($mascotas as $pet)

                @php
    $especie = strtolower($pet->especie->nom_esp ?? 'mascota');

    $yaLaSigo = $pet->seguidores

    ->contains('id', auth()->id());

    // Nombre completo del dueño
    $nombreDueno = trim(
        ($pet->usuario->nom_us ?? 'Usuario') . ' ' .
        ($pet->usuario->app_us ?? '') . ' ' .
        ($pet->usuario->apm_us ?? '')
    );

    $emojiEspecie = match($especie) {
                        'perro' => '🐕',
                        'gato' => '🐈',
                        'conejo' => '🐰',
                        'hamster' => '🐹',
                        'pajaro' => '🐦',
                        'pez' => '🐠',
                        default => '🐾',
                    };
                @endphp

                <div class="pet-card bg-white rounded-2xl overflow-hidden shadow-sm flex flex-col h-full" data-species="{{ $especie }}">

                    {{-- IMAGEN --}}
                    <div class="relative h-64 overflow-hidden group">
                        <img
                            src="{{ $pet->fot_mas ? asset('storage/' . $pet->fot_mas) : 'https://ui-avatars.com/api/?name='.urlencode($pet->nom_mas).'&background=0d9488&color=fff&size=400' }}"
                            class="pet-image w-full h-full object-cover"
                            alt="{{ $pet->nom_mas }}"
                            loading="lazy"
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($pet->nom_mas) }}&background=0d9488&color=fff&size=400'"
                        >

                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        {{-- Badge especie --}}
                        <div class="absolute top-3 left-3">
                            <span class="bg-white/90 backdrop-blur-sm text-gray-700 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm uppercase flex items-center gap-1">
                                <span>{{ $emojiEspecie }}</span>
                                <span>{{ $pet->especie->nom_esp ?? 'Mascota' }}</span>
                            </span>
                        </div>

                        {{-- Like --}}
                        <form
    action="{{ route('mascotas.seguir', $pet->id) }}"
    method="POST"
    class="absolute top-3 right-3"
>
    @csrf

    <button

    type="submit"

    onclick="animarCorazon(this);"

    class="follow-pet-btn w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center shadow-sm hover:scale-110

    {{ $yaLaSigo ? 'text-red-500' : 'text-gray-400' }}"

>
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
    </button>

</form>

                        {{-- Online --}}
                        <div class="absolute bottom-3 right-3 flex items-center gap-1.5 bg-white/90 backdrop-blur-sm rounded-full px-2.5 py-1 shadow-sm">
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
                                {{ ($pet->sex_mas ?? '') == 'Macho' ? '♂️' : (($pet->sex_mas ?? '') == 'Hembra' ? '♀️' : '⚪') }}
                            </span>
                        </div>

                        {{-- Descripción --}}
                        <p class="text-sm text-gray-500 line-clamp-3 mb-4 flex-grow">
                            {{ $pet->des_mas ?? 'Una mascota adorable buscando nuevos amigos.' }}
                        </p>

                        {{-- Dueño --}}
                        <div class="flex items-center gap-2 mb-4 p-2.5 bg-gray-50 rounded-xl">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($nombreDueno) }}&background=0d9488&color=fff&size=64" 
                                 class="w-8 h-8 rounded-full object-cover" 
                                 alt="{{ $nombreDueno }}">
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-gray-700 truncate">{{ $nombreDueno }}</p>
                                <p class="text-[10px] text-gray-400">Dueño</p>
                            </div>
                        </div>

                        {{-- BOTÓN --}}
                        <a href="{{ route('pets.show', $pet->id) }}" class="btn-ver-perfil w-full py-3 rounded-xl text-white font-bold text-center flex items-center justify-center gap-2 shadow-md mt-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Ver Perfil
                        </a>

                    </div>

                </div>

            @empty

                {{-- VACÍO --}}
                <div class="col-span-full flex flex-col items-center justify-center py-20">
                    <div class="w-24 h-24 bg-[#ccfbf1] rounded-full flex items-center justify-center mb-6">
                        <span class="text-4xl">🐕</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">No hay mascotas sugeridas</h2>
                    <p class="text-gray-500 mb-6 text-center max-w-md">
                        Aún no tenemos mascotas para mostrarte. ¡Sé el primero en registrar la tuya!
                    </p>
                    <a href="{{ route('mascotas.create') }}" class="btn-ver-perfil px-8 py-3 rounded-xl text-white font-bold shadow-lg inline-flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Agregar mi mascota
                    </a>
                </div>

            @endforelse

        </div>

    </div>

</div>

<script>
    function animarCorazon(btn) {

    btn.animate(
        [
            { transform: 'scale(1)' },
            { transform: 'scale(1.3)' },
            { transform: 'scale(1)' }
        ],
        {
            duration: 300
        }
    );

}

    function filterPets(species) {
        const cards = document.querySelectorAll('.pet-card');
        const buttons = document.querySelectorAll('.filter-btn');

        buttons.forEach(btn => {
            if (btn.dataset.filter === species) {
                btn.classList.add('active');
                btn.classList.remove('bg-white', 'text-gray-600', 'border-gray-200');
            } else {
                btn.classList.remove('active');
                btn.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
            }
        });

        cards.forEach(card => {

    if (
        species === 'all' ||
        card.dataset.species === species ||
        (
            species === 'otro' &&
            !['perro', 'gato'].includes(card.dataset.species)
        )
    ) {

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