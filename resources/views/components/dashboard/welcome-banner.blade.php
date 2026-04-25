@props(['user'])

<div class="bg-gradient-to-r from-social-teal to-teal-700 rounded-2xl shadow-lg p-6 mb-8 text-white">
    <div class="flex items-center justify-between flex-wrap">
        <div>
            <h1 class="text-2xl font-bold mb-2">¡Bienvenido de vuelta, {{ $user->name }}!</h1>
            <p class="text-teal-100">Comparte momentos especiales con tu mascota y conecta con otros amantes de animales.</p>
        </div>
        <img src="https://cdn-icons-png.flaticon.com/512/1998/1998629.png" alt="Pets" class="w-20 h-20 opacity-90 mt-4 sm:mt-0">
    </div>
</div>