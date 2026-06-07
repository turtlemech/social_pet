@extends('layouts.app')

@section('content')

<style>
    .adoption-header {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 60%, #115e59 100%);
    }
    .btn-sp {
        background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
        transition: all 0.3s ease;
    }
    .btn-sp:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(13, 148, 136, 0.4);
    }
    .pet-option {
        transition: all 0.2s ease;
    }
    .pet-option:hover {
        background: #f0fdf4;
    }
    .pet-option.selected {
        background: #ccfbf1;
        border-color: #0d9488;
    }
    .drop-zone {
        border: 2px dashed #0d9488;
        background: #f0fdf4;
        transition: all 0.3s ease;
    }
    .drop-zone:hover {
        background: #ccfbf1;
        border-color: #0f766e;
    }
</style>

<div class="min-h-screen bg-[#f3f4f6] py-8 px-4 sm:px-6">

    <div class="max-w-4xl mx-auto">

        {{-- ================= HEADER ================= --}}
        <div class="adoption-header rounded-2xl p-6 lg:p-8 mb-6 text-white shadow-lg relative overflow-hidden">

            <div class="relative z-10 flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm w-14 h-14 rounded-full flex items-center justify-center border border-white/30">
                    <span class="text-3xl">🏠</span>
                </div>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Publicar Mascota en Adopción</h1>
                    <p class="text-teal-100 mt-1">Encuentra un hogar amoroso para tu peludito 💚</p>
                </div>
            </div>

        </div>

        {{-- ================= FORMULARIO ================= --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">

            <form action="/adopciones"
      method="POST"
      onsubmit="console.log('ENVIANDO');">
    @csrf

    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

                {{-- SELECCIONAR MASCOTA --}}
                <div class="mb-6">
                    <label class="flex items-center gap-2 text-lg font-bold text-gray-800 mb-3">
                        <span class="w-8 h-8 rounded-full bg-[#ccfbf1] text-[#0d9488] flex items-center justify-center text-sm">🐾</span>
                        Selecciona tu mascota
                    </label>

                    @if($mascotas->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                            @foreach($mascotas as $mascota)
                                <label class="pet-option flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:border-[#0d9488]/30">
                                    <input

    type="radio"

    name="mas_id"

    value="{{ $mascota->id }}"

    class="accent-[#0d9488]"

    {{ old('mas_id') == $mascota->id ? 'checked' : '' }}

    required

>
                                    <img src="{{ $mascota->fot_mas ? asset('storage/' . $mascota->fot_mas) : 'https://ui-avatars.com/api/?name='.urlencode($mascota->nom_mas).'&background=0d9488&color=fff&size=100' }}" 
                                         class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm" 
                                         alt="{{ $mascota->nom_mas }}">
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">{{ $mascota->nom_mas }}</p>
                                        <p class="text-xs text-gray-500">{{ $mascota->sex_mas ?? '' }} • {{ $mascota->especie ?? 'Mascota' }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center">
                            <p class="text-yellow-700 text-sm">No tienes mascotas registradas.</p>
                            <a href="{{ route('mascotas.create') }}" class="text-[#0d9488] font-semibold text-sm hover:underline mt-1 inline-block">
                                + Registrar una mascota primero
                            </a>
                        </div>
                    @endif
                </div>

                {{-- DESCRIPCIÓN --}}
                <div class="mb-6">
                    <label class="flex items-center gap-2 text-lg font-bold text-gray-800 mb-3">
                        <span class="w-8 h-8 rounded-full bg-[#ccfbf1] text-[#0d9488] flex items-center justify-center text-sm">📝</span>
                        Descripción de adopción
                    </label>
                    <textarea
                        name="des_ado"
                        rows="5"
                        class="w-full border border-gray-200 rounded-xl p-4 text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#0d9488] focus:border-[#0d9488] outline-none transition resize-none bg-gray-50/50"
                        placeholder="Ejemplo: Luna es una perrita muy cariñosa de 2 años. Busca una familia con patio donde pueda jugar. Está vacunada y esterilizada. Se lleva bien con niños y otros perros. 🐕💚"
                        required
                    >{{ old('des_ado') }}</textarea>
                    <p class="text-xs text-gray-400 mt-2">Sé honesto y detallado. Menciona edad, temperamento, cuidados especiales, etc.</p>
                </div>

                {{-- REQUISITOS (opcional) --}}
                <div class="mb-6">
                    <label class="flex items-center gap-2 text-lg font-bold text-gray-800 mb-3">
                        <span class="w-8 h-8 rounded-full bg-[#ccfbf1] text-[#0d9488] flex items-center justify-center text-sm">✅</span>
                        Requisitos del adoptante (opcional)
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition">
                            <input type="checkbox" name="req_patio" value="1" class="accent-[#0d9488] w-4 h-4">
                            <span class="text-sm text-gray-700">🏡 Tener patio/jardín</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition">
                            <input type="checkbox" name="req_experiencia" value="1" class="accent-[#0d9488] w-4 h-4">
                            <span class="text-sm text-gray-700">🎓 Experiencia con mascotas</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition">
                            <input type="checkbox" name="req_compromiso" value="1" class="accent-[#0d9488] w-4 h-4">
                            <span class="text-sm text-gray-700">💚 Compromiso de cuidado</span>
                        </label>
                        <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition">
                            <input type="checkbox" name="req_visitas" value="1" class="accent-[#0d9488] w-4 h-4">
                            <span class="text-sm text-gray-700">👁️ Permitir visitas de seguimiento</span>
                        </label>
                    </div>
                </div>

                {{-- CONTACTO --}}
                <div class="mb-8">
                    <label class="flex items-center gap-2 text-lg font-bold text-gray-800 mb-3">
                        <span class="w-8 h-8 rounded-full bg-[#ccfbf1] text-[#0d9488] flex items-center justify-center text-sm">📱</span>
                        Teléfono de contacto
                    </label>
                    <input
                        type="tel"
                        name="tel_ado"
                        class="w-full border border-gray-200 rounded-xl p-4 text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#0d9488] focus:border-[#0d9488] outline-none transition bg-gray-50/50"
                        placeholder="Ej: 71234567"
                    >
                </div>

                {{-- BOTÓN PUBLICAR --}}
                <button type="submit" class="btn-sp w-full py-4 rounded-xl text-white font-bold text-lg shadow-md flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    Publicar en Adopción
                </button>

                <p class="text-center text-xs text-gray-400 mt-4">
                    Al publicar, aceptas nuestras políticas de adopción responsable.
                </p>

            </form>

        </div>

    </div>

</div>

<script>
    // Selección visual de mascota
    document.querySelectorAll('.pet-option input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.pet-option').forEach(opt => opt.classList.remove('selected'));
            this.closest('.pet-option').classList.add('selected');
        });
    });
</script>

@endsection