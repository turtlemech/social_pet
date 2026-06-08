@extends('layouts.admin')

@section('title', 'Gestión de Tickets de Soporte - Social Pet')

@section('content')
<div class="space-y-6">
    <!-- Header con migas de pan -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-ticket-alt text-orange-500 mr-2"></i>Tickets de Soporte
            </h1>
            <p class="text-gray-600 mt-1">Gestiona, responde y da seguimiento a los tickets de los usuarios</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.soporte.exportar') }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-download"></i> Exportar
            </a>
            <button onclick="window.location.reload()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
        </div>
    </div>

    <!-- Alertas con animación -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg flex items-center justify-between animate-slide-down">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg flex items-center justify-between animate-slide-down">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-700 font-bold">&times;</button>
        </div>
    @endif

    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all cursor-pointer transform hover:scale-105" onclick="filtrarPorEstado('')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Tickets</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $estadisticas['total'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Todos los tickets</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-full p-3 shadow-lg">
                    <i class="fas fa-ticket-alt text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all cursor-pointer transform hover:scale-105" onclick="filtrarPorEstado('abierto')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Abiertos</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $estadisticas['abiertos'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Pendientes de atención</p>
                </div>
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full p-3 shadow-lg">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all cursor-pointer transform hover:scale-105" onclick="filtrarPorEstado('en_proceso')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">En Proceso</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $estadisticas['en_proceso'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Siendo atendidos</p>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-full p-3 shadow-lg">
                    <i class="fas fa-spinner fa-pulse text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all cursor-pointer transform hover:scale-105" onclick="filtrarPorEstado('resuelto')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Resueltos</p>
                    <p class="text-3xl font-bold text-green-600">{{ $estadisticas['resueltos'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Completados</p>
                </div>
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-full p-3 shadow-lg">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Segunda fila de estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Cerrados</p>
                    <p class="text-3xl font-bold text-gray-600">{{ $estadisticas['cerrados'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Archivados</p>
                </div>
                <div class="bg-gradient-to-br from-gray-500 to-gray-600 rounded-full p-3 shadow-lg">
                    <i class="fas fa-archive text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all cursor-pointer transform hover:scale-105" onclick="filtrarPorPrioridad('urgente')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">
                        <i class="fas fa-exclamation-triangle text-red-500"></i> Urgentes
                    </p>
                    <p class="text-3xl font-bold text-red-600">{{ $estadisticas['urgentes'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">Requieren atención inmediata</p>
                </div>
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-full p-3 shadow-lg animate-pulse">
                    <i class="fas fa-bell text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all cursor-pointer transform hover:scale-105" onclick="filtrarPorPrioridad('alta')">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">
                        <i class="fas fa-arrow-up text-orange-500"></i> Alta Prioridad
                    </p>
                    <p class="text-3xl font-bold text-orange-600">{{ $estadisticas['alta_prioridad'] ?? 0 }}</p>
                    <p class="text-xs text-gray-400 mt-1">Prioridad alta</p>
                </div>
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-full p-3 shadow-lg">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Tasa de Resolución</p>
                    <p class="text-3xl font-bold text-purple-600">
                        {{ $estadisticas['total'] > 0 ? round(($estadisticas['resueltos'] / $estadisticas['total']) * 100, 1) : 0 }}%
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Tickets resueltos</p>
                </div>
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-full p-3 shadow-lg">
                    <i class="fas fa-chart-pie text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-3 h-2 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full bg-purple-500 rounded-full transition-all duration-500" style="width: '{{ $estadisticas['total'] > 0 ? round(($estadisticas['resueltos'] / $estadisticas['total']) * 100) : 0 }}%'"></div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Tiempo Promedio</p>
                    <p class="text-3xl font-bold text-teal-600">
                        {{ $estadisticas['tiempo_promedio'] ?? 'N/A' }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Desde apertura</p>
                </div>
                <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-full p-3 shadow-lg">
                    <i class="fas fa-hourglass-half text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros Avanzados -->
    <div class="bg-white rounded-xl shadow-sm p-4">
        <form method="GET" action="{{ route('admin.soporte.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <div class="relative md:col-span-2">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
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
                    <i class="fas fa-filter"></i> Filtrar
                </button>
                @if(request()->anyFilled(['search', 'categoria', 'estado', 'prioridad']))
                    <a href="{{ route('admin.soporte.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-center">
                        <i class="fas fa-times"></i> Limpiar
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('admin.soporte.index', array_merge(request()->query(), ['sort' => 'codigo', 'direction' => (request('sort') == 'codigo' && request('direction') == 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center gap-1">
                                Código
                                @if(request('sort') == 'codigo')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ route('admin.soporte.index', array_merge(request()->query(), ['sort' => 'fecha', 'direction' => (request('sort') == 'fecha' && request('direction') == 'asc') ? 'desc' : 'asc'])) }}" class="flex items-center gap-1">
                                Fecha
                                @if(request('sort') == 'fecha')
                                    <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50 transition-all {{ $ticket->pri_sop == 'urgente' && $ticket->est_sop != 'resuelto' ? 'bg-red-50 border-l-4 border-red-500' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-bold text-gray-900">#{{ $ticket->cod_sop }}</span>
                            @if($ticket->created_at->diffInHours(now()) < 24 && $ticket->est_sop != 'resuelto')
                                <span class="ml-2 px-1.5 py-0.5 text-xs bg-red-100 text-red-600 rounded-full animate-pulse">Nuevo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-gradient-to-r from-orange-400 to-orange-600 flex items-center justify-center text-white text-sm font-bold shadow">
                                    {{ strtoupper(substr($ticket->usuario->nom_us ?? 'U', 0, 1)) }}
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $ticket->usuario->nom_us ?? 'N/A' }} {{ $ticket->usuario->app_us ?? '' }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ $ticket->usuario->cod_us ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate font-semibold">{{ $ticket->asu_sop }}</div>
                            <div class="text-xs text-gray-500 truncate">{{ Str::limit($ticket->men_sop, 60) }}</div>
                            @if($ticket->res_sop)
                                <div class="text-xs text-green-600 mt-1">
                                    <i class="fas fa-reply"></i> Respondido
                                </div>
                            @endif
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
                                    'urgente' => 'bg-red-100 text-red-800',
                                ];
                                $prioridadIconos = [
                                    'baja' => '🟢',
                                    'media' => '🟡',
                                    'alta' => '🟠',
                                    'urgente' => '🔴',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full font-semibold {{ $prioridadClases[$ticket->pri_sop] ?? 'bg-gray-100' }}">
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
                            <span class="px-2 py-1 text-xs rounded-full font-semibold {{ $estadoClases[$ticket->est_sop] ?? 'bg-gray-100' }}">
                                {{ $estadoIconos[$ticket->est_sop] ?? '' }} {{ ucfirst(str_replace('_', ' ', $ticket->est_sop)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>{{ $ticket->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs">{{ $ticket->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="verTicket('{{ $ticket->id }}')" 
                                        class="text-blue-600 hover:text-blue-900 transition-all hover:scale-110" 
                                        title="Ver Detalles">
                                    <i class="fas fa-eye text-lg"></i>
                                </button>
                                <button onclick="cambiarEstadoTicket('{{ $ticket->id }}', '{{ $ticket->est_sop }}')" 
                                        class="text-orange-600 hover:text-orange-900 transition-all hover:scale-110" 
                                        title="Cambiar Estado">
                                    <i class="fas fa-exchange-alt text-lg"></i>
                                </button>
                                <button onclick="eliminarTicket('{{ $ticket->id }}')" 
                                        class="text-red-600 hover:text-red-900 transition-all hover:scale-110" 
                                        title="Eliminar">
                                    <i class="fas fa-trash-alt text-lg"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-ticket-alt text-6xl mb-4 text-gray-300"></i>
                            <p class="font-medium text-lg">No hay tickets de soporte</p>
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

<!-- Modal Ver Ticket Mejorado -->
<div id="verTicketModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 transition-all duration-300">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-5xl mx-4 max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-95">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">
                <i class="fas fa-ticket-alt text-orange-500 mr-2"></i>Detalles del Ticket
            </h3>
            <button onclick="cerrarModalTicket()" class="text-gray-400 hover:text-gray-600 text-2xl transition-all hover:rotate-90">&times;</button>
        </div>
        <div id="modalTicketBody" class="p-6"></div>
        <div class="sticky bottom-0 bg-gray-50 border-t border-gray-200 px-6 py-4 flex justify-end">
            <button onclick="cerrarModalTicket()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                <i class="fas fa-times"></i> Cerrar
            </button>
        </div>
    </div>
</div>

<!-- Modal Cambiar Estado -->
<div id="cambiarEstadoModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 transform transition-all duration-300 scale-95">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800">
                <i class="fas fa-exchange-alt text-orange-500 mr-2"></i>Cambiar Estado
            </h3>
        </div>
        <div class="p-6">
            <p class="text-gray-600 mb-4">Selecciona el nuevo estado para este ticket:</p>
            <select id="nuevoEstadoTicket" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                <option value="abierto">🟡 Abierto</option>
                <option value="en_proceso">🔵 En Proceso</option>
                <option value="resuelto">🟢 Resuelto</option>
                <option value="cerrado">⚪ Cerrado</option>
            </select>
            <input type="hidden" id="ticketIdCambio">
        </div>
        <div class="px-6 py-4 border-t border-gray-200 flex justify-end gap-2">
            <button onclick="cerrarModalCambioEstado()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                Cancelar
            </button>
            <button onclick="confirmarCambioEstado()" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                <i class="fas fa-save"></i> Guardar Cambio
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const csrfToken = '{{ csrf_token() }}';
let currentTicketId = null;

function filtrarPorEstado(estado) {
    const url = new URL(window.location.href);
    if (estado) {
        url.searchParams.set('estado', estado);
    } else {
        url.searchParams.delete('estado');
    }
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

function filtrarPorPrioridad(prioridad) {
    const url = new URL(window.location.href);
    url.searchParams.set('prioridad', prioridad);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

function verTicket(id) {
    Swal.fire({
        title: 'Cargando...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });
    
    fetch(`/admin/soporte/${id}`)
        .then(response => response.json())
        .then(data => {
            Swal.close();
            if(data.success) {
                mostrarModalTicket(data.ticket, data.tickets_relacionados);
            } else {
                Swal.fire('Error', 'No se pudo cargar el ticket', 'error');
            }
        })
        .catch(error => {
            Swal.close();
            console.error('Error:', error);
            Swal.fire('Error', 'Error al cargar el ticket', 'error');
        });
}

function mostrarModalTicket(ticket, ticketsRelacionados) {
    const modalBody = document.getElementById('modalTicketBody');
    
    modalBody.innerHTML = `
        <div class="space-y-6">
            <!-- Información del Ticket -->
            <div class="bg-gradient-to-r from-gray-50 to-white rounded-lg p-5 border">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Código</p>
                        <p class="font-mono font-bold text-gray-900 text-xl">${ticket.cod_sop}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Categoría</p>
                        <p class="font-medium">${getCategoriaIcono(ticket.cat_sop)} ${ticket.cat_sop}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Prioridad</p>
                        <p class="font-semibold ${ticket.pri_sop === 'urgente' ? 'text-red-600 animate-pulse' : ''}">${getPrioridadIcono(ticket.pri_sop)} ${ticket.pri_sop}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-semibold">Fecha</p>
                        <p class="font-medium">${new Date(ticket.created_at).toLocaleString()}</p>
                    </div>
                </div>
            </div>
            
            <!-- Información del Usuario -->
            <div class="border rounded-lg p-5 hover:shadow-md transition">
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-user-circle text-gray-600 mr-2"></i>
                    Información del Usuario
                </h4>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
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
                        <p class="text-sm">${ticket.usuario?.email || 'N/A'}</p>
                    </div>
                </div>
            </div>
            
            <!-- Asunto y Mensaje -->
            <div class="border rounded-lg p-5 hover:shadow-md transition">
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-heading text-gray-600 mr-2"></i>
                    Asunto
                </h4>
                <p class="text-gray-900 font-semibold mb-4 p-3 bg-blue-50 rounded-lg">${escapeHtml(ticket.asu_sop)}</p>
                
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-comment-dots text-gray-600 mr-2"></i>
                    Mensaje
                </h4>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">${escapeHtml(ticket.men_sop)}</p>
                </div>
            </div>
            
            ${ticket.res_sop ? `
            <div class="border rounded-lg p-5 bg-gradient-to-r from-green-50 to-white hover:shadow-md transition">
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-reply-all text-green-600 mr-2"></i>
                    Respuesta del Administrador
                </h4>
                <div class="bg-white rounded-lg p-4 border border-green-200">
                    <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">${escapeHtml(ticket.res_sop)}</p>
                </div>
                <div class="mt-3 text-xs text-gray-500 flex items-center gap-4 pt-2 border-t border-gray-200">
                    <span><i class="fas fa-user-shield"></i> Respondido por: ${ticket.administrador?.nom_us || 'Admin'} ${ticket.administrador?.app_us || ''}</span>
                    ${ticket.fec_resuelto ? `<span><i class="fas fa-calendar-check"></i> ${new Date(ticket.fec_resuelto).toLocaleString()}</span>` : ''}
                </div>
            </div>
            ` : ''}
            
            ${ticketsRelacionados && ticketsRelacionados.length > 0 ? `
            <div class="border rounded-lg p-5 hover:shadow-md transition">
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-history text-gray-600 mr-2"></i>
                    Tickets anteriores del mismo usuario (${ticketsRelacionados.length})
                </h4>
                <div class="space-y-2 max-h-64 overflow-y-auto">
                    ${ticketsRelacionados.map(t => `
                        <div class="bg-gray-50 rounded-lg p-3 text-sm hover:bg-gray-100 transition cursor-pointer border border-gray-200" onclick="verTicket(${t.id})">
                            <div class="flex justify-between items-center">
                                <span class="font-mono font-bold text-blue-600">#${t.cod_sop}</span>
                                <span class="px-2 py-1 text-xs rounded-full ${getEstadoClase(t.est_sop)}">${getEstadoIcono(t.est_sop)} ${t.est_sop}</span>
                            </div>
                            <p class="text-gray-700 mt-2 font-medium">${escapeHtml(t.asu_sop)}</p>
                            <p class="text-xs text-gray-500 mt-1"><i class="far fa-calendar-alt"></i> ${new Date(t.created_at).toLocaleDateString()}</p>
                        </div>
                    `).join('')}
                </div>
            </div>
            ` : ''}
            
            <!-- Formulario de Respuesta -->
            <div class="border rounded-lg p-5 bg-gradient-to-r from-orange-50 to-white">
                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-paper-plane text-orange-600 mr-2"></i>
                    Responder Ticket
                </h4>
                <form id="formRespuesta" onsubmit="return false;">
                    <textarea id="respuestaTexto" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition" 
                              placeholder="Escribe tu respuesta aquí..."></textarea>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tag"></i> Cambiar Estado
                            </label>
                            <select id="estadoTicket" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                <option value="abierto" ${ticket.est_sop === 'abierto' ? 'selected' : ''}>🟡 Abierto</option>
                                <option value="en_proceso" ${ticket.est_sop === 'en_proceso' ? 'selected' : ''}>🔵 En Proceso</option>
                                <option value="resuelto" ${ticket.est_sop === 'resuelto' ? 'selected' : ''}>🟢 Resuelto</option>
                                <option value="cerrado" ${ticket.est_sop === 'cerrado' ? 'selected' : ''}>⚪ Cerrado</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-flag"></i> Prioridad (Opcional)
                            </label>
                            <select id="prioridadTicket" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                <option value="">Sin cambios</option>
                                <option value="baja">🟢 Baja</option>
                                <option value="media">🟡 Media</option>
                                <option value="alta">🟠 Alta</option>
                                <option value="urgente">🔴 Urgente</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="button" onclick="enviarRespuesta(${ticket.id})" 
                                    class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-medium">
                                <i class="fas fa-paper-plane"></i> Enviar Respuesta
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

function getEstadoIcono(estado) {
    const iconos = {
        'abierto': '🟡',
        'en_proceso': '🔵',
        'resuelto': '🟢',
        'cerrado': '⚪'
    };
    return iconos[estado] || '🔄';
}

function getEstadoClase(estado) {
    const clases = {
        'abierto': 'bg-yellow-100 text-yellow-800',
        'en_proceso': 'bg-blue-100 text-blue-800',
        'resuelto': 'bg-green-100 text-green-800',
        'cerrado': 'bg-gray-100 text-gray-800'
    };
    return clases[estado] || 'bg-gray-100';
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
    const prioridad = document.getElementById('prioridadTicket').value;
    
    if(!respuesta.trim()) {
        Swal.fire('Advertencia', 'Por favor escribe una respuesta antes de enviar', 'warning');
        return;
    }
    
    Swal.fire({
        title: 'Enviando respuesta...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });
    
    fetch(`/admin/soporte/${id}/responder`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            respuesta: respuesta,
            estado: estado,
            prioridad: prioridad
        })
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();
        if(data.success) {
            Swal.fire({
                title: '¡Respuesta enviada!',
                text: 'La respuesta se ha enviado correctamente',
                icon: 'success',
                confirmButtonColor: '#f97316'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error', data.message || 'Error al enviar la respuesta', 'error');
        }
    })
    .catch(error => {
        Swal.close();
        console.error('Error:', error);
        Swal.fire('Error', 'Error al enviar la respuesta', 'error');
    });
}

function cambiarEstadoTicket(id, estadoActual) {
    currentTicketId = id;
    const select = document.getElementById('nuevoEstadoTicket');
    select.value = estadoActual;
    document.getElementById('cambiarEstadoModal').classList.remove('hidden');
    document.getElementById('cambiarEstadoModal').classList.add('flex');
}

function confirmarCambioEstado() {
    const nuevoEstado = document.getElementById('nuevoEstadoTicket').value;
    
    Swal.fire({
        title: 'Cambiando estado...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });
    
    fetch(`/admin/soporte/${currentTicketId}/cambiar-estado`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ estado: nuevoEstado })
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();
        if(data.success) {
            Swal.fire({
                title: 'Estado actualizado',
                text: 'El estado del ticket ha sido actualizado correctamente',
                icon: 'success',
                confirmButtonColor: '#f97316'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Error', data.message || 'Error al cambiar el estado', 'error');
        }
    })
    .catch(error => {
        Swal.close();
        console.error('Error:', error);
        Swal.fire('Error', 'Error al cambiar el estado', 'error');
    });
    
    cerrarModalCambioEstado();
}

function eliminarTicket(id) {
    Swal.fire({
        title: '¿Eliminar ticket?',
        text: 'Esta acción no se puede deshacer. El ticket será eliminado permanentemente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Eliminando...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
            
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
                    Swal.fire({
                        title: '¡Eliminado!',
                        text: 'El ticket ha sido eliminado correctamente',
                        icon: 'success',
                        confirmButtonColor: '#f97316'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message || 'Error al eliminar el ticket', 'error');
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire('Error', 'Error al eliminar el ticket', 'error');
            });
        }
    });
}

function cerrarModalTicket() {
    document.getElementById('verTicketModal').classList.add('hidden');
    document.getElementById('verTicketModal').classList.remove('flex');
}

function cerrarModalCambioEstado() {
    document.getElementById('cambiarEstadoModal').classList.add('hidden');
    document.getElementById('cambiarEstadoModal').classList.remove('flex');
    currentTicketId = null;
}

window.onclick = function(event) {
    const modalTicket = document.getElementById('verTicketModal');
    const modalEstado = document.getElementById('cambiarEstadoModal');
    if (event.target === modalTicket) {
        cerrarModalTicket();
    }
    if (event.target === modalEstado) {
        cerrarModalCambioEstado();
    }
}
</script>

<style>
@keyframes slide-down {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slide-down {
    animation: slide-down 0.3s ease-out;
}

.hover\\:scale-105:hover {
    transform: scale(1.05);
}

.hover\\:scale-110:hover {
    transform: scale(1.1);
}

.hover\\:rotate-90:hover {
    transform: rotate(90deg);
}

.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}
</style>
@endsection