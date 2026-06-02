{{-- ================= MARKETPLACE CREATE ================= --}}
{{-- resources/views/marketplace/create.blade.php --}}

@extends('layouts.app')

@section('content')

<style>
    :root {
        --sp-primary: #0d9488;
        --sp-primary-dark: #0f766e;
        --sp-primary-light: #ccfbf1;
    }

    .bg-sp { background-color: var(--sp-primary); }
    .bg-sp-dark { background-color: var(--sp-primary-dark); }
    .bg-sp-light { background-color: var(--sp-primary-light); }
    .text-sp { color: var(--sp-primary); }

    .icon-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .header-sp {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 60%, #115e59 100%);
    }

    .drop-zone {
        border: 2px dashed #0d9488;
        background: #ccfbf1;
        border-radius: 16px;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .drop-zone:hover {
        background: #99f6e4;
        border-color: #0f766e;
    }
    .drop-zone.drag-active {
        background: #99f6e4;
        border-style: solid;
    }

    .btn-sp {
        background-color: #0d9488;
        color: white;
        transition: all 0.2s ease;
    }
    .btn-sp:hover {
        background-color: #0f766e;
        transform: translateY(-1px);
        box-shadow: 0 10px 20px -5px rgba(13, 148, 136, 0.3);
    }

    .paw-print {
        position: absolute;
        opacity: 0.06;
        font-size: 80px;
        color: var(--sp-primary);
        pointer-events: none;
        z-index: 0;
    }
</style>

<div class="min-h-screen bg-[#f3f4f6] py-6 pb-20">

    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        {{-- ================= HEADER ================= --}}
        <div class="header-sp rounded-2xl shadow-lg overflow-hidden mb-6">

            <div class="grid lg:grid-cols-2 items-center">

                <div class="p-6 lg:p-8 flex items-center gap-4">

                    <div class="bg-white/20 backdrop-blur-sm w-16 h-16 lg:w-20 lg:h-20 rounded-full flex items-center justify-center shadow-lg flex-shrink-0 border border-white/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 lg:h-10 lg:w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            <circle cx="9" cy="20" r="1" fill="currentColor" stroke="none"/>
                            <circle cx="17" cy="20" r="1" fill="currentColor" stroke="none"/>
                        </svg>
                    </div>

                    <div>
                        <h1 class="text-2xl lg:text-4xl font-bold text-white tracking-tight">
                            Marketplace <span class="text-teal-200 font-normal">SocialPet</span>
                        </h1>
                        <p class="text-teal-100 text-sm lg:text-lg mt-1">
                            Publica productos increíbles para mascotas 🐶🐱
                        </p>
                    </div>

                </div>

                <div class="hidden lg:flex justify-end items-end pr-8 pb-2">
                    <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=400&h=220&fit=crop" class="h-[180px] object-cover rounded-xl shadow-2xl opacity-90" alt="Mascotas">
                </div>

            </div>

        </div>

        {{-- ================= CONTENIDO ================= --}}
        <div class="grid lg:grid-cols-3 gap-5">

            {{-- ================= FORMULARIO ================= --}}
            <div class="lg:col-span-2">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">

                    <form action="{{ route('marketplace.store') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        {{-- NOMBRE --}}
                        <div class="mb-5">
                            <label class="flex items-center gap-2.5 text-lg font-bold text-gray-800 mb-2.5">
                                <span class="icon-circle bg-[#ccfbf1] text-[#0d9488]">🎁</span>
                                Nombre del producto
                            </label>
                            <input type="text" name="nom_pro" placeholder="Ejemplo: Collar premium para perro" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-base text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#0d9488] focus:border-[#0d9488] outline-none transition bg-gray-50/50" required>
                        </div>

                        {{-- DESCRIPCION --}}
                        <div class="mb-5">
                            <label class="flex items-center gap-2.5 text-lg font-bold text-gray-800 mb-2.5">
                                <span class="icon-circle bg-[#ccfbf1] text-[#0d9488]">📋</span>
                                Descripción
                            </label>
                            <textarea name="des_pro" rows="4" placeholder="Describe tu producto..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-base text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#0d9488] focus:border-[#0d9488] outline-none transition resize-none bg-gray-50/50"></textarea>
                        </div>

                        {{-- FILA: PRECIO + CATEGORIA --}}
                        <div class="grid sm:grid-cols-2 gap-5 mb-5">

                            {{-- PRECIO --}}
                            <div>
                                <label class="flex items-center gap-2.5 text-base font-bold text-gray-800 mb-2.5">
                                    <span class="icon-circle bg-[#ccfbf1] text-[#0d9488]">💲</span>
                                    Precio (Bs.)
                                </label>
                                <input type="number" step="0.01" name="pre_pro" placeholder="Ejemplo: 50" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-base text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#0d9488] focus:border-[#0d9488] outline-none transition bg-gray-50/50" required>
                            </div>

                            {{-- CATEGORIA --}}
                            <div>
                                <label class="flex items-center gap-2.5 text-base font-bold text-gray-800 mb-2.5">
                                    <span class="icon-circle bg-[#ccfbf1] text-[#0d9488]">🏷️</span>
                                    Categoría
                                </label>
                                <div class="relative">
                                    <select name="cat_pro" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-base text-gray-700 focus:ring-2 focus:ring-[#0d9488] focus:border-[#0d9488] outline-none transition appearance-none bg-white cursor-pointer pr-10" required>

    <option value="alimento">
        🍖 Alimento
    </option>

    <option value="juguete">
        🧸 Juguete
    </option>

    <option value="accesorio">
        🎀 Accesorio
    </option>

    <option value="ropa">
        👕 Ropa
    </option>

    <option value="salud">
        💊 Salud
    </option>

    <option value="otro">
        📦 Otro
    </option>

</select>
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- IMAGEN --}}
                        <div class="mb-6">
                            <label class="flex items-center gap-2.5 text-base font-bold text-gray-800 mb-2.5">
                                <span class="icon-circle bg-[#ccfbf1] text-[#0d9488]">🖼️</span>
                                Imagen del producto
                            </label>
                            <div class="drop-zone p-8 text-center" id="dropZone" onclick="document.getElementById('img_pro').click()">
                                <input type="file" name="img_pro" id="img_pro" accept="image/jpeg,image/png,image/webp" class="hidden" onchange="updateFileName(this)">
                                <div class="flex flex-col items-center gap-2 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-800 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="text-gray-800 font-semibold text-base" id="file-label">Selecciona una imagen o arrastra aquí</p>
                                    <p class="text-gray-400 text-sm">JPG, PNG o WEBP. Máximo 5MB</p>
                                </div>
                            </div>
                        </div>

                        {{-- ============================================ --}}
                        {{-- BOTÓN PUBLICAR - GARANTIZADO VISIBLE        --}}
                        {{-- ============================================ --}}
                        <div class="pt-2">
                            <button type="submit" class="btn-sp w-full py-4 rounded-xl text-lg font-bold shadow-md flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Publicar Producto
                            </button>
                        </div>

                    </form>

                </div>

            </div>

            {{-- ================= SIDEBAR ================= --}}
            <div class="space-y-5 relative">

                <div class="paw-print -top-4 -right-4">🐾</div>
                <div class="paw-print top-48 -right-2">🐾</div>

                {{-- CONSEJOS --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative z-10">
                    <div class="flex items-center gap-2.5 mb-5">
                        <span class="icon-circle bg-yellow-100 text-yellow-600 text-base">💡</span>
                        <h2 class="text-xl font-bold text-[#0d9488]">Consejos</h2>
                    </div>
                    <div class="space-y-3.5">
                        <div class="flex items-center gap-3 text-gray-600">
                            <span class="icon-circle bg-[#ccfbf1] text-[#0d9488] text-xs">📷</span>
                            <span class="text-sm font-medium">Usa imágenes claras</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-600">
                            <span class="icon-circle bg-[#ccfbf1] text-[#0d9488] text-xs">💲</span>
                            <span class="text-sm font-medium">Coloca precios reales</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-600">
                            <span class="icon-circle bg-[#ccfbf1] text-[#0d9488] text-xs">✏️</span>
                            <span class="text-sm font-medium">Describe bien el producto</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-600">
                            <span class="icon-circle bg-[#ccfbf1] text-[#0d9488] text-xs">🐾</span>
                            <span class="text-sm font-medium">Publica artículos útiles</span>
                        </div>
                    </div>
                </div>

                {{-- CATEGORIAS --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-10">
                    <div class="bg-[#0d9488] p-4">
                        <h2 class="text-lg font-bold text-white">Categorías</h2>
                    </div>
                    <div class="divide-y divide-gray-50">
                        <a href="#" class="flex justify-between items-center p-4 hover:bg-[#ccfbf1]/50 transition group">
                            <div class="flex items-center gap-3">
                                <span class="text-lg">🍖</span>
                                <span class="text-gray-700 text-sm font-medium group-hover:text-[#0d9488]">Comida para mascotas</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#" class="flex justify-between items-center p-4 hover:bg-[#ccfbf1]/50 transition group">
                            <div class="flex items-center gap-3">
                                <span class="text-lg">🧸</span>
                                <span class="text-gray-700 text-sm font-medium group-hover:text-[#0d9488]">Juguetes</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#" class="flex justify-between items-center p-4 hover:bg-[#ccfbf1]/50 transition group">
                            <div class="flex items-center gap-3">
                                <span class="text-lg">🎀</span>
                                <span class="text-gray-700 text-sm font-medium group-hover:text-[#0d9488]">Accesorios</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#" class="flex justify-between items-center p-4 hover:bg-[#ccfbf1]/50 transition group">
                            <div class="flex items-center gap-3">
                                <span class="text-lg">💊</span>
                                <span class="text-gray-700 text-sm font-medium group-hover:text-[#0d9488]">Salud y cuidado</span>
                            </div>
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<script>
    function updateFileName(input) {
        const label = document.getElementById('file-label');
        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name;
            label.classList.add('text-[#0f766e]', 'font-bold');
            label.classList.remove('text-gray-800');
        } else {
            label.textContent = 'Selecciona una imagen o arrastra aquí';
            label.classList.remove('text-[#0f766e]', 'font-bold');
            label.classList.add('text-gray-800');
        }
    }

    const dropZone = document.getElementById('dropZone');
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropZone.classList.add('drag-active');
        });
    });
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropZone.classList.remove('drag-active');
        });
    });
    dropZone.addEventListener('drop', (e) => {
        const files = e.dataTransfer.files;
        if (files.length && files[0].type.startsWith('image/')) {
            document.getElementById('img_pro').files = files;
            updateFileName(document.getElementById('img_pro'));
        }
    });
</script>

@endsection