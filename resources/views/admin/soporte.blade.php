@extends('layouts.admin')

@section('title', 'Gestión de Soporte')

@section('content')
<div class="space-y-6">
    <!-- Header con migas de pan -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">🎫 Tickets de Soporte</h1>
            <p class="text-gray-600 mt-1">Gestiona y responde a los tickets de los usuarios</p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.location.reload()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                🔄 Actualizar
            </button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-700 font-bold">&times;</button>
        </div>
    @endif

    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition cursor-pointer" onclick="filtrarPorEstado('')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Tickets</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $estadisticas['total'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Todos los tickets</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition cursor-pointer" onclick="filtrarPorEstado('abierto')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Abiertos</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $estadisticas['abiertos'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Pendientes de atención</p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition cursor-pointer" onclick="filtrarPorEstado('en_proceso')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">En Proceso</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $estadisticas['en_proceso'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Siendo atendidos</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition cursor-pointer" onclick="filtrarPorEstado('resuelto')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Resueltos</p>
                    <p class="text-3xl font-bold text-green-600">{{ $estadisticas['resueltos'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Completados</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Segunda fila de estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Cerrados</p>
                    <p class="text-3xl font-bold text-gray-600">{{ $estadisticas['cerrados'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Archivados</p>
                </div>
                <div class="bg-gray-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition cursor-pointer" onclick="filtrarPorPrioridad('urgente')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">🔴 Urgentes</p>
                    <p class="text-3xl font-bold text-red-600">{{ $estadisticas['urgentes'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Requieren atención inmediata</p>
                </div>
                <div class="bg-red-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tasa de resolución -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Tasa de Resolución</p>
                    <p class="text-3xl font-bold text-purple-600">
                        {{ $estadisticas['total'] > 0 ? round(($estadisticas['resueltos'] / $estadisticas['total']) * 100, 1) : 0 }}%
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Tickets resueltos</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Tiempo promedio -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Tiempo Promedio</p>
                    <p class="text-3xl font-bold text-teal-600">
                        {{ $estadisticas['tiempo_promedio'] ?? 'N/A' }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Desde apertura</p>
                </div>
                <div class="bg-teal-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-sm p-4">
        <form method="GET" action="{{ route('admin.soporte.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div class="relative md:col-span-2">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por código, asunto o usuario..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            </div>
            
            <select name="categoria" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                <option value="">📂 Todas las categorías</option>
                <option value="tecnico" {{ request('categoria') == 'tecnico' ? 'selected' : '' }}>🔧 Técnico</option>
                <option value="cuenta" {{ request('categoria') == 'cuenta' ? 'selected' : '' }}>👤 Cuenta</option>
                <option value="mascota" {{ request('categoria') == 'mascota' ? 'selected' : '' }}>🐾 Mascota</option>
                <option value="pago" {{ request('categoria') == 'pago' ? 'selected' : '' }}>💰 Pago</option>
                <option value="otro" {{ request('categoria') == 'otro' ? 'selected' : '' }}>📝 Otro</option>
            </select>
            
            <select name="estado" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                <option value="">🔄 Todos los estados</option>
                <option value="abierto" {{ request('estado') == 'abierto' ? 'selected' : '' }}>🟡 Abierto</option>
                <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>🔵 En Proceso</option>
                <option value="resuelto" {{ request('estado') == 'resuelto' ? 'selected' : '' }}>🟢 Resuelto</option>
                <option value="cerrado" {{ request('estado') == 'cerrado' ? 'selected' : '' }}>⚪ Cerrado</option>
            </select>
            
            <select name="prioridad" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                <option value="">🏷️ Todas las prioridades</option>
                <option value="baja" {{ request('prioridad') == 'baja' ? 'selected' : '' }}>🟢 Baja</option>
                <option value="media" {{ request('prioridad') == 'media' ? 'selected' : '' }}>🟡 Media</option>
                <option value="alta" {{ request('prioridad') == 'alta' ? 'selected' : '' }}>🟠 Alta</option>
                <option value="urgente" {{ request('prioridad') == 'urgente' ? 'selected' : '' }}>🔴 Urgente</option>
            </select>
            
            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-medium">
                    🔍 Filtrar
                </button>
                @if(request()->anyFilled(['search', 'categoria', 'estado', 'prioridad']))
                    <a href="{{ route('admin.soporte.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-center">
                        🗑️ Limpiar
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Lista de Tickets -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50 transition {{ $ticket->pri_sop == 'urgente' && $ticket->est_sop != 'resuelto' ? 'bg-red-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-gray-900">#{{ $ticket->cod_sop }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gradient-to-r from-orange-400 to-orange-600 flex items-center justify-center text-white text-sm font-bold">
                                    {{ strtoupper(substr($ticket->usuario->nom_us ?? 'U', 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $ticket->usuario->nom_us ?? 'N/A' }} {{ $ticket->usuario->app_us ?? '' }}</div>
                                    <div class="text-xs text-gray-500">{{ $ticket->usuario->cod_us ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate font-medium">{{ $ticket->asu_sop }}</div>
                            <div class="text-xs text-gray-500 truncate">{{ Str::limit($ticket->men_sop, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                @switch($ticket->cat_sop)
                                    @case('tecnico') 🔧 Técnico @break
                                    @case('cuenta') 👤 Cuenta @break
                                    @case('mascota') 🐾 Mascota @break
                                    @case('pago') 💰 Pago @break
                                    @default 📝 Otro
                                @endswitch
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $prioridadClases = [
                                    'baja' => 'bg-blue-100 text-blue-800',
                                    'media' => 'bg-yellow-100 text-yellow-800',
                                    'alta' => 'bg-orange-100 text-orange-800',
                                    'urgente' => 'bg-red-100 text-red-800 animate-pulse',
                                ];
                                $prioridadIconos = [
                                    'baja' => '🟢',
                                    'media' => '🟡',
                                    'alta' => '🟠',
                                    'urgente' => '🔴',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full font-medium {{ $prioridadClases[$ticket->pri_sop] ?? 'bg-gray-100' }}">
                                {{ $prioridadIconos[$ticket->pri_sop] ?? '' }} {{ ucfirst($ticket->pri_sop) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $estadoClases = [
                                    'abierto' => 'bg-yellow-100 text-yellow-800',
                                    'en_proceso' => 'bg-blue-100 text-blue-800',
                                    'resuelto' => 'bg-green-100 text-green-800',
                                    'cerrado' => 'bg-gray-100 text-gray-800',
                                ];
                                $estadoIconos = [
                                    'abierto' => '🟡',
                                    'en_proceso' => '🔵',
                                    'resuelto' => '🟢',
                                    'cerrado' => '⚪',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full font-medium {{ $estadoClases[$ticket->est_sop] ?? 'bg-gray-100' }}">
                                {{ $estadoIconos[$ticket->est_sop] ?? '' }} {{ ucfirst(str_replace('_', ' ', $ticket->est_sop)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <button onclick="verTicket('{{ $ticket->id }}')" 
                                    class="text-blue-600 hover:text-blue-900 mr-3 transition" 
                                    title="Ver Detalles">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            <button onclick="eliminarTicket('{{ $ticket->id }}')" 
                                    class="text-red-600 hover:text-red-900 transition" 
                                    title="Eliminar">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="font-medium">No hay tickets de soporte</p>
                            <p class="text-sm mt-1">Los tickets aparecerán aquí cuando los usuarios creen solicitudes de soporte</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($tickets->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $tickets->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Ver Ticket -->
<div id="verTicketModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">🎫 Detalles del Ticket</h3>
            <button onclick="cerrarModalTicket()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <div id="modalTicketBody" class="p-6"></div>
    </div>
</div>

<script>
const csrfToken = '{{ csrf_token() }}';

function filtrarPorEstado(estado) {
    const url = new URL(window.location.href);
    if (estado) {
        url.searchParams.set('estado', estado);
    } else {
        url.searchParams.delete('estado');
    }
    window.location.href = url.toString();
}

function filtrarPorPrioridad(prioridad) {
    const url = new URL(window.location.href);
    url.searchParams.set('prioridad', prioridad);
    window.location.href = url.toString();
}

function verTicket(id) {
    fetch(`/admin/soporte/${id}`)
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                mostrarModalTicket(data.ticket, data.tickets_relacionados);
            } else {
                alert('Error al cargar el ticket');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar el ticket');
        });
}

function mostrarModalTicket(ticket, ticketsRelacionados) {
    const modalBody = document.getElementById('modalTicketBody');
    
    const prioridadClases = {
        'baja': 'bg-blue-100 text-blue-800',
        'media': 'bg-yellow-100 text-yellow-800',
        'alta': 'bg-orange-100 text-orange-800',
        'urgente': 'bg-red-100 text-red-800'
    };
    
    const estadoClases = {
        'abierto': 'bg-yellow-100 text-yellow-800',
        'en_proceso': 'bg-blue-100 text-blue-800',
        'resuelto': 'bg-green-100 text-green-800',
        'cerrado': 'bg-gray-100 text-gray-800'
    };
    
    modalBody.innerHTML = `
        <div class="space-y-6">
            <!-- Información del Ticket -->
            <div class="bg-gradient-to-r from-gray-50 to-white rounded-lg p-4 border">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Código</p>
                        <p class="font-mono font-medium text-gray-900 text-lg">${ticket.cod_sop}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Categoría</p>
                        <p class="capitalize font-medium">${getCategoriaIcono(ticket.cat_sop)} ${ticket.cat_sop}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Prioridad</p>
                        <p class="capitalize font-semibold ${ticket.pri_sop === 'urgente' ? 'text-red-600' : ''}">${getPrioridadIcono(ticket.pri_sop)} ${ticket.pri_sop}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Fecha</p>
                        <p class="font-medium">${new Date(ticket.created_at).toLocaleString()}</p>
                    </div>
                </div>
            </div>
            
            <!-- Información del Usuario -->
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Información del Usuario
                </h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Nombre completo</p>
                        <p class="font-medium">${ticket.usuario?.nom_us || 'N/A'} ${ticket.usuario?.app_us || ''}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Código de usuario</p>
                        <p class="font-mono">${ticket.usuario?.cod_us || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Correo electrónico</p>
                        <p>${ticket.usuario?.email || 'N/A'}</p>
                    </div>
                </div>
            </div>
            
            <!-- Asunto y Mensaje -->
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    Asunto
                </h4>
                <p class="text-gray-900 font-medium mb-4">${escapeHtml(ticket.asu_sop)}</p>
                
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4zm2 2h12v2H6V6zm0 4h12v2H6v-2zm0 4h8v2H6v-2z"></path>
                    </svg>
                    Mensaje
                </h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 whitespace-pre-wrap">${escapeHtml(ticket.men_sop)}</p>
                </div>
            </div>
            
            ${ticket.res_sop ? `
            <!-- Respuesta Actual -->
            <div class="border rounded-lg p-4 bg-green-50">
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Respuesta del Administrador
                </h4>
                <div class="bg-white rounded-lg p-4">
                    <p class="text-gray-700 whitespace-pre-wrap">${escapeHtml(ticket.res_sop)}</p>
                </div>
                <div class="mt-2 text-xs text-gray-500 flex items-center gap-4">
                    <span>👤 Respondido por: ${ticket.administrador?.nom_us || 'Admin'} ${ticket.administrador?.app_us || ''}</span>
                    ${ticket.fec_resuelto ? `<span>📅 ${new Date(ticket.fec_resuelto).toLocaleString()}</span>` : ''}
                </div>
            </div>
            ` : ''}
            
            ${ticketsRelacionados && ticketsRelacionados.length > 0 ? `
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tickets anteriores del mismo usuario
                </h4>
                <div class="space-y-2 max-h-64 overflow-y-auto">
                    ${ticketsRelacionados.map(t => `
                        <div class="bg-gray-50 rounded p-3 text-sm hover:bg-gray-100 transition cursor-pointer" onclick="verTicket(${t.id})">
                            <div class="flex justify-between items-center">
                                <span class="font-mono font-medium text-blue-600">#${t.cod_sop}</span>
                                <span class="px-2 py-1 text-xs rounded-full ${estadoClases[t.est_sop]}">${t.est_sop}</span>
                            </div>
                            <p class="text-gray-700 mt-1 font-medium">${escapeHtml(t.asu_sop)}</p>
                            <p class="text-xs text-gray-500 mt-1">📅 ${new Date(t.created_at).toLocaleDateString()}</p>
                        </div>
                    `).join('')}
                </div>
            </div>
            ` : ''}
            
            <!-- Formulario de Respuesta -->
            <div class="border rounded-lg p-4 bg-orange-50">
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                    Responder Ticket
                </h4>
                <form id="formRespuesta" onsubmit="return false;">
                    <textarea id="respuestaTexto" rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none" 
                              placeholder="Escribe tu respuesta aquí..."></textarea>
                    
                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cambiar Estado</label>
                            <select id="estadoTicket" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                <option value="abierto" ${ticket.est_sop === 'abierto' ? 'selected' : ''}>🟡 Abierto</option>
                                <option value="en_proceso" ${ticket.est_sop === 'en_proceso' ? 'selected' : ''}>🔵 En Proceso</option>
                                <option value="resuelto" ${ticket.est_sop === 'resuelto' ? 'selected' : ''}>🟢 Resuelto</option>
                                <option value="cerrado" ${ticket.est_sop === 'cerrado' ? 'selected' : ''}>⚪ Cerrado</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="button" onclick="enviarRespuesta(${ticket.id})" 
                                    class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-medium">
                                📤 Enviar Respuesta
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    `;
    
    document.getElementById('verTicketModal').classList.remove('hidden');
    document.getElementById('verTicketModal').classList.add('flex');
}

function getCategoriaIcono(categoria) {
    const iconos = {
        'tecnico': '🔧',
        'cuenta': '👤',
        'mascota': '🐾',
        'pago': '💰',
        'otro': '📝'
    };
    return iconos[categoria] || '📌';
}

function getPrioridadIcono(prioridad) {
    const iconos = {
        'baja': '🟢',
        'media': '🟡',
        'alta': '🟠',
        'urgente': '🔴'
    };
    return iconos[prioridad] || '⚪';
}

function escapeHtml(text) {
    if(!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function enviarRespuesta(id) {
    const respuesta = document.getElementById('respuestaTexto').value;
    const estado = document.getElementById('estadoTicket').value;
    
    if(!respuesta.trim()) {
        alert('⚠️ Por favor escribe una respuesta antes de enviar');
        return;
    }
    
    fetch(`/admin/soporte/${id}/responder`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            respuesta: respuesta,
            estado: estado
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert('✅ Respuesta enviada correctamente');
            location.reload();
        } else {
            alert('❌ ' + (data.message || 'Error al enviar la respuesta'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error al enviar la respuesta');
    });
}

function eliminarTicket(id) {
    if(confirm('⚠️ ¿Estás seguro de eliminar este ticket? Esta acción no se puede deshacer.')) {
        fetch(`/admin/soporte/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert('❌ ' + (data.message || 'Error al eliminar el ticket'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('❌ Error al eliminar el ticket');
        });
    }
}

function cerrarModalTicket() {
    document.getElementById('verTicketModal').classList.add('hidden');
    document.getElementById('verTicketModal').classList.remove('flex');
}

window.onclick = function(event) {
    const modal = document.getElementById('verTicketModal');
    if (event.target === modal) {
        cerrarModalTicket();
    }
}
</script>
@endsection