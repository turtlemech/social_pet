@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="max-w-7xl mx-auto px-4">

        <div class="bg-teal-600 text-white rounded-2xl p-6 mb-8 shadow-lg flex justify-between items-center">

            <div>
                <h1 class="text-4xl font-bold">
                    👥 Comunidades
                </h1>

                <p class="mt-2">
                    Encuentra grupos de mascotas y comparte experiencias.
                </p>
            </div>

            <a
                href="{{ route('comunidades.create') }}"
                class="bg-white text-teal-700 px-5 py-3 rounded-xl font-bold"
            >
                + Crear
            </a>

        </div>

        @if(session('success'))

            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                {{ session('success') }}
            </div>

        @endif

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($comunidades as $com)

                <div class="bg-white rounded-2xl overflow-hidden shadow-lg">

                    <img
                        src="{{ $com->fot_com ? asset('storage/'.$com->fot_com) : 'https://via.placeholder.com/600x300?text=Comunidad' }}"
                        class="w-full h-56 object-cover"
                    >

                    <div class="p-5">

                        <h2 class="text-2xl font-bold text-gray-800">
                            {{ $com->nom_com }}
                        </h2>

                        <p class="text-gray-600 mt-3">
                            {{ $com->des_com }}
                        </p>

                        <div class="mt-4">

                            <span class="bg-teal-100 text-teal-700 px-3 py-2 rounded-full text-sm font-bold">
                                {{ $com->pri_com }}
                            </span>

                        </div>

                        <form
                            action="{{ route('comunidades.unirse', $com->cod_com) }}"
                            method="POST"
                            class="mt-5"
                        >
                            @csrf

                            <button
                                class="w-full bg-teal-600 hover:bg-teal-700 text-white py-3 rounded-xl font-bold"
                            >
                                Unirse
                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>

@endsection