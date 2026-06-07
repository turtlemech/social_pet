@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-4 py-10">

    <div class="bg-white rounded-3xl shadow-sm p-8">

        <h1 class="text-3xl font-bold mb-2">
            Nueva historia destacada
        </h1>

        <p class="text-gray-500 mb-8">
            Selecciona las historias que quieres guardar en una colección destacada.
        </p>

        @if($historias->isEmpty())

            <div class="text-center py-16">

                <p class="text-gray-500 text-lg">
                    No tienes historias disponibles.
                </p>

                <a
                    href="{{ route('historias.crear') }}"
                    class="inline-block mt-4 px-6 py-3 bg-teal-600 text-white rounded-xl hover:bg-teal-700"
                >
                    Crear historia
                </a>

            </div>

        @else

        <form
            action="{{ route('historias.destacadas.guardar') }}"
            method="POST"
        >

            @csrf

@if ($errors->any())

    <div class="mb-4 bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl">

        <ul>

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

            <div class="mb-6">

                <label class="block font-semibold mb-2">
                    Título de la destacada
                </label>

                <input
                    type="text"
                    name="titulo"
                    maxlength="50"
                    required
                    placeholder="Ej: Vacaciones, Rocky, Eventos..."
                    class="w-full border rounded-xl px-4 py-3"
                >

            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

                @foreach($historias as $historia)

                <label class="cursor-pointer">

                    <input
                        type="checkbox"
                        name="historias[]"
                        value="{{ $historia->id }}"
                        class="hidden peer"
                    >

                    <div class="relative border-4 border-transparent peer-checked:border-teal-500 rounded-2xl overflow-hidden">

                        @if($historia->tipo === 'video')

                            <video
                                class="w-full h-52 object-cover"
                            >
                                <source
                                    src="{{ asset('storage/'.$historia->media) }}"
                                >
                            </video>

                        @else

                            <img
                                src="{{ asset('storage/'.$historia->media) }}"
                                class="w-full h-52 object-cover"
                            >

                        @endif

                        <div class="absolute top-2 right-2 bg-white rounded-full px-2 py-1 text-xs font-bold shadow">

                            ✓

                        </div>

                    </div>

                </label>

                @endforeach

            </div>

            <div class="flex gap-4">

                <button
                    type="submit"
                    class="px-6 py-3 bg-teal-600 text-white rounded-xl hover:bg-teal-700"
                >
                    Guardar destacada
                </button>

                <a
                    href="{{ url()->previous() }}"
                    class="px-6 py-3 bg-gray-200 rounded-xl hover:bg-gray-300"
                >
                    Cancelar
                </a>

            </div>

        </form>

        @endif

    </div>

</div>

@endsection