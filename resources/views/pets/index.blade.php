{{-- Hereda el diseño principal --}}
@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="max-w-6xl mx-auto">

        <div class="flex justify-between items-center mb-8">

            <div>
                <h1 class="text-4xl font-bold text-green-700">
                    Mis Mascotas
                </h1>

                <p class="text-gray-500 mt-2">
                    Aquí puedes ver las mascotas registradas 🐾
                </p>
            </div>

            <a href="{{ route('pets.create') }}"
               class="bg-green-700 hover:bg-green-800 text-green px-5 py-3 rounded-xl shadow">
                + Registrar Mascota
            </a>

        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            @forelse($pets as $pet)

                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

                    {{-- Foto de mascota --}}
                    @if($pet->fot_mas)
                        <img
                            src="{{ asset('storage/' . $pet->fot_mas) }}"
                            class="w-full h-64 object-cover"
                        >
                    @else
                        <div class="w-full h-64 bg-green-100 flex items-center justify-center text-6xl">
                            🐾
                        </div>
                    @endif

                    <div class="p-6">

                        {{-- Nombre --}}
                        <h2 class="text-2xl font-bold text-green-700">
                            {{ $pet->nom_mas }}
                        </h2>

                        {{-- Sexo --}}
                        <p class="text-gray-600 mt-2">
                            Sexo: {{ $pet->sex_mas }}
                        </p>

                        {{-- Estado --}}
                        <p class="text-gray-600">
                            Estado: {{ $pet->est_mas }}
                        </p>

                        {{-- Descripción --}}
                        <p class="text-gray-500 mt-3">
                            {{ $pet->des_mas ?? 'Sin descripción' }}
                        </p>

                    </div>

                </div>

            @empty

                <div class="col-span-3 bg-white rounded-3xl shadow p-10 text-center">

                    <p class="text-black-500 text-lg">
                        Todavía no tienes mascotas registradas.
                    </p>

                    <a href="{{ route('pets.create') }}"
                       class="inline-block mt-5 bg-green-700 text-black px-5 py-3 rounded-xl">
                        Registrar mi primera mascota
                    </a>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection