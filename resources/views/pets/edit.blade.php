@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto px-4 py-10">

    <div class="bg-white rounded-3xl shadow-xl p-8">

        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            ✏️ Editar Mascota
        </h1>

        <form
            action="{{ route('pets.update', $mascota->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div class="mb-6">

                <label class="block font-semibold mb-2">
                    Nombre
                </label>

                <input
                    type="text"
                    name="nom_mas"
                    value="{{ old('nom_mas', $mascota->nom_mas) }}"
                    class="w-full border rounded-2xl p-3"
                >

            </div>

            <!-- Sexo -->
            <div class="mb-6">

                <label class="block font-semibold mb-2">
                    Sexo
                </label>

                <select
                    name="sex_mas"
                    class="w-full border rounded-2xl p-3"
                >

                    <option value="macho"
                        {{ $mascota->sex_mas == 'macho' ? 'selected' : '' }}>
                        Macho
                    </option>

                    <option value="hembra"
                        {{ $mascota->sex_mas == 'hembra' ? 'selected' : '' }}>
                        Hembra
                    </option>

                </select>

            </div>

            <!-- Descripción -->
            <div class="mb-6">

                <label class="block font-semibold mb-2">
                    Descripción
                </label>

                <textarea
                    name="des_mas"
                    rows="5"
                    class="w-full border rounded-2xl p-3"
                >{{ old('des_mas', $mascota->des_mas) }}</textarea>

            </div>

            <!-- Foto -->
            <div class="mb-8">

                <label class="block font-semibold mb-2">
                    Nueva foto (opcional)
                </label>

                <input
                    type="file"
                    name="fot_mas"
                    class="w-full"
                >

            </div>

            <div class="flex gap-4">

                <button
                    type="submit"
                    class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-2xl font-semibold"
                >
                    Guardar cambios
                </button>

                <a
                    href="{{ route('pets.show', $mascota->id) }}"
                    class="bg-gray-200 hover:bg-gray-300 px-6 py-3 rounded-2xl font-semibold"
                >
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>

@endsection