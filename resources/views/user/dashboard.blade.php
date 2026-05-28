@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl shadow-lg p-6 mb-8 text-white">

        <div class="flex items-center justify-between flex-wrap">

            <div>

                <h1 class="text-2xl font-bold mb-2">
                    ¡Bienvenido de vuelta, {{ Auth::user()->nom_us ?? 'Usuario' }}!
                </h1>

                <p class="text-teal-100">
                    Comparte momentos especiales con tu mascota
                </p>

            </div>

            <img
                src="https://cdn-icons-png.flaticon.com/512/1998/1998629.png"
                alt="Pets"
                class="w-20 h-20 opacity-90"
            >

        </div>

    </div>

    <div class="flex flex-col lg:flex-row gap-6">

        <!-- Sidebar Left -->
        <div class="lg:w-1/4 space-y-6">

            <x-dashboard.stories-section
                :stories="['Max', 'Luna', 'Charlie', 'Bella']"
            />

            <x-dashboard.quick-menu />

            <x-dashboard.user-card
                :user="Auth::user()"
            />

        </div>

        <!-- Main Feed -->
        <div class="lg:w-2/4">

            <!-- Crear post -->
            <x-posts.create-post />

            <!-- Tabs -->
            <x-dashboard.feed-tabs />

            <!-- POSTS REALES -->
            @if(isset($posts) && $posts->count() > 0)

                @foreach($posts as $post)

                    <x-posts.post-card :post="$post" />

                @endforeach

            @else

                <div class="bg-white rounded-xl shadow-sm p-6 text-center text-gray-500">

                    No hay publicaciones todavía.

                </div>

            @endif

        </div>

        <!-- Sidebar Right -->
        <div class="lg:w-1/4 space-y-6">

            <x-dashboard.suggested-pets />

            <x-dashboard.trending-topics />

            @if(isset($eventoProximo))

    <x-dashboard.event-card

    :title="$eventoProximo->nom_eve"

    :date="\Carbon\Carbon::parse($eventoProximo->fch_eve)->diffForHumans()"

    :location="$eventoProximo->ubicacion->nom_ubi"

    :status="$eventoProximo->est_eve"

    image="🐾"

/>

@endif

        </div>

    </div>

</div>

@endsection