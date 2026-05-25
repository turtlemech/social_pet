@extends('layouts.admin')

@section('title', 'Dashboard - Social Pet')

@section('content')
<!-- Header con Saludo y Fecha -->
<div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 mb-6 text-white">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold mb-2">Panel de Administración</h1>
            <p class="text-orange-100">
                Bienvenido, <strong>{{ auth()->user()->nom_us }} {{ auth()->user()->app_us }}</strong>
            </p>
            <p class="text-orange-100 text-sm mt-1">
                <i class="far fa-calendar-alt mr-1"></i>{{ now()->format('l, d \de F \de Y') }}
            </p>
        </div>
        <div class="flex gap-3">
            @if(Route::has('admin.soporte.index'))
            <a href="{{ route('admin.soporte.index') }}" 
               class="px-5 py-2.5 bg-white text-orange-600 rounded-lg hover:bg-orange-50 transition flex items-center gap-2 font-semibold shadow-md">
                <i class="fas fa-headset"></i>
                Ir a Soporte
            </a>
            @endif
            <button onclick="window.location.reload()" 
                    class="px-4 py-2.5 bg-orange-700 text-white rounded-lg hover:bg-orange-800 transition">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Usuarios Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500 hover:shadow-md transition-all">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm mb-1">Total Usuarios</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalUsers ?? 0 }}</p>
                <p class="text-green-600 text-sm mt-2">
                    <i class="fas fa-arrow-up"></i> +{{ $newUsersThisMonth ?? 0 }} este mes
                </p>
            </div>
            <div class="bg-orange-100 rounded-full p-3">
                <i class="fas fa-users text-orange-600 text-2xl"></i>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <div class="flex justify-between text-xs">
                <span class="text-green-600">Activos: {{ $activeUsers ?? 0 }}</span>
                <span class="text-red-600">Inactivos: {{ $inactiveUsers ?? 0 }}</span>
                <span class="text-gray-600">Baneados: {{ $bannedUsers ?? 0 }}</span>
            </div>
        </div>
    </div>

    <!-- Mascotas Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition-all">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm mb-1">Total Mascotas</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalPets ?? 0 }}</p>
                <p class="text-blue-600 text-sm mt-2">
                    <i class="fas fa-paw"></i> {{ $usersWithPets ?? 0 }} dueños
                </p>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <i class="fas fa-dog text-blue-600 text-2xl"></i>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <div class="flex justify-between text-xs">
                <span class="text-blue-600">🐕 Perros: {{ $dogsCount ?? 0 }}</span>
                <span class="text-green-600">🐈 Gatos: {{ $catsCount ?? 0 }}</span>
                <span class="text-gray-600">Otros: {{ $otherPetsCount ?? 0 }}</span>
            </div>
        </div>
    </div>

    <!-- Publicaciones Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 hover:shadow-md transition-all">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm mb-1">Total Publicaciones</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalPublications ?? 0 }}</p>
                <p class="text-green-600 text-sm mt-2">
                    <i class="fas fa-clock"></i> {{ $publicationsToday ?? 0 }} hoy
                </p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-image text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Tickets Card -->
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500 hover:shadow-md transition-all">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm mb-1">Tickets Activos</p>
                <p class="text-3xl font-bold text-gray-800">{{ $pendingTickets ?? 0 }}</p>
            </div>
            <div class="bg-red-100 rounded-full p-3">
                <i class="fas fa-ticket-alt text-red-600 text-2xl"></i>
            </div>
        </div>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <div class="flex justify-between text-xs">
                <span class="text-yellow-600">Abiertos: {{ $openTickets ?? 0 }}</span>
                <span class="text-blue-600">Proceso: {{ $inProgressTickets ?? 0 }}</span>
                <span class="text-green-600">Resueltos: {{ $resolvedTickets ?? 0 }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Tickets por Estado -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-chart-pie text-orange-500 mr-2"></i>
                Tickets por Estado
            </h3>
        </div>
        <canvas id="ticketsEstadoChart" height="200"></canvas>
    </div>

    <!-- Tickets por Prioridad -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-exclamation-triangle text-orange-500 mr-2"></i>
                Tickets por Prioridad
            </h3>
        </div>
        <canvas id="ticketsPrioridadChart" height="200"></canvas>
    </div>
</div>

<!-- Tickets Recientes Section -->
<div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gradient-to-r from-gray-50 to-white">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-clock text-orange-500 mr-2"></i>
                Tickets Recientes
            </h3>
        </div>
        @if(Route::has('admin.soporte.index'))
        <a href="{{ route('admin.soporte.index') }}" 
           class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition flex items-center gap-2">
            <i class="fas fa-ticket-alt"></i>
            Gestionar Tickets
        </a>
        @endif
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridad</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentTickets ?? [] as $ticket)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $ticket->cod_sop ?? $ticket->id ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $ticket->usuario->nom_us ?? $ticket->nom_cliente ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500">{{ $ticket->usuario->ema_us ?? $ticket->email_cliente ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">{{ Str::limit($ticket->asu_sop ?? $ticket->asunto ?? '', 40) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $priorityColors = [
                                'baja' => 'bg-green-100 text-green-800',
                                'media' => 'bg-yellow-100 text-yellow-800',
                                'alta' => 'bg-orange-100 text-orange-800',
                                'urgente' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $priorityColors[$ticket->pri_sop ?? 'baja'] ?? 'bg-gray-100' }}">
                            {{ ucfirst($ticket->pri_sop ?? 'N/A') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusColors = [
                                'abierto' => 'bg-yellow-100 text-yellow-800',
                                'en_proceso' => 'bg-blue-100 text-blue-800',
                                'resuelto' => 'bg-green-100 text-green-800',
                                'cerrado' => 'bg-gray-100 text-gray-800',
                            ];
                        @endphp
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$ticket->est_sop ?? 'abierto'] ?? 'bg-gray-100' }}">
                            {{ ucfirst(str_replace('_', ' ', $ticket->est_sop ?? 'N/A')) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ isset($ticket->created_at) ? $ticket->created_at->format('d/m/Y H:i') : 'N/A' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-2 block"></i>
                        No hay tickets registrados
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Quick Actions Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition">
        <div class="flex items-center justify-between mb-4">
            <i class="fas fa-headset text-3xl"></i>
            <i class="fas fa-chevron-right text-orange-200"></i>
        </div>
        <h3 class="text-xl font-bold mb-2">Soporte al Cliente</h3>
        <p class="text-orange-100 mb-4">Gestiona tickets y responde consultas</p>
        @if(Route::has('admin.soporte.index'))
        <a href="{{ route('admin.soporte.index') }}" 
           class="inline-block bg-white text-orange-600 px-4 py-2 rounded-lg hover:bg-orange-50 transition font-semibold">
            Ir a Soporte
        </a>
        @endif
    </div>
    
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition">
        <div class="flex items-center justify-between mb-4">
            <i class="fas fa-chart-line text-3xl"></i>
            <i class="fas fa-chevron-right text-green-200"></i>
        </div>
        <h3 class="text-xl font-bold mb-2">Reportes</h3>
        <p class="text-green-100 mb-4">Visualiza estadísticas y métricas detalladas</p>
        @if(Route::has('admin.reports.index'))
        <a href="{{ route('admin.reports.index') }}" 
           class="inline-block bg-white text-green-600 px-4 py-2 rounded-lg hover:bg-green-50 transition font-semibold">
            Ver Reportes
        </a>
        @else
        <span class="inline-block bg-white text-green-600 px-4 py-2 rounded-lg opacity-50 cursor-not-allowed">
            Próximamente
        </span>
        @endif
    </div>
    
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white hover:shadow-xl transition">
        <div class="flex items-center justify-between mb-4">
            <i class="fas fa-users text-3xl"></i>
            <i class="fas fa-chevron-right text-purple-200"></i>
        </div>
        <h3 class="text-xl font-bold mb-2">Gestión de Usuarios</h3>
        <p class="text-purple-100 mb-4">Administra usuarios y sus mascotas</p>
        @if(Route::has('admin.usuarios.index'))
        <a href="{{ route('admin.usuarios.index') }}" 
           class="inline-block bg-white text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-50 transition font-semibold">
            Administrar
        </a>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de Tickets por Estado
    const ctxEstado = document.getElementById('ticketsEstadoChart');
    if (ctxEstado) {
        new Chart(ctxEstado.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Abiertos', 'En Proceso', 'Resueltos', 'Cerrados'],
                datasets: [{
                    data: [
                        {{ $openTickets ?? 0 }}, 
                        {{ $inProgressTickets ?? 0 }}, 
                        {{ $resolvedTickets ?? 0 }}, 
                        {{ $closedTickets ?? 0 }}
                    ],
                    backgroundColor: ['#eab308', '#3b82f6', '#10b981', '#6b7280'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Gráfico de Tickets por Prioridad
    const ctxPrioridad = document.getElementById('ticketsPrioridadChart');
    if (ctxPrioridad) {
        new Chart(ctxPrioridad.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Baja', 'Media', 'Alta', 'Urgente'],
                datasets: [{
                    label: 'Cantidad de Tickets',
                    data: [
                        {{ $lowPriorityTickets ?? 0 }},
                        {{ $mediumPriorityTickets ?? 0 }},
                        {{ $highPriorityTickets ?? 0 }},
                        {{ $urgentTickets ?? 0 }}
                    ],
                    backgroundColor: ['#10b981', '#eab308', '#f97316', '#ef4444'],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: '#e5e7eb'
                        },
                        title: {
                            display: true,
                            text: 'Número de Tickets'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
});
</script>
@endpush