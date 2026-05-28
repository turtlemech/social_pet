@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="max-w-4xl mx-auto px-4">

        <div class="bg-teal-600 text-white rounded-2xl p-6 mb-6 shadow-lg">
            <h1 class="text-3xl font-bold">
                👥 Crear Comunidad
            </h1>
            <p class="mt-2">
                Crea grupos para dueños y amantes de mascotas.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-6">

            <form action="{{ route('comunidades.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="font-bold block mb-2">Nombre</label>

                    <input
                        type="text"
                        name="nom_com"
                        class="w-full border rounded-xl p-3"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="font-bold block mb-2">Descripción</label>

                    <textarea
                        name="des_com"
                        rows="4"
                        class="w-full border rounded-xl p-3"
                    ></textarea>
                </div>

                <div class="mb-4">
                    <label class="font-bold block mb-2">Privacidad</label>

                    <select
                        name="pri_com"
                        class="w-full border rounded-xl p-3"
                    >
                        <option value="Publica">Pública</option>
                        <option value="Privada">Privada</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="font-bold block mb-2">Foto</label>

                    <input
                        type="file"
                        name="fot_com"
                        class="w-full border rounded-xl p-3"
                    >
                </div>

                <button
                    class="w-full bg-teal-600 hover:bg-teal-700 text-white py-3 rounded-xl font-bold"
                >
                    Crear Comunidad
                </button>

            </form>

        </div>

    </div>

</div>

@endsection