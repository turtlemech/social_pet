@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto px-4">

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-gradient-to-r from-teal-600 to-teal-700 p-6">
            <h1 class="text-3xl font-bold text-white">
                Editar Producto
            </h1>

            <p class="text-teal-100 mt-2">
                Actualiza la información de tu producto
            </p>
        </div>

        {{-- FORMULARIO --}}
        <form action="{{ route('marketplace.update', $producto->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="p-6 space-y-6">

            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nombre del producto
                </label>

                <input type="text"
                       name="nom_pro"
                       value="{{ old('nom_pro', $producto->nom_pro) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none"
                       required>
            </div>

            {{-- Descripción --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Descripción
                </label>

                <textarea name="des_pro"
                          rows="5"
                          class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none">{{ old('des_pro', $producto->des_pro) }}</textarea>
            </div>

            {{-- Precio --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Precio (Bs.)
                </label>

                <input type="number"
                       step="0.01"
                       min="0"
                       name="pre_pro"
                       value="{{ old('pre_pro', $producto->pre_pro) }}"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none"
                       required>
            </div>

            {{-- Categoría --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Categoría
                </label>

                <select name="cat_pro"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-teal-500 focus:outline-none"
                        required>

                    <option value="alimento"
                        {{ $producto->cat_pro == 'alimento' ? 'selected' : '' }}>
                        🍖 Comida
                    </option>

                    <option value="juguete"
                        {{ $producto->cat_pro == 'juguete' ? 'selected' : '' }}>
                        🧸 Juguetes
                    </option>

                    <option value="accesorio"
                        {{ $producto->cat_pro == 'accesorio' ? 'selected' : '' }}>
                        🎀 Accesorios
                    </option>

                    <option value="salud"
                        {{ $producto->cat_pro == 'salud' ? 'selected' : '' }}>
                        💊 Salud
                    </option>

                </select>
            </div>

            {{-- Imagen actual --}}
            @if($producto->img_pro)
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Imagen actual
                </label>

                <img src="{{ asset('storage/' . $producto->img_pro) }}"
                     class="w-48 rounded-xl border">
            </div>
            @endif

            {{-- Nueva imagen --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Reemplazar imagen (opcional)
                </label>

                <input type="file"
                       name="img_pro"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3">
            </div>

            {{-- Errores --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Botones --}}
            <div class="flex gap-3">

                <button type="submit"
                        class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-xl font-semibold">
                    Guardar Cambios
                </button>

                <a href="{{ route('marketplace.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-semibold">
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>
@endsection