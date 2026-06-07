@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f0f2f5]">
    

    <div class="max-w-7xl mx-auto px-4 py-6 flex gap-6">
        
        {{-- Sidebar izquierdo estilo Social Pet --}}
        <aside class="hidden lg:block w-64 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-4 mb-4">
                <h3 class="font-bold text-gray-800 mb-3">Menú Rápido</h3>
                <nav class="space-y-1">
                    <a href="{{ route('feed') }}" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-gray-50 text-gray-600">
                        <i class="fas fa-home w-5"></i>
                        <span>Inicio</span>
                    </a>
                    <a href="{{ route('comunidades.index') }}" class="flex items-center space-x-3 p-2 rounded-xl bg-teal-50 text-teal-700 font-medium">
                        <i class="fas fa-users w-5"></i>
                        <span>Comunidades</span>
                    </a>
                    
                    <a href="#" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-gray-50 text-gray-600">
                        <i class="fas fa-bell w-5"></i>
                        <span>Notificaciones</span>
                    </a>
                </nav>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-4">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <div>
                        <p class="font-semibold text-sm">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">Miembro desde {{ auth()->user()->created_at->format('M Y') }}</p>
                    </div>
                </div>
                <div class="flex justify-between text-center pt-3 border-t">
                    <div>
                        <p class="font-bold text-lg">0</p>
                        <p class="text-xs text-gray-500">Posts</p>
                    </div>
                    <div>
                        <p class="font-bold text-lg">0</p>
                        <p class="text-xs text-gray-500">Seguidores</p>
                    </div>
                    <div>
                        <p class="font-bold text-lg">0</p>
                        <p class="text-xs text-gray-500">Siguiendo</p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Contenido principal --}}
        <main class="flex-1 max-w-2xl">
            
            {{-- Header tipo banner --}}
            <div class="bg-gradient-to-r from-teal-600 to-teal-500 rounded-2xl p-6 mb-6 shadow-lg relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-10 -mt-10"></div>
                <div class="relative z-10">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white">Crear Comunidad</h1>
                            <p class="text-teal-100 text-sm">Crea grupos para dueños y amantes de mascotas</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Formulario estilo card --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                
                {{-- Preview de cover (se actualiza con JS) --}}
                <div class="h-48 bg-gradient-to-r from-gray-200 to-gray-300 relative group" id="coverPreview">
                    <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                        <div class="text-center">
                            <i class="fas fa-image text-4xl mb-2"></i>
                            <p class="text-sm">Vista previa del cover</p>
                        </div>
                    </div>
                    <img id="coverImage" class="w-full h-full object-cover hidden">
                </div>

                <div class="px-6 pb-6">
                    {{-- Avatar preview --}}
                    <div class="relative -mt-10 mb-6 flex items-end space-x-4">
                        <div class="w-20 h-20 bg-white rounded-2xl shadow-md p-1">
                            <div class="w-full h-full bg-teal-100 rounded-xl flex items-center justify-center" id="avatarPreview">
                                <i class="fas fa-paw text-teal-600 text-2xl"></i>
                            </div>
                            <img id="avatarImage" class="w-full h-full rounded-xl object-cover hidden">
                        </div>
                        <div class="pb-2">
                            <p class="text-xs text-gray-500">La imagen se mostrará como avatar del grupo</p>
                        </div>
                    </div>

                    <form action="{{ route('comunidades.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        {{-- Nombre --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Nombre de la comunidad <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="nom_com" 
                                id="nom_com"
                                placeholder="Ej: Amantes de Golden Retrievers"
                                class="w-full border border-gray-200 rounded-xl p-3.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition bg-gray-50 hover:bg-white"
                                required
                                maxlength="100"
                            >
                            <p class="text-xs text-gray-400 mt-1 text-right"><span id="charCount">0</span>/100</p>
                        </div>

                        {{-- Descripción --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Descripción
                            </label>
                            <textarea 
                                name="des_com" 
                                rows="4" 
                                placeholder="Describe de qué trata tu comunidad, reglas, etc..."
                                class="w-full border border-gray-200 rounded-xl p-3.5 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition bg-gray-50 hover:bg-white resize-none"
                            ></textarea>
                        </div>

                        {{-- Privacidad --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Privacidad
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="pri_com" value="Publica" class="peer sr-only" checked>
                                    <div class="border-2 border-gray-200 rounded-xl p-4 peer-checked:border-teal-500 peer-checked:bg-teal-50 transition hover:bg-gray-50">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <i class="fas fa-globe-americas text-teal-600 text-lg"></i>
                                            <span class="font-semibold text-gray-800">Pública</span>
                                        </div>
                                        <p class="text-xs text-gray-500">Cualquiera puede ver y unirse</p>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="pri_com" value="Privada" class="peer sr-only">
                                    <div class="border-2 border-gray-200 rounded-xl p-4 peer-checked:border-teal-500 peer-checked:bg-teal-50 transition hover:bg-gray-50">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <i class="fas fa-lock text-teal-600 text-lg"></i>
                                            <span class="font-semibold text-gray-800">Privada</span>
                                        </div>
                                        <p class="text-xs text-gray-500">Solo miembros pueden ver contenido</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Foto --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Foto de portada
                            </label>
                            <div class="relative">
                                <input 
                                    type="file" 
                                    name="fot_com" 
                                    id="fot_com"
                                    accept="image/*"
                                    class="hidden"
                                    onchange="previewImage(this)"
                                >
                                <label 
                                    for="fot_com" 
                                    class="flex items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-xl p-6 cursor-pointer hover:border-teal-500 hover:bg-teal-50 transition group"
                                >
                                    <div class="text-center">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 group-hover:text-teal-500 mb-2 transition"></i>
                                        <p class="text-sm text-gray-600 font-medium">Haz clic para subir una imagen</p>
                                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP hasta 5MB</p>
                                    </div>
                                </label>
                            </div>
                            <p id="fileName" class="text-xs text-teal-600 mt-2 hidden"></p>
                        </div>

                        {{-- Tags / Categorías --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Categoría
                            </label>
                            <select name="cat_com" class="w-full border border-gray-200 rounded-xl p-3.5 focus:outline-none focus:ring-2 focus:ring-teal-500 bg-gray-50">
                                <option value="">Selecciona una categoría...</option>
                                <option value="perros">🐕 Perros</option>
                                <option value="gatos">🐈 Gatos</option>
                                <option value="aves">🦜 Aves</option>
                                <option value="peces">🐠 Peces</option>
                                <option value="reptiles">🦎 Reptiles</option>
                                <option value="roedores">🐹 Roedores</option>
                                <option value="general">🐾 General</option>
                            </select>
                        </div>

                        {{-- Reglas del grupo (opcional) --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Reglas de la comunidad <span class="text-xs font-normal text-gray-400">(opcional)</span>
                            </label>
                            <div class="space-y-2">
                                <input type="text" name="reglas[]" placeholder="Regla 1: Sé respetuoso..." class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 bg-gray-50">
                                <input type="text" name="reglas[]" placeholder="Regla 2: No spam..." class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 bg-gray-50">
                                <input type="text" name="reglas[]" placeholder="Regla 3:..." class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 bg-gray-50">
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="flex gap-3 pt-4 border-t">
                            <a href="{{ route('comunidades.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-xl font-bold text-center transition">
                                Cancelar
                            </a>
                            <button type="submit" class="flex-1 bg-teal-600 hover:bg-teal-700 text-white py-3 rounded-xl font-bold transition shadow-lg shadow-teal-200">
                                <i class="fas fa-plus mr-2"></i>Crear Comunidad
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        {{-- Sidebar derecho --}}
        <aside class="hidden xl:block w-80 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-4 mb-4">
                <h3 class="font-bold text-gray-800 mb-3">💡 Consejos</h3>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li class="flex items-start space-x-2">
                        <i class="fas fa-check-circle text-teal-500 mt-0.5"></i>
                        <span>Usa un nombre claro y descriptivo</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class="fas fa-check-circle text-teal-500 mt-0.5"></i>
                        <span>Agrega una foto atractiva de portada</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class="fas fa-check-circle text-teal-500 mt-0.5"></i>
                        <span>Define reglas desde el inicio</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class="fas fa-check-circle text-teal-500 mt-0.5"></i>
                        <span>Invita a tus amigos a unirse</span>
                    </li>
                </ul>
            </div>

            <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl shadow-sm p-4 text-white">
                <div class="flex items-center space-x-2 mb-2">
                    <i class="fas fa-lightbulb text-yellow-300"></i>
                    <span class="font-bold">¿Sabías que?</span>
                </div>
                <p class="text-sm text-teal-100">
                    Las comunidades con foto de portada reciben 3x más miembros que las que no tienen.
                </p>
            </div>
        </aside>
    </div>
</div>

<script>
    // Preview de imagen
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('coverImage').src = e.target.result;
                document.getElementById('coverImage').classList.remove('hidden');
                document.getElementById('coverPreview').querySelector('.absolute').classList.add('hidden');
                
                // Avatar pequeño
                document.getElementById('avatarImage').src = e.target.result;
                document.getElementById('avatarImage').classList.remove('hidden');
                document.getElementById('avatarPreview').classList.add('hidden');
                
                // Nombre archivo
                document.getElementById('fileName').textContent = '📷 ' + input.files[0].name;
                document.getElementById('fileName').classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Contador de caracteres
    document.getElementById('nom_com').addEventListener('input', function() {
        document.getElementById('charCount').textContent = this.value.length;
    });
</script>
@endsection