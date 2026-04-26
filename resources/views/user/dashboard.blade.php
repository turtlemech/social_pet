@extends('layouts.app')

@section('content')

@php 
    use Carbon\Carbon; 
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl shadow-lg p-6 mb-8 text-white">
        <div class="flex items-center justify-between flex-wrap">
            <div>
                <h1 class="text-2xl font-bold mb-2">
                    ¡Bienvenido de vuelta, {{ Auth::user()->name }}!
                </h1>
                <p class="text-teal-100">
                    Comparte momentos especiales con tu mascota
                </p>
            </div>
            <img src="https://cdn-icons-png.flaticon.com/512/1998/1998629.png" 
                 alt="Pets" 
                 class="w-20 h-20 opacity-90">
        </div>
    </div>
    
    <div class="flex flex-col lg:flex-row gap-6">
        
        <!-- Sidebar Left -->
        <div class="lg:w-1/4 space-y-6">
            <x-dashboard.stories-section :stories="['Max', 'Luna', 'Charlie', 'Bella']" />
            <x-dashboard.quick-menu />
            <x-dashboard.user-card :user="Auth::user()" />
        </div>
        
        <!-- Main Feed -->
        <div class="lg:w-2/4">
            
            <!-- Crear post -->
            <x-posts.create-post />

            <!-- Tabs -->
            <x-dashboard.feed-tabs />

            @php
                $fakePosts = [
                    (object)[
                        'pet_name' => 'Max',
                        'breed' => 'Golden Retriever',
                        'author' => 'Sarah Johnson',
                        'time_ago' => '2 horas',
                        'content' => '¡Disfrutando del parque! 🐾',
                        'image' => 'https://images.dog.ceo/breeds/retriever-golden/n02099601_100.jpg',
                        'likes' => 124,
                        'comments' => 18
                    ],
                    (object)[
                        'pet_name' => 'Luna',
                        'breed' => 'Husky',
                        'author' => 'Mike Rodríguez',
                        'time_ago' => '5 horas',
                        'content' => '¿Quién quiere galletas? 🦴',
                        'image' => 'https://images.dog.ceo/breeds/husky/n02110185_100.jpg',
                        'likes' => 89,
                        'comments' => 12
                    ]
                ];
            @endphp

            <!-- POSTS REALES -->
            @foreach($posts as $post)
                <x-posts.post-card 
                    :post="(object)[
                        'id' => $post->id,
                        'pet_name' => 'Mascota',
                        'breed' => '',
                        'author' => $post->user->name ?? 'Usuario',
                        'time_ago' => $post->created_at 
                            ? Carbon::parse($post->created_at)->diffForHumans()
                            : 'Ahora',
                        'content' => $post->con_pub,
                        'image' => null,
                        'likes' => $post->likes->count(),
                        'liked' => $post->likes->contains('id_usuario', auth()->id()),
                        'comments' => 0
                    ]" 
                />
            @endforeach

            <!-- POSTS DE EJEMPLO -->
            @foreach($fakePosts as $post)
                <x-posts.post-card :post="$post" />
            @endforeach

        </div>
        
        <!-- Sidebar Right -->
        <div class="lg:w-1/4 space-y-6">
            <x-dashboard.suggested-pets />
            <x-dashboard.trending-topics />
            <x-dashboard.event-card />
        </div>
        
    </div>
</div>
@endsection