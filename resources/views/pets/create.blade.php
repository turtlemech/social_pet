@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="max-w-5xl mx-auto px-4">

        <div class="bg-gradient-to-r from-teal-600 to-emerald-500 rounded-3xl shadow-xl p-8 mb-8 text-white flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-extrabold mb-2">
                    🐾 Nueva Mascota
                </h1>

                <p class="text-teal-50 text-lg">
                    Crea el perfil social de tu mascota y compártelo con la comunidad
                </p>
            </div>

            <div class="hidden md:flex w-24 h-24 bg-white/20 rounded-full items-center justify-center text-5xl">
                🐶
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-white rounded-3xl shadow-lg p-8">

                <form
                    action="{{ route('pets.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-6"
                >

                    @csrf

                    <div class="bg-teal-50 border-2 border-dashed border-teal-300 rounded-3xl p-6 text-center">
                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            Foto de la mascota
                        </label>

                        <div class="text-5xl mb-3">📷</div>

                        <p class="text-gray-500 text-sm mb-4">
                            Sube una imagen bonita para el perfil de tu mascota
                        </p>

                        <input
                            type="file"
                            name="fot_mas"
                            class="w-full bg-white border border-gray-200 rounded-2xl p-3"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            Nombre
                        </label>

                        <input
                            type="text"
                            name="nom_mas"
                            placeholder="Ej: Max"
                            class="w-full bg-gray-100 border-0 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-teal-500"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            Especie
                        </label>

                        <select
                            name="especie_id"
                            class="w-full bg-gray-100 border-0 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-teal-500"
                        >
                            <option value="">Selecciona una especie</option>
                            <option value="1">🐶 Perro</option>
                            <option value="2">🐱 Gato</option>
                            
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            Sexo
                        </label>

                        <select
                            name="sex_mas"
                            class="w-full bg-gray-100 border-0 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-teal-500"
                        >
                            <option value="macho">Macho</option>
                            <option value="hembra">Hembra</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            Descripción
                        </label>

                        <textarea
                            name="des_mas"
                            rows="5"
                            placeholder="Cuéntanos sobre tu mascota..."
                            class="w-full bg-gray-100 border-0 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-teal-500 resize-none"
                        ></textarea>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button
                            type="submit"
                            class="flex-1 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white py-4 rounded-2xl font-bold shadow-lg transition hover:scale-[1.01]"
                        >
                            Crear Mascota
                        </button>

                        <a href="{{ route('pets.index') }}"
                           class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-4 px-6 rounded-2xl font-bold">
                            Cancelar
                        </a>
                    </div>

                </form>

            </div>

            <div class="bg-white rounded-3xl shadow-lg p-6 h-fit">

                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    Vista previa
                </h2>

                <div class="rounded-3xl overflow-hidden border bg-gray-50">
                    <div class="h-40 bg-gradient-to-r from-teal-500 to-emerald-500 flex items-center justify-center text-6xl">
                        🐾
                    </div>

                    <div class="p-5">
                        <h3 class="font-bold text-xl text-gray-800">
                            Nombre de tu mascota
                        </h3>

                        <p class="text-gray-500 text-sm mt-2">
                            Aquí aparecerá la descripción y los datos de tu mascota.
                        </p>

                        <div class="flex gap-2 mt-4">
                            <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-sm">
                                Mascota
                            </span>

                            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm">
                                SocialPet
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-gray-100 rounded-2xl p-4">
                    <h3 class="font-bold text-gray-700 mb-2">
                        Consejo
                    </h3>

                    <p class="text-sm text-gray-500">
                        Agrega una foto clara y una descripción bonita para que otros usuarios conozcan mejor a tu mascota.
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection