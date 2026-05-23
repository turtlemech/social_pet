@extends('layouts.admin')

@section('title', 'administracion de Soporte')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Gestión de Soporte</h1>
        <p class="text-gray-600 mt-2">Gestiona los tickets de soporte de los usuarios</p>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-r-lg flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-r-lg flex items-center justify-between">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-700 font-bold">&times;</button>
        </div>
    @endif

    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Tickets</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $estadisticas['total'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Abiertos/En Proceso</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $estadisticas['abiertos'] + $estadisticas['en_proceso'] }}</p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Resueltos</p>
                    <p class="text-3xl font-bold text-green-600">{{ $estadisticas['resueltos'] }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Urgentes</p>
                    <p class="text-3xl font-bold text-red-600">{{ $estadisticas['urgentes'] }}</p>
                </div>
                <div class="bg-red-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-sm p-4">
        <form method="GET" action="{{ route('admin.soporte.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por código, asunto o usuario..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            </div>
            
            <select name="categoria" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                <option value="">Todas las categorías</option>
                <option value="tecnico" {{ request('categoria') == 'tecnico' ? 'selected' : '' }}>🔧 Técnico</option>
                <option value="cuenta" {{ request('categoria') == 'cuenta' ? 'selected' : '' }}>👤 Cuenta</option>
                <option value="mascota" {{ request('categoria') == 'mascota' ? 'selected' : '' }}>🐾 Mascota</option>
                <option value="pago" {{ request('categoria') == 'pago' ? 'selected' : '' }}>💰 Pago</option>
                <option value="otro" {{ request('categoria') == 'otro' ? 'selected' : '' }}>📝 Otro</option>
            </select>
            
            <select name="estado" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                <option value="">Todos los estados</option>
                <option value="abierto" {{ request('estado') == 'abierto' ? 'selected' : '' }}>🟡 Abierto</option>
                <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>🔵 En Proceso</option>
                <option value="resuelto" {{ request('estado') == 'resuelto' ? 'selected' : '' }}>🟢 Resuelto</option>
                <option value="cerrado" {{ request('estado') == 'cerrado' ? 'selected' : '' }}>⚪ Cerrado</option>
            </select>
            
            <select name="prioridad" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                <option value="">Todas las prioridades</option>
                <option value="baja" {{ request('prioridad') == 'baja' ? 'selected' : '' }}>🟢 Baja</option>
                <option value="media" {{ request('prioridad') == 'media' ? 'selected' : '' }}>🟡 Media</option>
                <option value="alta" {{ request('prioridad') == 'alta' ? 'selected' : '' }}>🟠 Alta</option>
                <option value="urgente" {{ request('prioridad') == 'urgente' ? 'selected' : '' }}>🔴 Urgente</option>
            </select>
            
            <div class="md:col-span-4 flex justify-end">
                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                    Aplicar Filtros
                </button>
                @if(request()->anyFilled(['search', 'categoria', 'estado', 'prioridad']))
                    <a href="{{ route('admin.soporte.index') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        Limpiar
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-gray-900">{{ $ticket->cod_sop }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $ticket->usuario->nom_us ?? 'N/A' }} {{ $ticket->usuario->app_us ?? '' }}</div>
                                <div class="text-xs text-gray-500">{{ $ticket->usuario->cod_us ?? 'N/A' }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">{{ $ticket->asu_sop }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                {{ ucfirst($ticket->cat_sop) }}
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
                            <span class="px-2 py-1 text-xs rounded-full {{ $prioridadClases[$ticket->pri_sop] ?? 'bg-gray-100' }}">
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
                            <span class="px-2 py-1 text-xs rounded-full {{ $estadoClases[$ticket->est_sop] ?? 'bg-gray-100' }}">
                                {{ $estadoIconos[$ticket->est_sop] ?? '' }} {{ ucfirst(str_replace('_', ' ', $ticket->est_sop)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="verTicket('{{ $ticket->id }}')" class="text-blue-600 hover:text-blue-900 mr-3">
                                Ver
                            </button>
                            <button onclick="eliminarTicket('{{ $ticket->id }}')" class="text-red-600 hover:text-red-900">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p>No hay tickets de soporte</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($tickets->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $tickets->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Ver Ticket -->
<div id="verTicketModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800">Detalles del Ticket</h3>
            <button onclick="cerrarModalTicket()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <div id="modalTicketBody" class="p-6"></div>
    </div>
</div>

<script>
const csrfToken = '{{ csrf_token() }}';

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
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Código</p>
                        <p class="font-mono font-medium text-gray-900">${ticket.cod_sop}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Categoría</p>
                        <p class="capitalize">${ticket.cat_sop}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Prioridad</p>
                        <p class="capitalize font-semibold ${ticket.pri_sop === 'urgente' ? 'text-red-600' : ''}">${ticket.pri_sop}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Fecha</p>
                        <p>${new Date(ticket.created_at).toLocaleString()}</p>
                    </div>
                </div>
            </div>
            
            <!-- Información del Usuario -->
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Información del Usuario</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Nombre</p>
                        <p class="font-medium">${ticket.usuario?.nom_us || 'N/A'} ${ticket.usuario?.app_us || ''}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Código</p>
                        <p class="font-mono">${ticket.usuario?.cod_us || 'N/A'}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Email</p>
                        <p>${ticket.usuario?.email || 'N/A'}</p>
                    </div>
                </div>
            </div>
            
            <!-- Asunto y Mensaje -->
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Asunto</h4>
                <p class="text-gray-900 mb-4">${escapeHtml(ticket.asu_sop)}</p>
                
                <h4 class="font-semibold text-gray-800 mb-3">Mensaje</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 whitespace-pre-wrap">${escapeHtml(ticket.men_sop)}</p>
                </div>
            </div>
            
            ${ticket.res_sop ? `
            <!-- Respuesta Actual -->
            <div class="border rounded-lg p-4 bg-green-50">
                <h4 class="font-semibold text-gray-800 mb-3">Respuesta del Administrador</h4>
                <div class="bg-white rounded-lg p-4">
                    <p class="text-gray-700 whitespace-pre-wrap">${escapeHtml(ticket.res_sop)}</p>
                </div>
                <div class="mt-2 text-xs text-gray-500">
                    Respondido por: ${ticket.administrador?.nom_us || 'Admin'} ${ticket.administrador?.app_us || ''}
                    ${ticket.fec_resuelto ? ` - ${new Date(ticket.fec_resuelto).toLocaleString()}` : ''}
                </div>
            </div>
            ` : ''}
            
            ${ticketsRelacionados && ticketsRelacionados.length > 0 ? `
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Tickets anteriores del mismo usuario</h4>
                <div class="space-y-2">
                    ${ticketsRelacionados.map(t => `
                        <div class="bg-gray-50 rounded p-3 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="font-mono font-medium">${t.cod_sop}</span>
                                <span class="px-2 py-1 text-xs rounded-full ${estadoClases[t.est_sop]}">${t.est_sop}</span>
                            </div>
                            <p class="text-gray-600 mt-1">${escapeHtml(t.asu_sop)}</p>
                            <p class="text-xs text-gray-500 mt-1">${new Date(t.created_at).toLocaleDateString()}</p>
                        </div>
                    `).join('')}
                </div>
            </div>
            ` : ''}
            
            <!-- Formulario de Respuesta -->
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Responder Ticket</h4>
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
                                    class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                                Enviar Respuesta
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
        alert('Por favor escribe una respuesta');
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
            alert('Respuesta enviada correctamente');
            location.reload();
        } else {
            alert(data.message || 'Error al enviar la respuesta');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al enviar la respuesta');
    });
}

function eliminarTicket(id) {
    if(confirm('¿Estás seguro de eliminar este ticket? Esta acción no se puede deshacer.')) {
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
                alert(data.message || 'Error al eliminar el ticket');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar el ticket');
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