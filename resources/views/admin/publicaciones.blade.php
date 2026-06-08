@extends('layouts.admin')

@section('title', 'Gestión de Publicaciones - Social Pet')

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Gestión de Publicaciones</h1>
            <p class="text-gray-600 mt-1">Administra todas las publicaciones de la plataforma</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.publicaciones.exportar') }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-download"></i> Exportar CSV
            </a>
            <button onclick="window.location.reload()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-8 gap-4 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90">Total</p>
            <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90">Activas</p>
            <p class="text-2xl font-bold">{{ $stats['activas'] }}</p>
        </div>
        <div class="bg-gradient-to-r from-gray-500 to-gray-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90">Inactivas</p>
            <p class="text-2xl font-bold">{{ $stats['inactivas'] }}</p>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90">Hoy</p>
            <p class="text-2xl font-bold">{{ $stats['hoy'] }}</p>
        </div>
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90">Este Mes</p>
            <p class="text-2xl font-bold">{{ $stats['este_mes'] }}</p>
        </div>
        <div class="bg-gradient-to-r from-pink-500 to-pink-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90">Con Música</p>
            <p class="text-2xl font-bold">{{ $stats['con_musica'] }}</p>
        </div>
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90">Con Ubicación</p>
            <p class="text-2xl font-bold">{{ $stats['con_ubicacion'] }}</p>
        </div>
        <div class="bg-gradient-to-r from-teal-500 to-teal-600 rounded-lg p-4 text-white">
            <p class="text-sm opacity-90">Esta Semana</p>
            <p class="text-2xl font-bold">{{ $stats['esta_semana'] }}</p>
        </div>
    </div>
    
    <!-- Filtros y Búsqueda -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <form method="GET" action="{{ route('admin.publicaciones.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Buscar por código, contenido o ubicación..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
            </div>
            <div class="w-40">
                <select name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    <option value="">Todos los estados</option>
                    <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            <div class="w-48">
                <select name="usuario_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    <option value="">Todos los usuarios</option>
                    @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ request('usuario_id') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->nom_us }} {{ $usuario->app_us }} ({{ $usuario->cod_us }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="w-48">
                <select name="mascota_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    <option value="">Todas las mascotas</option>
                    @foreach($mascotas as $mascota)
                    <option value="{{ $mascota->id }}" {{ request('mascota_id') == $mascota->id ? 'selected' : '' }}>
                        {{ $mascota->nom_mas }} ({{ $mascota->usuario->nom_us ?? 'Sin dueño' }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="w-36">
                <select name="con_musica" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    <option value="">Todos</option>
                    <option value="si" {{ request('con_musica') == 'si' ? 'selected' : '' }}>Con música</option>
                    <option value="no" {{ request('con_musica') == 'no' ? 'selected' : '' }}>Sin música</option>
                </select>
            </div>
            <div class="w-40">
                <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500"
                       placeholder="Desde">
            </div>
            <div class="w-40">
                <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500"
                       placeholder="Hasta">
            </div>
            <!-- Campos ocultos para mantener el ordenamiento -->
            <input type="hidden" name="sort" value="{{ request('sort', 'fecha') }}">
            <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                    <i class="fas fa-search"></i> Buscar
                </button>
                @if(request('search') || request('estado') || request('usuario_id') || request('mascota_id') || request('con_musica') || request('fecha_desde') || request('fecha_hasta'))
                <a href="{{ route('admin.publicaciones.index') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                    <i class="fas fa-times"></i> Limpiar
                </a>
                @endif
            </div>
        </form>
    </div>
    
    <!-- Tabla de Publicaciones -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition group">
                        <a href="{{ route('admin.publicaciones.index', array_merge(request()->query(), ['sort' => 'codigo', 'direction' => (request('sort') == 'codigo' && request('direction') == 'asc') ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2">
                            Código
                            @if(request('sort') == 'codigo')
                                <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 opacity-0 group-hover:opacity-100 transition"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contenido</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition group">
                        <a href="{{ route('admin.publicaciones.index', array_merge(request()->query(), ['sort' => 'usuario', 'direction' => (request('sort') == 'usuario' && request('direction') == 'asc') ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2">
                            Usuario
                            @if(request('sort') == 'usuario')
                                <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 opacity-0 group-hover:opacity-100 transition"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Multimedia</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition group">
                        <a href="{{ route('admin.publicaciones.index', array_merge(request()->query(), ['sort' => 'likes', 'direction' => (request('sort') == 'likes' && request('direction') == 'asc') ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2">
                            <i class="fas fa-heart"></i>
                            @if(request('sort') == 'likes')
                                <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 opacity-0 group-hover:opacity-100 transition"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition group">
                        <a href="{{ route('admin.publicaciones.index', array_merge(request()->query(), ['sort' => 'comentarios', 'direction' => (request('sort') == 'comentarios' && request('direction') == 'asc') ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2">
                            <i class="fas fa-comment"></i>
                            @if(request('sort') == 'comentarios')
                                <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 opacity-0 group-hover:opacity-100 transition"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition group">
                        <a href="{{ route('admin.publicaciones.index', array_merge(request()->query(), ['sort' => 'estado', 'direction' => (request('sort') == 'estado' && request('direction') == 'asc') ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2">
                            Estado
                            @if(request('sort') == 'estado')
                                <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 opacity-0 group-hover:opacity-100 transition"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition group">
                        <a href="{{ route('admin.publicaciones.index', array_merge(request()->query(), ['sort' => 'fecha', 'direction' => (request('sort') == 'fecha' && request('direction') == 'asc') ? 'desc' : 'asc'])) }}" 
                           class="flex items-center gap-2">
                            Fecha
                            @if(request('sort') == 'fecha')
                                <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }} text-orange-500"></i>
                            @else
                                <i class="fas fa-sort text-gray-400 opacity-0 group-hover:opacity-100 transition"></i>
                            @endif
                        </a>
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($publicaciones as $publicacion)
                <tr class="hover:bg-gray-50 transition" id="pub-{{ $publicacion->id }}">
                    <td class="px-4 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                        {{ $publicacion->cod_pub }}
                    </td>
                    <td class="px-4 py-4">
                        <div class="text-sm text-gray-900 max-w-md truncate">
                            {{ Str::limit($publicacion->com_pub ?? 'Sin contenido', 60) }}
                        </div>
                        @if($publicacion->ubicacion)
                        <div class="text-xs text-gray-400 mt-1">
                            <i class="fas fa-map-marker-alt"></i> {{ Str::limit($publicacion->ubicacion, 40) }}
                        </div>
                        @endif
                        @if($publicacion->musica)
                        <div class="text-xs text-gray-400 mt-1">
                            <i class="fas fa-music"></i> {{ $publicacion->musica }}
                            @if($publicacion->musica_artista) - {{ $publicacion->musica_artista }} @endif
                        </div>
                        @endif
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="text-sm">
                            <div class="font-medium text-gray-900">
                                {{ $publicacion->usuario->nom_us ?? 'N/A' }} {{ $publicacion->usuario->app_us ?? '' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $publicacion->usuario->cod_us ?? 'N/A' }}
                            </div>
                            @if($publicacion->mascota)
                            <div class="text-xs text-orange-600 mt-1">
                                <i class="fas fa-paw"></i> {{ $publicacion->mascota->nom_mas }}
                            </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            @php
                                $hasImages = false;
                                for($i = 1; $i <= 5; $i++) {
                                    $imgField = 'img_pub' . ($i == 1 ? '' : '_' . $i);
                                    if($publicacion->$imgField) $hasImages = true;
                                }
                            @endphp
                            @if($hasImages)
                                <button type="button" onclick="verImagenes('{{ $publicacion->id }}')"
                                        class="text-blue-600 hover:text-blue-800 transition" title="Ver imágenes">
                                    <i class="fas fa-images text-xl"></i>
                                </button>
                                <span class="text-xs text-gray-500">Sí</span>
                            @else
                                <span class="text-gray-400">
                                    <i class="fas fa-image text-xl"></i>
                                    <span class="text-xs">No</span>
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-heart text-red-500"></i>
                            <span class="font-medium">{{ $publicacion->likes_count ?? $publicacion->likes->count() }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-comment text-blue-500"></i>
                            <span class="font-medium">{{ $publicacion->comentarios_count ?? $publicacion->comentarios->count() }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap">
                        @if($publicacion->est_pub == 'activo')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check-circle"></i> Activo
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                <i class="fas fa-ban"></i> Inactivo
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $publicacion->created_at ? $publicacion->created_at->format('d/m/Y H:i') : 'N/A' }}
                        <div class="text-xs text-gray-400">
                            {{ $publicacion->created_at ? $publicacion->created_at->diffForHumans() : '' }}
                        </div>
                    </td>
                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="verPublicacion('{{ $publicacion->id }}')"
                                    class="text-blue-600 hover:text-blue-800 transition" 
                                    title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            
                            @if($publicacion->est_pub == 'activo')
                                <button type="button" onclick="cambiarEstado('{{ $publicacion->id }}', 'inactivo')" 
                                        class="text-orange-600 hover:text-orange-800 transition" 
                                        title="Desactivar publicación">
                                    <i class="fas fa-eye-slash"></i>
                                </button>
                            @else
                                <button type="button" onclick="cambiarEstado('{{ $publicacion->id }}', 'activo')" 
                                        class="text-green-600 hover:text-green-800 transition" 
                                        title="Activar publicación">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            @endif
                            
                            <button type="button" onclick="eliminarPublicacion('{{ $publicacion->id }}')"
                                    class="text-red-600 hover:text-red-800 transition" 
                                    title="Eliminar">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-newspaper text-4xl mb-2 block"></i>
                        No se encontraron publicaciones
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Paginación -->
    <div class="mt-6">
        {{ $publicaciones->appends(request()->query())->links() }}
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
console.log('Script de publicaciones cargado');

function verPublicacion(id) {
    fetch(`/admin/publicaciones/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const pub = data.publicacion;
                
                // Generar HTML de imágenes si hay
                let imagenesHtml = '';
                if (pub.imagenes && pub.imagenes.length > 0) {
                    imagenesHtml = `
                        <div class="mb-3">
                            <strong class="text-gray-700">Imágenes (${pub.cantidad_imagenes}):</strong>
                            <div class="grid grid-cols-${pub.imagenes.length > 1 ? '2' : '1'} gap-2 mt-2">
                    `;
                    pub.imagenes.forEach(img => {
                        imagenesHtml += `
                            <img src="${img}" class="w-full h-auto rounded-lg cursor-pointer" style="max-height: 200px;" onclick="window.open('${img}', '_blank')">
                        `;
                    });
                    imagenesHtml += `</div></div>`;
                }
                
                // HTML de música
                let musicaHtml = '';
                if (pub.musica) {
                    musicaHtml = `
                        <div class="mb-3">
                            <strong class="text-gray-700">Música:</strong>
                            <p class="text-gray-600">${pub.musica} ${pub.musica_artista ? '- ' + pub.musica_artista : ''}</p>
                            ${pub.musica_preview ? `<audio controls class="w-full mt-1"><source src="${pub.musica_preview}" type="audio/mpeg"></audio>` : ''}
                        </div>
                    `;
                }
                
                // HTML de ubicación
                let ubicacionHtml = '';
                if (pub.ubicacion) {
                    ubicacionHtml = `
                        <div class="mb-3">
                            <strong class="text-gray-700">Ubicación:</strong>
                            <p class="text-gray-600">${pub.ubicacion}</p>
                            ${pub.latitud && pub.longitud ? `<p class="text-xs text-gray-500">${pub.latitud}, ${pub.longitud}</p>` : ''}
                        </div>
                    `;
                }
                
                // HTML de comentarios
                let comentariosHtml = '';
                if (pub.comentarios && pub.comentarios.length > 0) {
                    comentariosHtml = `
                        <div class="mb-3">
                            <strong class="text-gray-700">Comentarios recientes (${pub.comentarios_count}):</strong>
                            <div class="mt-2 space-y-2 max-h-48 overflow-y-auto">
                    `;
                    pub.comentarios.forEach(com => {
                        comentariosHtml += `
                            <div class="bg-gray-50 p-2 rounded-lg">
                                <div class="text-sm font-medium text-gray-800">${com.usuario}</div>
                                <div class="text-sm text-gray-600">${com.contenido}</div>
                                <div class="text-xs text-gray-400">${com.created_at}</div>
                            </div>
                        `;
                    });
                    comentariosHtml += `</div></div>`;
                }
                
                Swal.fire({
                    title: 'Detalles de la Publicación',
                    html: `
                        <div class="text-left max-h-96 overflow-y-auto">
                            <div class="mb-3">
                                <strong class="text-gray-700">Código:</strong>
                                <p class="text-gray-600 font-mono">${pub.codigo}</p>
                            </div>
                            <div class="mb-3">
                                <strong class="text-gray-700">Contenido:</strong>
                                <p class="text-gray-600 mt-1 p-2 bg-gray-50 rounded-lg">${pub.contenido || 'Sin contenido'}</p>
                            </div>
                            ${imagenesHtml}
                            ${musicaHtml}
                            ${ubicacionHtml}
                            <div class="mb-3">
                                <strong class="text-gray-700">Usuario:</strong>
                                <p class="text-gray-600">${pub.usuario.nombre_completo}</p>
                                <p class="text-gray-500 text-sm">${pub.usuario.email} (${pub.usuario.codigo})</p>
                            </div>
                            ${pub.mascota ? `
                            <div class="mb-3">
                                <strong class="text-gray-700">Mascota:</strong>
                                <p class="text-gray-600">${pub.mascota.nombre} ${pub.mascota.especie ? '(' + pub.mascota.especie + ')' : ''}</p>
                            </div>
                            ` : ''}
                            <div class="mb-3">
                                <strong class="text-gray-700">Interacciones:</strong>
                                <p class="text-gray-600">
                                    <i class="fas fa-heart text-red-500"></i> ${pub.likes_count} likes · 
                                    <i class="fas fa-comment text-blue-500"></i> ${pub.comentarios_count} comentarios
                                </p>
                            </div>
                            <div class="mb-3">
                                <strong class="text-gray-700">Estado:</strong>
                                <p class="text-gray-600">
                                    <span class="px-2 py-1 text-xs rounded-full ${pub.estado === 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                                        ${pub.estado === 'activo' ? 'Activo' : 'Inactivo'}
                                    </span>
                                </p>
                            </div>
                            ${comentariosHtml}
                            <div>
                                <strong class="text-gray-700">Fecha:</strong>
                                <p class="text-gray-600">${pub.fecha_creacion} (${pub.fecha_humana})</p>
                            </div>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonColor: '#f97316',
                    confirmButtonText: 'Cerrar',
                    width: '700px'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'No se pudo cargar la publicación', 'error');
        });
}

function verImagenes(id) {
    fetch(`/admin/publicaciones/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.publicacion.imagenes && data.publicacion.imagenes.length > 0) {
                let imagenesHtml = '<div class="grid grid-cols-1 gap-4">';
                data.publicacion.imagenes.forEach(img => {
                    imagenesHtml += `
                        <img src="${img}" class="w-full h-auto rounded-lg cursor-pointer" onclick="window.open('${img}', '_blank')">
                    `;
                });
                imagenesHtml += '</div>';
                
                Swal.fire({
                    title: `Imágenes (${data.publicacion.cantidad_imagenes})`,
                    html: imagenesHtml,
                    confirmButtonColor: '#f97316',
                    confirmButtonText: 'Cerrar',
                    width: '600px'
                });
            } else {
                Swal.fire('Sin imágenes', 'Esta publicación no tiene imágenes', 'info');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'No se pudieron cargar las imágenes', 'error');
        });
}

function cambiarEstado(id, nuevoEstado) {
    let config = {
        title: nuevoEstado === 'activo' ? '¿Activar publicación?' : '¿Desactivar publicación?',
        text: nuevoEstado === 'activo' ? 'Esta publicación será visible para todos los usuarios.' : 'Esta publicación dejará de ser visible.',
        icon: 'question',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar',
        showCancelButton: true,
        confirmButtonColor: nuevoEstado === 'activo' ? '#10b981' : '#f59e0b',
        cancelButtonColor: '#d33'
    };
    
    Swal.fire(config).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Procesando...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading()
            });
            
            fetch(`/admin/publicaciones/${id}/cambiar-estado`, {
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
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Error de conexión al servidor', 'error');
            });
        }
    });
}

function eliminarPublicacion(id) {
    Swal.fire({
        title: '¿Eliminar publicación?',
        text: 'Esta acción no se puede deshacer. La publicación, sus imágenes, comentarios y likes serán eliminados permanentemente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#d33'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Eliminando...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading()
            });
            
            fetch(`/admin/publicaciones/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Eliminada!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#f97316',
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Error de conexión al servidor', 'error');
            });
        }
    });
}
</script>

<style>
.swal2-popup {
    font-size: 1rem !important;
    border-radius: 0.75rem !important;
}
.swal2-confirm {
    background-color: #f97316 !important;
}
.swal2-confirm:hover {
    background-color: #ea580c !important;
}
.swal2-actions .swal2-confirm {
    background-color: #f97316 !important;
}
</style>
@endsection