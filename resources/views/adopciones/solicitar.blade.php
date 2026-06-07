@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto py-8 px-4">

    <div class="bg-white rounded-2xl shadow p-6">

        <h1 class="text-3xl font-bold text-teal-700 mb-2">
            Solicitud de Adopción
        </h1>

        <p class="text-gray-500 mb-6">
            Completa el formulario para solicitar la adopción de
            <strong>{{ $adopcion->nom_mas }}</strong>
        </p>

        @if ($errors->any())

    <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded mb-4">

        <ul class="list-disc list-inside space-y-1">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

        <form
            action="{{ route('adopciones.solicitar.store', $adopcion->id) }}"
            method="POST">

            @csrf

            <div class="grid md:grid-cols-2 gap-4">

                <div>
                    <label>Teléfono</label>
                    <input
                        type="text"
                        name="telefono"
                        class="w-full border rounded-lg p-3"
                        required>
                </div>

                <div>
                    <label>Ciudad</label>
                    <input
                        type="text"
                        name="ciudad"
                        class="w-full border rounded-lg p-3"
                        required>
                </div>

            </div>

            <div class="mt-4">
                <label>Dirección</label>
                <textarea
                    name="direccion"
                    class="w-full border rounded-lg p-3"
                    required></textarea>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mt-4">

                <div>
                    <label>Tipo de vivienda</label>
                    <select
                        name="tipo_vivienda"
                        class="w-full border rounded-lg p-3">

                        <option>Casa</option>
                        <option>Departamento</option>

                    </select>
                </div>

                <div>
                    <label>La vivienda es:</label>
                    <select
                        name="tenencia_vivienda"
                        class="w-full border rounded-lg p-3">

                        <option>Propia</option>
                        <option>Alquilada</option>
                        <option>Familiar</option>

                    </select>
                </div>

            </div>

            <div class="mt-4">
                <label>Personas que viven contigo</label>
                <input
                    type="number"
                    min="1"
                    name="personas_hogar"
                    class="w-full border rounded-lg p-3">
            </div>

            <div class="mt-4 space-y-2">

                <label class="block">
                    <input type="checkbox" name="tiene_patio">
                    Tiene patio
                </label>

                <label class="block">
                    <input type="checkbox" name="hay_ninos">
                    Hay niños en casa
                </label>

                <label class="block">
                    <input type="checkbox" name="tiene_mascotas">
                    Tiene otras mascotas
                </label>

            </div>

            <div class="mt-4">
                <label>Si tienes mascotas, descríbelas</label>
                <textarea
                    name="detalle_mascotas"
                    class="w-full border rounded-lg p-3"></textarea>
            </div>

            <div class="mt-4">
                <label>¿Por qué deseas adoptar esta mascota?</label>
                <textarea
                    name="motivo_adopcion"
                    class="w-full border rounded-lg p-3"
                    rows="5"
                    required></textarea>
            </div>

            <button
                type="submit"
                class="mt-6 bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-xl font-bold">

                Enviar solicitud

            </button>

        </form>

    </div>

</div>

@endsection