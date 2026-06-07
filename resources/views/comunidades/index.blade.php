@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

    <div class="max-w-7xl mx-auto px-4">

        <div class="bg-teal-600 text-white rounded-2xl p-6 mb-8 shadow-lg flex justify-between items-center">

            <div>
                <h1 class="text-2xl font-bold">

    Comunidades

</h1>

<p class="text-teal-100 text-sm mt-1">

    Descubre grupos para compartir fotos, consejos y eventos de mascotas.

</p>
            </div>

            <a
                href="{{ route('comunidades.create') }}"
                class="bg-white text-teal-700 px-5 py-2.5 rounded-xl font-bold shadow hover:bg-gray-50 transition text-sm"
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

            @forelse($comunidades as $com)

                <div class="bg-white rounded-2xl overflow-hidden shadow-lg">

                    <img
                        src="{{ $com->fot_com ? asset('storage/'.$com->fot_com) : 'https://via.placeholder.com/600x300?text=Comunidad' }}"
                        class="w-full h-56 object-cover"
                    >

                    <div class="p-5">

                        <h2 class="text-2xl font-bold text-gray-800">
                            {{ $com->nom_com }}
                        </h2>

                        <p class="text-xs text-gray-400 mt-1">
    {{ \Carbon\Carbon::parse($com->fch_cre_com)->diffForHumans() }}
</p>

                        <p class="text-gray-600 mt-3">
                            {{ $com->des_com }}
                        </p>

                        <div class="mt-4">

                            <span class="bg-teal-100 text-teal-700 px-3 py-2 rounded-full text-sm font-bold">
                                {{ $com->pri_com }}
                            </span>
                            @if($com->cat_com)
    <span class="bg-orange-100 text-orange-700 px-3 py-2 rounded-full text-sm font-bold ml-2">
        {{ ucfirst($com->cat_com) }}
    </span>
@endif

                        </div>

                        @if(in_array($com->cod_com, $misComunidades))

    <div class="mt-5 space-y-2">

        <a
            href="{{ route('comunidades.show', $com->cod_com) }}"
            class="block w-full text-center bg-teal-600 hover:bg-teal-700 text-white py-3 rounded-xl font-bold"
        >
            Ver comunidad
        </a>

        <form
            action="{{ route('comunidades.salir', $com->cod_com) }}"
            method="POST"
        >
            @csrf

            <button
                class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-bold"
            >
                Salir
            </button>

        </form>

    </div>

@else


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

@endif

                    </div>

                </div>

            @empty

<div class="col-span-3 bg-white rounded-2xl shadow-sm p-12 text-center">

    <div class="text-5xl mb-4">🐾</div>

    <h2 class="text-xl font-bold text-gray-800 mb-2">
        No hay comunidades todavía
    </h2>

    <p class="text-gray-500">
        Crea la primera comunidad para amantes de mascotas.
    </p>

</div>

@endforelse

        </div>

    </div>

</div>

@endsection