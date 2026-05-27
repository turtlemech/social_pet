@extends('layouts.app')

@section('content')

@if(session('success'))

<script>

Swal.fire({

    icon: 'success',

    title: 'Evento actualizado',

    text: '{{ session('success') }}',

    confirmButtonColor: '#14b8a6'

});

</script>

@endif

<div class="min-h-screen bg-[#f4f7fb] px-6 py-12">

    <div class="max-w-4xl mx-auto bg-white rounded-[32px] shadow-xl p-10">

        <h1 class="text-5xl font-black text-gray-900 mb-3">
            Editar Evento ✏️
        </h1>

        <p class="text-gray-500 mb-10">
            Modifica la información de tu evento.
        </p>

        @if ($errors->any())

            <div class="md:col-span-2 bg-red-100 border border-red-300 text-red-700 p-4 rounded-2xl mb-6">

                <ul class="list-disc list-inside">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form
            action="{{ route('eventos.update', $evento) }}"
            method="POST"
            enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols-2 gap-5"
        >

            @csrf
            @method('PUT')

            <!-- NOMBRE -->
            <input
                type="text"
                name="nom_eve"
                value="{{ old('nom_eve', $evento->nom_eve) }}"
                class="bg-gray-100 rounded-2xl p-4"
                required
            >

            <!-- FECHA -->
            <input

                type="datetime-local"

                name="fch_eve"

                value="{{ \Carbon\Carbon::parse($evento->fch_eve)->format('Y-m-d\TH:i') }}"

                min="{{ now()->format('Y-m-d\TH:i') }}"

                class="bg-gray-100 rounded-2xl p-4"

                required

            >

            <!-- DESCRIPCIÓN -->
            <textarea
                name="des_eve"
                class="md:col-span-2 bg-gray-100 rounded-2xl p-4 h-32"
                required
            >{{ old('des_eve', $evento->des_eve) }}</textarea>

            <!-- UBICACIÓN -->
            <input
                type="text"
                name="nom_ubi"
                value="{{ old('nom_ubi', $evento->ubicacion->nom_ubi) }}"
                class="md:col-span-2 bg-gray-100 rounded-2xl p-4"
                required
            >

            <!-- CATEGORÍA -->
            <select
                name="cat_eve"
                class="bg-gray-100 rounded-2xl p-4"
            >

                <option value="General" {{ old('cat_eve', $evento->cat_eve) == 'General' ? 'selected' : '' }}>
                    General
                </option>

                <option value="Adopción" {{ old('cat_eve', $evento->cat_eve) == 'Adopción' ? 'selected' : '' }}>
                    Adopción
                </option>

                <option value="Caminata" {{ old('cat_eve', $evento->cat_eve) == 'Caminata' ? 'selected' : '' }}>
                    Caminata
                </option>

                <option value="Competencia" {{ old('cat_eve', $evento->cat_eve) == 'Competencia' ? 'selected' : '' }}>
                    Competencia
                </option>

                <option value="Veterinaria" {{ old('cat_eve', $evento->cat_eve) == 'Veterinaria' ? 'selected' : '' }}>
                    Veterinaria
                </option>

                <option value="Feria" {{ old('cat_eve', $evento->cat_eve) == 'Feria' ? 'selected' : '' }}>
                    Feria
                </option>

            </select>

            <!-- CAPACIDAD -->
            <input
                type="number"
                name="capacidad_eve"
                value="{{ old('capacidad_eve', $evento->capacidad_eve) }}"
                class="bg-gray-100 rounded-2xl p-4"
            >

            <!-- ESTADO -->
            <select
                name="est_eve"
                class="bg-gray-100 rounded-2xl p-4"
                required
            >

                <option value="activo"
                    {{ old('est_eve', $evento->est_eve) == 'activo' ? 'selected' : '' }}>
                    Activo
                </option>

                <option value="cancelado"
                    {{ old('est_eve', $evento->est_eve) == 'cancelado' ? 'selected' : '' }}>
                    Cancelado
                </option>

                <option value="finalizado"
                    {{ old('est_eve', $evento->est_eve) == 'finalizado' ? 'selected' : '' }}>
                    Finalizado
                </option>

            </select>

            <!-- IMAGEN ACTUAL -->
            @if($evento->img_eve)

            <div class="md:col-span-2">

                <p class="font-bold text-gray-700 mb-3">
                    Imagen actual
                </p>

                <img
                    src="{{ asset('storage/' . $evento->img_eve) }}"
                    class="w-full h-64 object-cover rounded-2xl"
                >

            </div>

            @endif

            <!-- NUEVA IMAGEN -->
            <div class="md:col-span-2">

                <label class="block font-bold text-gray-700 mb-3">
                    Cambiar imagen
                </label>

                <input
                    type="file"
                    name="img_eve"
                    accept="image/*"
                    class="w-full bg-gray-100 rounded-2xl p-4"
                >

            </div>

            <!-- BOTÓN -->
            <button
                class="md:col-span-2 bg-gradient-to-r from-teal-500 to-cyan-500 text-white py-4 rounded-2xl font-bold text-lg hover:scale-[1.01] transition"
            >
                Guardar Cambios
            </button>

            <!-- VOLVER -->
            <a
                href="{{ route('eventos.mis-eventos') }}"
                class="md:col-span-2 text-center bg-gray-200 hover:bg-gray-300 text-gray-800 py-4 rounded-2xl font-bold transition"
            >
                Volver
            </a>

        </form>

    </div>

</div>

@endsection