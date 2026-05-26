@extends('layouts.admin')

@section('title', 'administracion de Usuarios - Social Pet')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h1>
            <p class="text-gray-600 mt-1">Administra todos los usuarios de la plataforma</p>
        </div>
        <button onclick="window.location.reload()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
            <i class="fas fa-sync-alt"></i> Actualizar
        </button>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90">Total Usuarios</p>
            <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90">Activos</p>
            <p class="text-2xl font-bold">{{ $stats['activos'] }}</p>
        </div>
        <div class="bg-gradient-to-r from-gray-500 to-gray-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90">Inactivos</p>
            <p class="text-2xl font-bold">{{ $stats['inactivos'] }}</p>
        </div>
        <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90">Baneados</p>
            <p class="text-2xl font-bold">{{ $stats['baneados'] }}</p>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90">Administradores</p>
            <p class="text-2xl font-bold">{{ $stats['admins'] }}</p>
        </div>
    </div>
    
    <!-- Filtros y Búsqueda -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('admin.usuarios.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ $search }}" 
                       placeholder="Buscar por nombre, email o código..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
            </div>
            <div class="w-48">
                <select name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    <option value="">Todos los estados</option>
                    <option value="activo" {{ $estado == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ $estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    <option value="baneado" {{ $estado == 'baneado' ? 'selected' : '' }}>Baneado</option>
                </select>
            </div>
            <div class="w-48">
                <select name="rol" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    <option value="">Todos los roles</option>
                    <option value="admin" {{ $rol == 'admin' ? 'selected' : '' }}>Administradores</option>
                    <option value="user" {{ $rol == 'user' ? 'selected' : '' }}>Usuarios normales</option>
                </select>
            </div>
            <!-- Campos ocultos para mantener el ordenamiento -->
            <input type="hidden" name="sort" value="{{ $sortField ?? 'codigo' }}">
            <input type="hidden" name="direction" value="{{ $sortDirection ?? 'desc' }}">
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                    <i class="fas fa-search"></i> Buscar
                </button>
                @if($search || $estado || $rol)
                <a href="{{ route('admin.usuarios.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-times"></i> Limpiar
                </a>
                @endif
            </div>
        </form>
    </div>
    
    <!-- Tabla de Usuarios con Ordenamiento -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition group">
                        <a href="{{ route('admin.usuarios.index', array_merge(request()->query(), ['sort' => 'codigo', 'direction' => ($sortField == 'codigo' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2">
                            Código
                            @if($sortField == 'codigo')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 opacity-0 group-hover:opacity-100 transition"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition group">
                        <a href="{{ route('admin.usuarios.index', array_merge(request()->query(), ['sort' => 'nombre', 'direction' => ($sortField == 'nombre' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2">
                            Nombre Completo
                            @if($sortField == 'nombre')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 opacity-0 group-hover:opacity-100 transition"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition group">
                        <a href="{{ route('admin.usuarios.index', array_merge(request()->query(), ['sort' => 'email', 'direction' => ($sortField == 'email' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2">
                            Email
                            @if($sortField == 'email')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 opacity-0 group-hover:opacity-100 transition"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition group">
                        <a href="{{ route('admin.usuarios.index', array_merge(request()->query(), ['sort' => 'telefono', 'direction' => ($sortField == 'telefono' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2">
                            Teléfono
                            @if($sortField == 'telefono')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 opacity-0 group-hover:opacity-100 transition"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition group">
                        <a href="{{ route('admin.usuarios.index', array_merge(request()->query(), ['sort' => 'rol', 'direction' => ($sortField == 'rol' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2">
                            Rol
                            @if($sortField == 'rol')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 opacity-0 group-hover:opacity-100 transition"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition group">
                        <a href="{{ route('admin.usuarios.index', array_merge(request()->query(), ['sort' => 'estado', 'direction' => ($sortField == 'estado' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2">
                            Estado
                            @if($sortField == 'estado')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 opacity-0 group-hover:opacity-100 transition"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition group">
                        <a href="{{ route('admin.usuarios.index', array_merge(request()->query(), ['sort' => 'registro', 'direction' => ($sortField == 'registro' && $sortDirection == 'asc') ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2">
                            Registro
                            @if($sortField == 'registro')
                                <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 opacity-0 group-hover:opacity-100 transition"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($usuarios as $usuario)
                <tr class="hover:bg-gray-50 transition" id="usuario-{{ $usuario->id }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">{{ $usuario->cod_us }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $usuario->nom_us }} {{ $usuario->app_us }} {{ $usuario->apm_us }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $usuario->ema_us }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $usuario->tel_us ?? 'No registrado' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($usuario->is_admin)
                            <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">Administrador</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Usuario</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap" id="estado-{{ $usuario->id }}">
                        @php
                            $estadoColors = [
                                'activo' => 'bg-green-100 text-green-800',
                                'inactivo' => 'bg-gray-100 text-gray-800',
                                'baneado' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $estadoColors[$usuario->est_us] }}">
                            {{ ucfirst($usuario->est_us) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $usuario->created_at ? $usuario->created_at->format('d/m/Y') : 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex items-center gap-2">
                            @if(!$usuario->is_admin)
                                <!-- Botón para recuperar contraseña -->
                                <button type="button" onclick="recuperarContrasena('{{ $usuario->id }}', '{{ addslashes($usuario->nom_us) }}', '{{ addslashes($usuario->app_us) }}')"
                                        class="text-blue-600 hover:text-blue-800 transition" 
                                        title="Restablecer contraseña">
                                    <i class="fas fa-key"></i>
                                </button>
                                
                                @if($usuario->est_us == 'activo')
                                    <button type="button" onclick="cambiarEstado('{{ $usuario->id }}', 'inactivo')" 
                                            class="text-orange-600 hover:text-orange-800 transition" 
                                            title="Desactivar usuario">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                    <button type="button" onclick="cambiarEstado('{{ $usuario->id }}', 'baneado')"
                                            class="text-red-600 hover:text-red-800 transition" 
                                            title="Banear usuario">
                                        <i class="fas fa-gavel"></i>
                                    </button>
                                @elseif($usuario->est_us == 'inactivo')
                                    <button type="button" onclick="cambiarEstado('{{ $usuario->id }}', 'activo')" 
                                            class="text-green-600 hover:text-green-800 transition" 
                                            title="Activar usuario">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                    <button type="button" onclick="cambiarEstado('{{ $usuario->id }}', 'baneado')"
                                            class="text-red-600 hover:text-red-800 transition" 
                                            title="Banear usuario">
                                        <i class="fas fa-gavel"></i>
                                    </button>
                                @elseif($usuario->est_us == 'baneado')
                                    <button type="button" onclick="cambiarEstado('{{ $usuario->id }}', 'activo')" 
                                            class="text-green-600 hover:text-green-800 transition" 
                                            title="Desbanear usuario">
                                        <i class="fas fa-unlock-alt"></i>
                                    </button>
                                @endif
                            @else
                                <span class="text-gray-400 text-xs">
                                    <i class="fas fa-shield-alt"></i> Protegido
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-users-slash text-4xl mb-2 block"></i>
                        No se encontraron usuarios
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginación -->
    <div class="mt-6">
        {{ $usuarios->appends(request()->query())->links() }}
    </div>
</div>

<!-- SweetAlert2 CSS y JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Función para depuración
console.log('Script cargado correctamente');

function cambiarEstado(id, nuevoEstado) {
    console.log('cambiarEstado llamado:', id, nuevoEstado);
    
    let config = {
        title: '',
        text: '',
        icon: 'question',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
    };
    
    switch(nuevoEstado) {
        case 'activo':
            config.title = '¿Activar usuario?';
            config.text = 'Este usuario podrá acceder nuevamente a la plataforma.';
            config.icon = 'success';
            config.confirmButtonColor = '#10b981';
            break;
        case 'inactivo':
            config.title = '¿Desactivar usuario?';
            config.text = 'El usuario no podrá acceder a la plataforma. Podrá activarse después.';
            config.icon = 'warning';
            config.confirmButtonColor = '#f59e0b';
            break;
        case 'baneado':
            config.title = '¿Banear usuario?';
            config.text = 'El usuario será bloqueado permanentemente. ¿Estás seguro?';
            config.icon = 'error';
            config.confirmButtonColor = '#ef4444';
            break;
    }
    
    Swal.fire(config).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Procesando...',
                text: 'Por favor espera',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            fetch(`/admin/usuarios/${id}/cambiar-estado`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ estado: nuevoEstado })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta:', data);
                if (data.success) {
                    Swal.fire({
                        title: '¡Completado!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#f97316',
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'Ocurrió un error al cambiar el estado',
                        icon: 'error',
                        confirmButtonColor: '#f97316'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error de conexión al servidor. Verifica la consola.',
                    icon: 'error',
                    confirmButtonColor: '#f97316'
                });
            });
        }
    });
}

function recuperarContrasena(id, nombre, apellido) {
    console.log('recuperarContrasena llamado:', id, nombre, apellido);
    
    Swal.fire({
        title: 'Restablecer Contraseña',
        html: `
            <div class="text-left">
                <p class="mb-3">¿Estás seguro de restablecer la contraseña para <strong>${nombre} ${apellido}</strong>?</p>
                <p class="text-sm text-gray-500 mt-2">
                    <i class="fas fa-info-circle"></i> Se generará una nueva contraseña automáticamente.
                    El usuario recibirá un correo con la nueva contraseña.
                </p>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, restablecer contraseña',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#f97316',
        cancelButtonColor: '#d33',
        width: '500px'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Restableciendo...',
                text: 'Por favor espera',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading()
            });
            
            fetch(`/admin/usuarios/${id}/restablecer-contrasena`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                console.log('Respuesta:', data);
                if (data.success) {
                    Swal.fire({
                        title: '¡Contraseña restablecida!',
                        html: `
                            <p>${data.message}</p>
                            <p class="text-sm text-gray-500 mt-3">
                                <i class="fas fa-envelope"></i> 
                                La nueva contraseña ha sido enviada al correo del usuario.
                            </p>
                        `,
                        icon: 'success',
                        confirmButtonColor: '#f97316'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'Ocurrió un error al restablecer la contraseña',
                        icon: 'error',
                        confirmButtonColor: '#f97316'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error de conexión al servidor. Verifica la consola.',
                    icon: 'error',
                    confirmButtonColor: '#f97316'
                });
            });
        }
    });
}

function showToast(message, type = 'success') {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
    
    Toast.fire({
        icon: type,
        title: message
    });
}
</script>

<style>
.swal2-popup {
    font-size: 1rem !important;
    border-radius: 0.75rem !important;
}

.swal2-title {
    font-size: 1.5rem !important;
}

.swal2-confirm {
    background-color: #f97316 !important;
}

.swal2-confirm:hover {
    background-color: #ea580c !important;
}
</style>
@endsection





