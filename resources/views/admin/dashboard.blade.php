@extends('layouts.admin')

@section('title', 'Dashboard - Social Pet')

@section('content')
<!-- Header -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-orange-600 mb-2">Panel de Administración</h1>
            <p class="text-gray-600">Bienvenido, <strong class="text-gray-800">{{ auth()->user()->nom_us }}</strong></p>
        </div>
        <div>
            <a href="{{ route('admin.soporte.index') }}" 
               class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636L18.364 5.636m0 0a9 9 0 010 12.728M12 7.757v.01M12 12h.01M12 16.243v.01M12 4.757a9 9 0 00-9 9 9 9 0 009 9 9 9 0 009-9 9 9 0 00-9-9z"></path>
                </svg>
                Ir a Soporte
            </a>
        </div>
    </div>
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

<!-- Panel de Soporte - Tickets Pendientes -->
@php
    use App\Models\Soporte;
    $ticketsPendientes = Soporte::whereIn('est_sop', ['abierto', 'en_proceso'])->count();
    $ticketsUrgentes = Soporte::where('pri_sop', 'urgente')->whereIn('est_sop', ['abierto', 'en_proceso'])->count();
    $ticketsRecientes = Soporte::with(['usuario'])->orderBy('created_at', 'desc')->limit(5)->get();
@endphp

<div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-xl shadow-lg p-6 mb-6 text-white">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold mb-2 flex items-center gap-2">
                <span>🎫</span> Tickets de Soporte
            </h2>
            <p class="text-orange-100">Gestiona los tickets de soporte de los usuarios</p>
        </div>
        <div class="text-right">
            <div class="text-4xl font-bold">{{ $ticketsPendientes }}</div>
            <div class="text-sm text-orange-100">Tickets pendientes</div>
            @if($ticketsUrgentes > 0)
                <div class="mt-1 text-xs bg-red-600 rounded-full px-2 py-0.5 inline-block">
                    🔴 {{ $ticketsUrgentes }} urgentes
                </div>
            @endif
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('admin.soporte.index') }}" 
           class="inline-block px-6 py-2 bg-white text-orange-600 rounded-lg font-semibold hover:bg-orange-50 transition">
            Ver todos los tickets →
        </a>
    </div>
</div>

<!-- Últimos Tickets -->
@if($ticketsRecientes->count() > 0)
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
            <span>📋</span> Últimos Tickets de Soporte
        </h2>
        <a href="{{ route('admin.soporte.index') }}" class="text-orange-600 hover:text-orange-700 text-sm">
            Ver todos →
        </a>
    </div>
    
    <div class="space-y-3">
        @foreach($ticketsRecientes as $ticket)
        <div class="border border-gray-100 rounded-lg p-4 hover:bg-gray-50 transition">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="font-mono text-xs text-gray-500">{{ $ticket->cod_sop }}</span>
                        @php
                            $prioridadColors = [
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
                            $estadoColors = [
                                'abierto' => 'bg-yellow-100 text-yellow-800',
                                'en_proceso' => 'bg-blue-100 text-blue-800',
                                'resuelto' => 'bg-green-100 text-green-800',
                                'cerrado' => 'bg-gray-100 text-gray-800',
                            ];
                        @endphp
                        <span class="px-2 py-0.5 text-xs rounded-full {{ $prioridadColors[$ticket->pri_sop] ?? 'bg-gray-100' }}">
                            {{ $prioridadIconos[$ticket->pri_sop] ?? '' }} {{ ucfirst($ticket->pri_sop) }}
                        </span>
                        <span class="px-2 py-0.5 text-xs rounded-full {{ $estadoColors[$ticket->est_sop] ?? 'bg-gray-100' }}">
                            {{ ucfirst(str_replace('_', ' ', $ticket->est_sop)) }}
                        </span>
                    </div>
                    <h3 class="font-semibold text-gray-800">{{ $ticket->asu_sop }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($ticket->men_sop, 100) }}</p>
                    <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                        <span>👤 {{ $ticket->usuario->nom_us ?? 'N/A' }} {{ $ticket->usuario->app_us ?? '' }}</span>
                        <span>📅 {{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                <div class="ml-4">
                    <a href="{{ route('admin.soporte.index') }}" 
                       onclick="verTicket('{{ $ticket->id }}'); return false;"
                       class="px-3 py-1 text-sm bg-orange-100 text-orange-600 rounded-lg hover:bg-orange-200 transition">
                        Responder
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

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
        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
            <span class="text-gray-600">Tickets abiertos:</span>
            <span class="font-bold text-yellow-600">{{ Soporte::where('est_sop', 'abierto')->count() }}</span>
        </div>
        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
            <span class="text-gray-600">Tickets resueltos:</span>
            <span class="font-bold text-green-600">{{ Soporte::where('est_sop', 'resuelto')->count() }}</span>
        </div>
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
    // Verificar si el modal ya existe, si no, crearlo
    let modal = document.getElementById('verTicketModal');
    if(!modal) {
        modal = document.createElement('div');
        modal.id = 'verTicketModal';
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50';
        modal.innerHTML = `
            <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-xl font-bold text-gray-800">Detalles del Ticket</h3>
                    <button onclick="cerrarModalTicket()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                </div>
                <div id="modalTicketBody" class="p-6"></div>
            </div>
        `;
        document.body.appendChild(modal);
    }
    
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
            
            <div class="border rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Asunto</h4>
                <p class="text-gray-900 mb-4">${escapeHtml(ticket.asu_sop)}</p>
                
                <h4 class="font-semibold text-gray-800 mb-3">Mensaje</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 whitespace-pre-wrap">${escapeHtml(ticket.men_sop)}</p>
                </div>
            </div>
            
            ${ticket.res_sop ? `
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
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
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

function cerrarModalTicket() {
    const modal = document.getElementById('verTicketModal');
    if(modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}
</script>
@endsection