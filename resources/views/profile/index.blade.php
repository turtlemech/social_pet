@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Mensajes Flash -->
        @if(session('success'))
            <div class="fixed top-20 right-4 z-50 animate-bounce" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                <div class="bg-green-100 border-l-4 border-teal-500 text-teal-700 px-4 py-3 rounded-lg shadow-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="fixed top-20 right-4 z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg shadow-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tarjeta de Información del Perfil -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Mi Perfil</h2>
                        <p class="text-sm text-gray-600 mt-1">Gestiona tu información personal</p>
                    </div>
                    <div class="relative">
                        @if($user->ava_us)
                            <img src="{{ Storage::url($user->ava_us) }}" 
                                 alt="Avatar" 
                                 class="w-20 h-20 rounded-full ring-4 ring-teal-500 ring-offset-2 object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nom_us) }}&background=0d9488&color=fff&bold=true&length=2&size=80" 
                                 alt="Avatar" 
                                 class="w-20 h-20 rounded-full ring-4 ring-teal-500 ring-offset-2">
                        @endif
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre completo</label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name', $user->nom_us) }}" 
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Correo electrónico</label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email', $user->ema_us) }}" 
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                            <input type="text" 
                                   name="phone" 
                                   value="{{ old('phone', $user->tel_us ?? '') }}" 
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('phone') border-red-500 @enderror"
                                   placeholder="Opcional">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ciudad -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad</label>
                            <input type="text" 
                                   name="city" 
                                   value="{{ old('city', $user->ciu_us ?? '') }}" 
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('city') border-red-500 @enderror"
                                   placeholder="Opcional">
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-gradient-to-r from-teal-500 to-teal-700 text-white px-6 py-2 rounded-lg font-semibold hover:from-teal-600 hover:to-teal-800 transition shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Actualizar Perfil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tarjeta de Cambiar Contraseña -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Cambiar Contraseña</h2>
                <p class="text-sm text-gray-600 mb-6">Mantén tu cuenta segura con una contraseña fuerte</p>

                <form action="{{ route('profile.password') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña actual</label>
                            <input type="password" 
                                   name="current_password" 
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('current_password') border-red-500 @enderror"
                                   required>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div></div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nueva contraseña</label>
                            <input type="password" 
                                   name="password" 
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                                   required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar nueva contraseña</label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                                   required>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-gradient-to-r from-teal-500 to-teal-700 text-white px-6 py-2 rounded-lg font-semibold hover:from-teal-600 hover:to-teal-800 transition shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Actualizar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tarjeta de Cambiar Avatar -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Foto de Perfil</h2>
                <p class="text-sm text-gray-600 mb-6">Personaliza cómo te ven los demás</p>

                <div class="flex items-center space-x-6">
                    <div class="shrink-0">
                        @if($user->ava_us)
                            <img src="{{ Storage::url($user->ava_us) }}" 
                                 alt="Avatar" 
                                 class="w-24 h-24 rounded-full ring-4 ring-teal-500 ring-offset-2 object-cover">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nom_us) }}&background=0d9488&color=fff&bold=true&length=2&size=96" 
                                 alt="Avatar" 
                                 class="w-24 h-24 rounded-full ring-4 ring-teal-500 ring-offset-2">
                        @endif
                    </div>
                    
                    <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" class="flex-1">
                        @csrf
                        <div class="flex flex-col sm:flex-row gap-4">
                            <label class="flex-1">
                                <input type="file" 
                                       name="avatar" 
                                       class="hidden" 
                                       accept="image/*" 
                                       onchange="this.form.submit()">
                                <div class="cursor-pointer text-center px-4 py-2 rounded-lg border-2 border-dashed border-gray-300 hover:border-teal-500 transition">
                                    <svg class="inline w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Seleccionar imagen
                                </div>
                            </label>
                            <p class="text-xs text-gray-500 self-center">
                                JPG, PNG o GIF. Máx 2MB
                            </p>
                        </div>
                        @error('avatar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </form>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Desactivar Cuenta -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border-2 border-yellow-200">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-yellow-600 mb-2">Desactivar Cuenta</h2>
                        <p class="text-sm text-gray-600 mb-6">
                            Al desactivar tu cuenta, no podrás acceder a la plataforma.
                            <br>Todos tus datos se conservan y puedes reactivarla cuando lo desees contactando al soporte.
                        </p>
                    </div>
                    <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>

                <button type="button" 
                        @click="$dispatch('open-modal', 'confirm-user-deactivation')"
                        class="bg-yellow-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-yellow-700 transition shadow-md hover:shadow-lg">
                    <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636M12 9v4m0 4h.01"/>
                    </svg>
                    Desactivar Mi Cuenta
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación para Desactivar Cuenta -->
<div x-data="{ show: false }" 
     x-show="show" 
     @open-modal.window="if ($event.detail === 'confirm-user-deactivation') show = true" 
     @close-modal.window="show = false"
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="show" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div x-show="show" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium text-gray-900">
                                ¿Desactivar tu cuenta?
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Al desactivar tu cuenta:
                                </p>
                                <ul class="mt-2 text-sm text-gray-500 list-disc list-inside">
                                    <li>No podrás iniciar sesión</li>
                                    <li>Tu perfil quedará oculto</li>
                                    <li>Tus datos se conservan y puedes reactivarlos cuando quieras</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirma tu contraseña para desactivar la cuenta</label>
                        <input type="password" 
                               name="password" 
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('password') border-red-500 @enderror"
                               required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-3 justify-end">
                        <button type="button" 
                                @click="show = false"
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 transition">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-yellow-600 text-white rounded-lg font-semibold hover:bg-yellow-700 transition">
                            Sí, desactivar mi cuenta
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    .animate-bounce {
        animation: bounce 0.5s ease 0s 1 normal;
    }
    @keyframes bounce {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(-10px); }
    }
</style>
@endsection