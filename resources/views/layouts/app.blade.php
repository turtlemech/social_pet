<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SocialPet') }}</title>

     <!--  FAVICON - Aquí se agrega el ícono de la pestaña  -->
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/img/logo/social_pet.jpg') }}">
    <link rel="icon" type="image/png" href="{{ asset('storage/img/logo/social_pet.jpg') }}">
    <link rel="shortcut icon" href="{{ asset('storage/img/logo/social_et.jpg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- SOLO UN NAVBAR --}}
        @livewire('navigation-menu')

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    @livewireScripts
</body>
</html>