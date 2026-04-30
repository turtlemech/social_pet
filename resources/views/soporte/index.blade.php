@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Botón de Admin/Staff -->
        <div class="mb-6 flex justify-end">
            @auth
                @if(Auth::user()->is_admin)
                <a href="{{ route('admin.soporte.dashboard') }}"
                    class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition transform hover:scale-105 inline-flex items-center space-x-2">
                    <span>🛠️</span>
                    <span>Panel Soporte</span>
                </a>
                @endif
            @else
            <a href="{{ route('admin.login') }}"
                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition inline-flex items-center space-x-2">
                <span>👑</span>
                <span>Acceso Admin/Staff</span>
            </a>
            @endauth
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Panel de información -->
            <div class="lg:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Centro de Ayuda</h3>

                        <div class="space-y-4">
                            <a href="{{ route('soporte.mis-tickets') }}"
                                class="block p-3 bg-teal-50 rounded-lg hover:bg-teal-100 transition">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Mis Tickets</p>
                                        <p class="text-sm text-gray-600">Ver seguimiento de tus solicitudes</p>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0)" onclick="consultarEstado()"
                                class="block p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium">Consultar Estado</p>
                                        <p class="text-sm text-gray-600">Revisa el estado de tu ticket</p>
                                    </div>
                                </div>
                            </a>

                            <div class="border-t pt-4">
                                <h4 class="font-medium mb-3">📌 Preguntas Frecuentes</h4>
                                <div class="space-y-2">
                                    <details class="text-sm">
                                        <summary class="cursor-pointer text-teal-600 hover:text-teal-800">¿Cómo cambio mi contraseña?</summary>
                                        <p class="mt-1 text-gray-600">Ve a Configuración > Seguridad > Cambiar contraseña</p>
                                    </details>
                                    <details class="text-sm">
                                        <summary class="cursor-pointer text-teal-600 hover:text-teal-800">¿Cómo registro mi mascota?</summary>
                                        <p class="mt-1 text-gray-600">Ve a Mis Mascotas > Agregar nueva mascota</p>
                                    </details>
                                    <details class="text-sm">
                                        <summary class="cursor-pointer text-teal-600 hover:text-teal-800">¿Cómo contacto con otros dueños?</summary>
                                        <p class="mt-1 text-gray-600">Usa el sistema de mensajería en el perfil de cada usuario</p>
                                    </details>
                                    <details class="text-sm">
                                        <summary class="cursor-pointer text-teal-600 hover:text-teal-800">¿Qué hago si no puedo iniciar sesión?</summary>
                                        <p class="mt-1 text-gray-600">Usa la opción "¿Olvidaste tu contraseña?" en el login</p>
                                    </details>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de soporte -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Crear Nuevo Ticket de Soporte</h3>
                        <p class="text-sm text-gray-500 mb-4">Completa el formulario y te responderemos a la brevedad</p>

                        <form id="ticketForm" action="{{ route('soporte.submit') }}" method="POST" class="space-y-4">
                            @csrf

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                                    <input type="text"
                                        name="nom_contacto"
                                        value="{{ old('nom_contacto', Auth::user()->nom_us ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                                        placeholder="Tu nombre completo"
                                        required>
                                    @error('nom_contacto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                    <input type="email"
                                        name="email_contacto"
                                        value="{{ old('email_contacto', Auth::user()->ema_us ?? '') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                                        placeholder="tu@email.com"
                                        required>
                                    @error('email_contacto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Asunto *</label>
                                <input type="text"
                                    name="asu_sop"
                                    value="{{ old('asu_sop') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                                    placeholder="Ej: Problema al registrar mi mascota"
                                    required>
                                @error('asu_sop') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                                    <select name="cat_sop" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                        <option value="">Seleccionar</option>
                                        <option value="tecnico">🔧 Problema Técnico</option>
                                        <option value="cuenta">👤 Mi Cuenta</option>
                                        <option value="mascota">🐾 Mis Mascotas</option>
                                        <option value="pago">💰 Pagos</option>
                                        <option value="otro">❓ Otro</option>
                                    </select>
                                    @error('cat_sop') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
                                    <select name="pri_sop" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                        <option value="baja">🟢 Baja - Consulta general</option>
                                        <option value="media">🟡 Media - Necesito ayuda</option>
                                        <option value="alta">🟠 Alta - Problema urgente</option>
                                        <option value="urgente">🔴 Urgente - No puedo usar la plataforma</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje *</label>
                                <textarea name="men_sop"
                                    rows="6"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500"
                                    placeholder="Describe detalladamente tu problema..."
                                    required>{{ old('men_sop') }}</textarea>
                                @error('men_sop') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit"
                                class="w-full bg-gradient-to-r from-teal-500 to-teal-700 text-white px-4 py-3 rounded-lg font-semibold hover:from-teal-600 hover:to-teal-800 transition transform hover:scale-[1.02]">
                                <span id="btnText">📩 Enviar Ticket</span>
                                <span id="btnSpinner" class="hidden">⏳ Enviando...</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="flash-data" 
     data-success="{{ session('success') ? e(session('success')) : '' }}"
     data-error="{{ session('error') ? e(session('error')) : '' }}"
     data-errors="{{ $errors->any() ? e(json_encode($errors->all())) : '' }}"
     style="display: none;">
</div>

@endsection

