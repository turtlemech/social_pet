@extends('layouts.soporte')

@section('title', 'Dashboard - Panel de Soporte')
@section('header', 'Panel de Control')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tickets Activos</p>
                    <p class="text-2xl font-bold text-gray-800">24</p>
                    <p class="text-green-600 text-sm mt-2">
                        <i class="fas fa-arrow-up"></i> 12% vs ayer
                    </p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-ticket-alt text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tickets Cerrados</p>
                    <p class="text-2xl font-bold text-gray-800">156</p>
                    <p class="text-green-600 text-sm mt-2">
                        <i class="fas fa-arrow-up"></i> 8% este mes
                    </p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tickets Urgentes</p>
                    <p class="text-2xl font-bold text-red-600">8</p>
                    <p class="text-red-600 text-sm mt-2">
                        <i class="fas fa-exclamation-triangle"></i> Requieren atención
                    </p>
                </div>
                <div class="bg-red-100 rounded-full p-3">
                    <i class="fas fa-exclamation text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Clientes Atendidos</p>
                    <p class="text-2xl font-bold text-gray-800">89</p>
                    <p class="text-green-600 text-sm mt-2">
                        <i class="fas fa-arrow-up"></i> 23% este mes
                    </p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tickets por Estado</h3>
            <canvas id="ticketsChart" height="200"></canvas>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tickets por Prioridad</h3>
            <canvas id="priorityChart" height="200"></canvas>
        </div>
    </div>
    
    <!-- Recent Tickets Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Tickets Recientes</h3>
            <button class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>Nuevo Ticket
            </button>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#T001</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Juan Pérez</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Problema con el sistema de facturación</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Alta
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                En proceso
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">2024-01-15</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-primary-600 hover:text-primary-800 mr-3">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-800">
                                <i class="fas fa-reply"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#T002</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">María López</td>
                        <td class="px-6 py-4 text-sm text-gray-600">No puedo acceder a mi cuenta</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Urgente
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                Abierto
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">2024-01-15</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-primary-600 hover:text-primary-800 mr-3">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-800">
                                <i class="fas fa-reply"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#T003</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Carlos Rodríguez</td>
                        <td class="px-6 py-4 text-sm text-gray-600">Solicitud de información de productos</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Baja
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Cerrado
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">2024-01-14</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-primary-600 hover:text-primary-800 mr-3">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-green-600 hover:text-green-800">
                                <i class="fas fa-reply"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            <button class="text-primary-600 hover:text-primary-800 text-sm font-medium">
                Ver todos los tickets <i class="fas fa-arrow-right ml-1"></i>
            </button>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <i class="fas fa-headset text-3xl"></i>
                <i class="fas fa-chevron-right"></i>
            </div>
            <h3 class="text-xl font-bold mb-2">Atención al Cliente</h3>
            <p class="text-blue-100 mb-4">Gestiona las consultas de los clientes</p>
            <button class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors">
                Ir a Chat
            </button>
        </div>
        
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <i class="fas fa-chart-line text-3xl"></i>
                <i class="fas fa-chevron-right"></i>
            </div>
            <h3 class="text-xl font-bold mb-2">Reportes</h3>
            <p class="text-green-100 mb-4">Visualiza estadísticas y métricas</p>
            <button class="bg-white text-green-600 px-4 py-2 rounded-lg hover:bg-green-50 transition-colors">
                Generar Reporte
            </button>
        </div>
        
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <i class="fas fa-database text-3xl"></i>
                <i class="fas fa-chevron-right"></i>
            </div>
            <h3 class="text-xl font-bold mb-2">Base de Conocimiento</h3>
            <p class="text-purple-100 mb-4">Accede a documentación y guías</p>
            <button class="bg-white text-purple-600 px-4 py-2 rounded-lg hover:bg-purple-50 transition-colors">
                Ver Documentación
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tickets by status chart
    const ctx1 = document.getElementById('ticketsChart').getContext('2d');
    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Abiertos', 'En Proceso', 'Cerrados'],
            datasets: [{
                data: [45, 30, 25],
                backgroundColor: ['#3b82f6', '#f59e0b', '#10b981'],
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
    
    // Tickets by priority chart
    const ctx2 = document.getElementById('priorityChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Alta', 'Media', 'Baja', 'Urgente'],
            datasets: [{
                label: 'Cantidad de Tickets',
                data: [12, 19, 7, 8],
                backgroundColor: ['#ef4444', '#f59e0b', '#10b981', '#dc2626'],
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
</script>
@endpush