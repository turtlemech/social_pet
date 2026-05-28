{{-- Hereda el diseño principal --}}
@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- FORMULARIO --}}
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-xl p-8">

            {{-- Título --}}
            <div class="text-center mb-10">

                <h1 class="text-4xl font-bold text-green-700">
                    Registrar Nueva Mascota
                </h1>

                <p class="text-gray-500 mt-3">
                    Llena los datos de tu mascota 🐶🐱
                </p>

            </div>

            {{-- Formulario --}}
            <form action="{{ route('pets.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                {{-- Nombre --}}
                <div class="mb-6">

                    <label class="font-semibold text-gray-700 block mb-2">
                        Nombre de la mascota
                    </label>

                    <input
                        type="text"
                        name="nom_mas"
                        class="w-full border-2 border-green-300 rounded-2xl p-4"
                        placeholder="Ejemplo: Firulais"
                        required
                    >

                </div>

                {{-- Sexo --}}
                <div class="mb-6">

                    <label class="font-semibold text-gray-700 block mb-2">
                        Sexo
                    </label>

                    <select
                        name="sex_mas"
                        class="w-full border-2 border-green-300 rounded-2xl p-4"
                        required
                    >

                        <option value="Macho">
                             Macho
                        </option>

                        <option value="Hembra">
                             Hembra
                        </option>

                    </select>

                </div>

                {{-- Descripción --}}
                <div class="mb-6">

                    <label class="font-semibold text-gray-700 block mb-2">
                        Descripción
                    </label>

                    <textarea
                        name="des_mas"
                        rows="4"
                        class="w-full border-2 border-green-300 rounded-2xl p-4"
                        placeholder="Describe a tu mascota..."
                    ></textarea>

                </div>

                {{-- Imagen --}}
                <div class="mb-6">

                    <label class="font-semibold text-gray-700 block mb-2">
                        Foto de la mascota
                    </label>

                    <input
                        type="file"
                        name="fot_mas"
                        class="w-full border-2 border-dashed border-green-400 rounded-2xl p-4 bg-green-50"
                    >

                </div>

                {{-- Estado --}}
                <div class="mb-6">

                    <label class="font-semibold text-gray-700 block mb-2">
                        Estado
                    </label>

                    <select
                        name="est_mas"
                        class="w-full border-2 border-green-300 rounded-2xl p-4"
                        required
                    >

                        <option value="activo">
                            ✅ Activo
                        </option>

                        <option value="inactivo">
                            ❌ Inactivo
                        </option>

                    </select>

                </div>

                {{-- Especie --}}
                <div class="mb-8">

                    <label class="font-semibold text-gray-700 block mb-2">
                        Especie
                    </label>

                    <select
                        name="especie_id"
                        class="w-full border-2 border-green-300 rounded-2xl p-4"
                        required
                    >

                        <option value="1">
                            🐶 Perro
                        </option>

                        <option value="2">
                            🐱 Gato
                        </option>

                    </select>

                </div>

                {{-- Botón --}}
                <button
                    type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-black py-4 rounded-2xl shadow-lg mt-6 font-semibold"
                >
                    🐾 Guardar Mascota 🐾
                </button>

            </form>

        </div>

        {{-- PANEL DERECHO --}}
        <div class="space-y-6">

            {{-- Consejos --}}
            <div class="bg-white rounded-3xl shadow-xl p-6">

                <h2 class="text-2xl font-bold text-green-700 mb-4">
                    📌 Consejos
                </h2>

                <ul class="space-y-4 text-gray-600">

                    <li>
                        📷 Usa una foto clara
                    </li>

                    <li>
                        🐾 Describe la personalidad
                    </li>

                    <li>
                        ❤️ Mantén datos actualizados
                    </li>

                    <li>
                        🐶 Agrega mascotas reales
                    </li>

                </ul>

            </div>

            {{-- Vista previa --}}
            <div class="bg-white rounded-3xl shadow-xl p-6 text-center">

                <h2 class="text-2xl font-bold text-green-700 mb-5">
                    🐕 Vista previa
                </h2>

                <img
                    src="https://placedog.net/500"
                    class="rounded-2xl w-full h-72 object-cover"
                >

                <p class="mt-4 text-gray-500">
                    Tu mascota aparecerá aquí
                </p>

            </div>

        </div>

    </div>

</div>

@endsection