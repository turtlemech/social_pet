{{-- resources/views/soporte/mis-tickets.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Mis Tickets de Soporte</h2>
                    <a href="{{ route('soporte.index') }}" 
                       class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition">
                        Nuevo Ticket
                    </a>
                </div>

                @if($tickets->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No tienes tickets</h3>
                        <p class="mt-1 text-sm text-gray-500">Comienza creando un nuevo ticket de soporte.</p>
                        <div class="mt-6">
                            <a href="{{ route('soporte.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700">
                                Crear Ticket
                            </a>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asunto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prioridad</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($tickets as $ticket)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-mono">{{ $ticket->cod_sop }}</td>
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
                                        <a href="{{ route('soporte.ver-ticket', $ticket->cod_sop) }}" 
                                           class="text-teal-600 hover:text-teal-900 font-medium">
                                            Ver Detalle
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection