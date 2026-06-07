@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto px-4 py-10">

    <!-- HEADER -->
    <div class="mb-10">

        <h1 class="text-4xl font-bold text-gray-800 mb-2">
            🐾 Nueva Mascota
        </h1>

        <p class="text-gray-500 text-lg">
            Crea el perfil social de tu mascota
        </p>

    </div>

    <!-- FORM -->
    <div class="bg-white rounded-3xl shadow-sm p-8">

        <form
            action="{{ route('pets.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6"
        >

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

            <!-- FOTO -->
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Foto de la mascota
                </label>

                <input
                    type="file"
                    name="fot_mas"
                    class="w-full border border-gray-200 rounded-2xl p-3"
                >

            </div>

            <!-- NOMBRE -->
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Nombre
                </label>

                <input

    type="text"

    name="nom_mas"

    value="{{ old('nom_mas') }}"

    placeholder="Ej: Max"
        class="w-full border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-teal-500"
                >

            </div>

            <!-- ESPECIE -->
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Especie
                </label>

                <select
                    name="especie_id"
                    class="w-full border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-teal-500"
                >

                    <option value="">
                        Selecciona una especie
                    </option>

                    <option value="1" {{ old('especie_id') == 1 ? 'selected' : '' }}>

    Perro

</option>

<option value="2" {{ old('especie_id') == 2 ? 'selected' : '' }}>

    Gato

</option>

<option value="3" {{ old('especie_id') == 3 ? 'selected' : '' }}>

    Ave

</option>
<option value="4" {{ old('especie_id') == 4 ? 'selected' : '' }}>
    Reptil
</option>
                </select>

            </div>

            <!-- SEXO -->
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Sexo
                </label>

                <select
                    name="sex_mas"
                    class="w-full border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-teal-500"
                >

                    <option value="macho" {{ old('sex_mas') == 'macho' ? 'selected' : '' }}>

    Macho

</option>

<option value="hembra" {{ old('sex_mas') == 'hembra' ? 'selected' : '' }}>

    Hembra

</option>

                </select>

            </div>
            <!-- PERSONALIDAD -->
<div>

    <label class="block text-sm font-semibold text-gray-700 mb-3">
        Personalidad
    </label>

    <select
        name="per_mas"
        class="w-full border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-teal-500"
    >

        <option value="">
            Selecciona una personalidad
        </option>

        <option value="Sociable" {{ old('per_mas') == 'Sociable' ? 'selected' : '' }}>
            Sociable
        </option>

        <option value="Juguetón" {{ old('per_mas') == 'Juguetón' ? 'selected' : '' }}>
            Juguetón
        </option>

        <option value="Tranquilo" {{ old('per_mas') == 'Tranquilo' ? 'selected' : '' }}>
            Tranquilo
        </option>

        <option value="Protector" {{ old('per_mas') == 'Protector' ? 'selected' : '' }}>
            Protector
        </option>

        <option value="Activo" {{ old('per_mas') == 'Activo' ? 'selected' : '' }}>
            Activo
        </option>

    </select>

</div>

            <!-- DESCRIPCIÓN -->
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Descripción
                </label>

                <textarea
    name="des_mas"
    rows="5"
    placeholder="Cuéntanos sobre tu mascota..."
    class="w-full border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-teal-500 resize-none"
>{{ old('des_mas') }}</textarea>

            </div>

            <!-- BOTÓN -->
            <div class="pt-4">

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-600 hover:to-emerald-600 text-white py-4 rounded-2xl font-semibold shadow-lg transition hover:scale-[1.01]"
                >

                    Crear Mascota

                </button>

            </div>

        </form>

    </div>

</div>

@endsection