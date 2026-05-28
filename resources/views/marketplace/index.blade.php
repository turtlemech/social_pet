{{-- ================= MARKETPLACE INDEX ================= --}}
{{-- resources/views/marketplace/index.blade.php --}}

@extends('layouts.app')

@section('content')

<style>
    :root {
        --sp-primary: #0d9488;
        --sp-primary-dark: #0f766e;
        --sp-primary-light: #ccfbf1;
    }

    .header-sp {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 60%, #115e59 100%);
    }

    .card-product {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .card-product:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px -12px rgba(13, 148, 136, 0.25);
        border-color: #0d9488;
    }

    .btn-sp {
        background: #0d9488;
        color: white;
        transition: all 0.2s ease;
    }

    .btn-sp:hover {
        background: #0f766e;
        transform: scale(1.02);
    }

    .badge-cat {
        background: #ccfbf1;
        color: #0d9488;
    }

    .filter-btn.active {
        background: #0d9488;
        color: white;
    }

    .search-box:focus-within {
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.2);
        border-color: #0d9488;
    }
</style>

<div class="min-h-screen bg-[#f3f4f6] py-6 pb-20">

    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        {{-- ================= HEADER ================= --}}
        <div class="header-sp rounded-2xl shadow-lg overflow-hidden mb-6 relative">

            <div class="flex items-center justify-between flex-wrap gap-5 p-6 lg:p-8 relative z-10">

                <div class="flex items-center gap-4">

                    <div class="bg-white/20 backdrop-blur-sm w-16 h-16 rounded-full flex items-center justify-center border border-white/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>

                    <div>
                        <h1 class="text-3xl lg:text-4xl font-bold text-white tracking-tight">
                            Marketplace <span class="text-teal-200 font-normal">SocialPet</span>
                        </h1>
                        <p class="text-teal-100 mt-1 text-sm lg:text-base">
                            Compra y vende productos para mascotas 🐶🐱
                        </p>
                    </div>

                </div>

                <a href="{{ route('marketplace.create') }}" class="bg-white text-[#0d9488] font-bold px-6 py-3 rounded-xl shadow hover:shadow-lg hover:scale-105 transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Publicar Producto
                </a>

            </div>

        </div>

        {{-- ================= BÚSQUEDA Y FILTROS ================= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">

            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">

                {{-- Búsqueda --}}
                <div class="search-box flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 w-full md:w-96 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" placeholder="Buscar productos..." class="bg-transparent outline-none text-gray-700 w-full placeholder-gray-400" id="searchInput" onkeyup="filterProducts()">
                </div>

                {{-- Filtros --}}
                <div class="flex gap-2 flex-wrap">
                    <button onclick="filterByCategory('all')" class="filter-btn active px-4 py-2 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-[#0d9488] hover:text-white transition" data-cat="all">Todos</button>
                    <button onclick="filterByCategory('Comida')" class="filter-btn px-4 py-2 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-[#0d9488] hover:text-white transition" data-cat="Comida">🍖 Comida</button>
                    <button onclick="filterByCategory('Juguetes')" class="filter-btn px-4 py-2 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-[#0d9488] hover:text-white transition" data-cat="Juguetes">🧸 Juguetes</button>
                    <button onclick="filterByCategory('Accesorios')" class="filter-btn px-4 py-2 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-[#0d9488] hover:text-white transition" data-cat="Accesorios">🎀 Accesorios</button>
                    <button onclick="filterByCategory('Salud')" class="filter-btn px-4 py-2 rounded-lg text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-[#0d9488] hover:text-white transition" data-cat="Salud">💊 Salud</button>
                </div>

            </div>

        </div>

        {{-- MENSAJE ÉXITO --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 px-5 py-4 rounded-xl mb-6 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ================= PRODUCTOS ================= --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="productsGrid">

            @forelse($productos as $producto)

                <div class="card-product bg-white rounded-2xl overflow-hidden shadow-sm flex flex-col h-full" data-category="{{ $producto->cat_pro }}" data-name="{{ strtolower($producto->nom_pro) }}">

                    {{-- IMAGEN --}}
                    <div class="relative overflow-hidden group">
                        @if($producto->img_pro)
                            <img src="{{ asset('storage/' . $producto->img_pro) }}" class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-110" alt="{{ $producto->nom_pro }}" loading="lazy">
                        @else
                            <div class="w-full h-56 bg-gradient-to-br from-[#ccfbf1] to-[#99f6e4] flex items-center justify-center">
                                <span class="text-6xl">🐾</span>
                            </div>
                        @endif

                        <span class="absolute top-3 left-3 badge-cat text-xs font-bold px-3 py-1 rounded-full">{{ $producto->cat_pro }}</span>

                        <div class="absolute bottom-3 right-3 bg-white/90 backdrop-blur-sm rounded-lg px-3 py-1.5 shadow">
                            <span class="text-[#0d9488] font-bold text-lg">Bs. {{ number_format($producto->pre_pro, 2) }}</span>
                        </div>
                    </div>

                    {{-- INFO --}}
                    <div class="p-5 flex flex-col flex-grow">

                        <h2 class="text-lg font-bold text-gray-800 mb-2 line-clamp-1" title="{{ $producto->nom_pro }}">{{ $producto->nom_pro }}</h2>

                        <p class="text-gray-500 text-sm mb-4 line-clamp-2 flex-grow">{{ $producto->des_pro ?? 'Sin descripción.' }}</p>

                        <div class="flex items-center gap-2 mb-4 text-xs text-gray-400">
                            <div class="w-6 h-6 rounded-full bg-[#ccfbf1] flex items-center justify-center text-[#0d9488] font-bold">
                                {{ substr($producto->us_ven ?? 'U', 0, 1) }}
                            </div>
                            <span>Vendedor #{{ $producto->us_ven }}</span>
                        </div>

                        {{-- BOTONES --}}
                        <div class="flex gap-2 mt-auto">
                            <button class="btn-sp flex-1 py-3 rounded-xl font-semibold shadow-sm text-sm flex items-center justify-center gap-2" onclick="alert('Función de compra en desarrollo')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Comprar
                            </button>
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-600 p-3 rounded-xl transition" title="Ver detalles">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>

                    </div>

                </div>

            @empty

                <div class="col-span-full bg-white rounded-2xl shadow-sm p-16 text-center">
                    <div class="w-24 h-24 bg-[#ccfbf1] rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-5xl">🐶</span>
                    </div>
                    <h2 class="text-2xl font-bold text-[#0d9488] mb-3">No hay productos todavía</h2>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Sé el primero en publicar un producto en el marketplace de SocialPet.</p>
                    <a href="{{ route('marketplace.create') }}" class="btn-sp inline-flex items-center gap-2 px-8 py-4 rounded-xl font-bold shadow-lg text-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Publicar Producto
                    </a>
                </div>

            @endforelse

        </div>

    </div>

</div>

<script>
    function filterByCategory(category) {
        const products = document.querySelectorAll('[data-category]');
        const buttons = document.querySelectorAll('.filter-btn');

        buttons.forEach(btn => {
            if (btn.dataset.cat === category) {
                btn.classList.add('active', 'bg-[#0d9488]', 'text-white');
                btn.classList.remove('bg-gray-100', 'text-gray-600');
            } else {
                btn.classList.remove('active', 'bg-[#0d9488]', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-600');
            }
        });

        products.forEach(product => {
            if (category === 'all' || product.dataset.category === category) {
                product.style.display = '';
                product.style.animation = 'fadeIn 0.3s ease';
            } else {
                product.style.display = 'none';
            }
        });
    }

    function filterProducts() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const products = document.querySelectorAll('[data-name]');

        products.forEach(product => {
            const name = product.dataset.name;
            if (name.includes(search)) {
                product.style.display = '';
            } else {
                product.style.display = 'none';
            }
        });
    }
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

@endsection