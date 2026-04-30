{{-- resources/views/soporte/admin-dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Panel de Soporte</h2>
            <p class="text-gray-600">Gestiona los tickets de soporte de los usuarios</p>
        </div>

        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-2xl font-bold text-teal-600">{{ $stats['total'] }}</div>
                <div class="text-sm text-gray-600">Total Tickets</div>
            </div>
            <div class="bg-yellow-50 rounded-lg shadow p-4">
                <div class="text-2xl font-bold text-yellow-600">{{ $stats['abierto'] }}</div>
                <div class="text-sm text-gray-600">Abiertos</div>
            </div>
            <div class="bg-blue-50 rounded-lg shadow p-4">
                <div class="text-2xl font-bold text-blue-600">{{ $stats['en_proceso'] }}</div>
                <div class="text-sm text-gray-600">En Proceso</div>
            </div>
            <div class="bg-green-50 rounded-lg shadow p-4">
                <div class="text-2xl font-bold text-green-600">{{ $stats['resuelto'] }}</div>
                <div class="text-sm text-gray-600">Resueltos</div>
            </div>
            <div class="bg-red-50 rounded-lg shadow p-4">
                <div class="text-2xl font-bold text-red-600">{{ $stats['urgentes'] }}</div>
                <div class="text-sm text-gray-600">Urgentes</div>
            </div>
        </div>

        <!-- Tabla de Tickets -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if(session('success'))
                <div class="m-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asunto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prioridad</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                        <tr>
                            <td class="px-6 py-4 text-sm font-mono">{{ $ticket->cod_sop }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium">{{ $ticket->nom_us }} {{ $ticket->ape_us }}</div>
                                <div class="text-xs text-gray-500">{{ $ticket->ema_us }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $ticket->asu_sop }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($ticket->pri_sop == 'urgente') bg-red-100 text-red-800
                                    @elseif($ticket->pri_sop == 'alta') bg-orange-100 text-orange-800
                                    @elseif($ticket->pri_sop == 'media') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ ucfirst($ticket->pri_sop) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($ticket->est_sop == 'abierto') bg-yellow-100 text-yellow-800
                                    @elseif($ticket->est_sop == 'en_proceso') bg-blue-100 text-blue-800
                                    @elseif($ticket->est_sop == 'resuelto') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->est_sop)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <button onclick="openTicketModal({{ json_encode($ticket) }})" 
                                        class="text-teal-600 hover:text-teal-900 font-medium">
                                    Ver / Responder
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                No hay tickets para mostrar
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver/responder ticket -->
<div id="ticketModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold" id="modalTitle">Ticket</h3>
            <button onclick="closeTicketModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <div class="p-6">
            <form id="ticketForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="ticket_id" id="ticketId">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Código de Ticket</label>
                        <p class="mt-1 text-sm font-mono" id="ticketCode"></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="est_sop" id="ticketStatus" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="abierto">Abierto</option>
                            <option value="en_proceso">En Proceso</option>
                            <option value="resuelto">Resuelto</option>
                            <option value="cerrado">Cerrado</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mensaje del usuario</label>
                        <div class="mt-1 p-3 bg-gray-50 rounded-lg" id="userMessage"></div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Respuesta del administrador</label>
                        <textarea name="res_sop" id="adminResponse" rows="4" 
                                  class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg"
                                  placeholder="Escribe tu respuesta aquí..."></textarea>
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                            Guardar Cambios
                        </button>
                        <button type="button" onclick="closeTicketModal()" 
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                            Cancelar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openTicketModal(ticket) {
    document.getElementById('modalTitle').innerHTML = 'Ticket #' + ticket.cod_sop;
    document.getElementById('ticketCode').innerHTML = ticket.cod_sop;
    document.getElementById('ticketId').value = ticket.id;
    document.getElementById('ticketStatus').value = ticket.est_sop;
    document.getElementById('userMessage').innerHTML = ticket.men_sop;
    document.getElementById('adminResponse').value = ticket.res_sop || '';
    document.getElementById('ticketForm').action = '/soporte/admin/ticket/' + ticket.id;
    document.getElementById('ticketModal').classList.remove('hidden');
    document.getElementById('ticketModal').classList.add('flex');
}

function closeTicketModal() {
    document.getElementById('ticketModal').classList.add('hidden');
    document.getElementById('ticketModal').classList.remove('flex');
}
</script>
@endsection
