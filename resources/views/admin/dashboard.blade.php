@extends('layouts.admin')

@section('title', 'Dashboard - Social Pet')

@section('content')
<!-- Header -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <h1 class="text-3xl font-bold text-orange-600 mb-2">Panel de Administración</h1>
    <p class="text-gray-600">Bienvenido, <strong class="text-gray-800">{{ auth()->user()->nom_us }}</strong></p>
</div>

<!-- Tarjetas de Estadísticas -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm mb-1">Total Usuarios</p>
                <p class="text-3xl font-bold text-gray-800">{{ \App\Models\User::count() }}</p>
            </div>
            <div class="bg-orange-100 rounded-full p-3">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm mb-1">Administradores</p>
                <p class="text-3xl font-bold text-purple-600">{{ \App\Models\User::where('is_admin', true)->count() }}</p>
            </div>
            <div class="bg-purple-100 rounded-full p-3">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm mb-1">Total Mascotas</p>
                <p class="text-3xl font-bold text-blue-600">{{ \App\Models\Mascota::count() }}</p>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.586a1 1 0 00-.707.293l-2.828 2.828A1 1 0 006.586 7H5a2 2 0 00-2 2v3a2 2 0 002 2h4m6 0h.586a1 1 0 01.707.293l2.828 2.828A1 1 0 0118.414 21H17"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm mb-1">Publicaciones</p>
                <p class="text-3xl font-bold text-green-600">{{ \App\Models\Publicacion::count() ?? 0 }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Content -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
        <span>📊</span> Dashboard
    </h2>
    <p class="text-gray-600">Aquí irá el contenido del panel de administración.</p>
</div>

<!-- Estadísticas Rápidas -->
<div class="bg-white rounded-xl shadow-sm p-6">
    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
        <span>📈</span> Estadísticas Rápidas
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
            <span class="text-gray-600">Usuarios activos:</span>
            <span class="font-bold text-green-600">{{ \App\Models\User::where('est_us', 'activo')->count() }}</span>
        </div>
        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
            <span class="text-gray-600">Usuarios inactivos:</span>
            <span class="font-bold text-red-600">{{ \App\Models\User::where('est_us', 'inactivo')->count() }}</span>
        </div>
        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
            <span class="text-gray-600">Usuarios baneados:</span>
            <span class="font-bold text-red-600">{{ \App\Models\User::where('est_us', 'baneado')->count() }}</span>
        </div>
        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
            <span class="text-gray-600">Nuevos usuarios (este mes):</span>
            <span class="font-bold text-blue-600">{{ \App\Models\User::whereMonth('created_at', now()->month)->count() }}</span>
        </div>
    </div>
</div>
@endsection