@extends('layouts.admin')

@section('title', 'administracion de Mascotas')

@section('content')
<div class="space-y-6">
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

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Administración de Mascotas</h1>
        <p class="text-gray-600 mt-2">Administra todas las mascotas registradas en la plataforma</p>
    </div>

    <!-- Tarjetas de Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Mascotas</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalPets ?? 0 }}</p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.586a1 1 0 00-.707.293l-2.828 2.828A1 1 0 006.586 7H5a2 2 0 00-2 2v3a2 2 0 002 2h4m6 0h.586a1 1 0 01.707.293l2.828 2.828A1 1 0 0118.414 21H17"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Perros</p>
                    <p class="text-3xl font-bold text-blue-600">{{ $dogsCount ?? 0 }}</p>
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
                    <p class="text-gray-500 text-sm">Gatos</p>
                    <p class="text-3xl font-bold text-green-600">{{ $catsCount ?? 0 }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.586a1 1 0 00-.707.293l-2.828 2.828A1 1 0 006.586 7H5a2 2 0 00-2 2v3a2 2 0 002 2h4m6 0h.586a1 1 0 01.707.293l2.828 2.828A1 1 0 0118.414 21H17"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Dueños Registrados</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $usersWithPets ?? 0 }}</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-xl shadow-sm p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" id="searchInput" placeholder="Buscar mascotas por nombre..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition">
            </div>
            
            <select id="typeFilter" 
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                <option value="">Todas las especies</option>
                @foreach($especies ?? [] as $especie)
                    <option value="{{ $especie->nom_esp }}">{{ $especie->nom_esp }}</option>
                @endforeach
            </select>
            
            <select id="ownerFilter" 
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                <option value="">Todos los dueños</option>
                @foreach($owners ?? [] as $owner)
                    <option value="{{ $owner->id }}">{{ $owner->nom_us }} {{ $owner->app_us ?? '' }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Grid de Mascotas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="petsGrid">
        @forelse($mascotas as $mascota)
        <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-lg transition-shadow duration-300 pet-card" 
             data-especie="{{ $mascota->especie->nom_esp ?? 'otro' }}" 
             data-owner="{{ $mascota->usuario_id }}" 
             data-nombre="{{ strtolower($mascota->nom_mas) }}">
            
            <!-- Imagen -->
            <div class="relative h-48 bg-gray-200">
                @if($mascota->fot_mas)
                    <img src="{{ asset('storage/' . $mascota->fot_mas) }}" alt="{{ $mascota->nom_mas }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                
                <!-- Badge de especie -->
                <div class="absolute top-2 right-2">
                    @php
                        $especieNombre = strtolower($mascota->especie->nom_esp ?? 'otro');
                    @endphp
                    @if($especieNombre == 'perro')
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-500 text-white">🐕 Perro</span>
                    @elseif($especieNombre == 'gato')
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500 text-white">🐱 Gato</span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-500 text-white">🐾 {{ $mascota->especie->nom_esp ?? 'Mascota' }}</span>
                    @endif
                </div>
            </div>
            
            <!-- Información -->
            <div class="p-4">
                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $mascota->nom_mas }}</h3>
                
                <div class="space-y-1 text-sm text-gray-600">
                    <p><span class="font-medium">Dueño:</span> {{ $mascota->usuario->nom_us ?? 'No especificado' }} {{ $mascota->usuario->app_us ?? '' }}</p>
                    <p><span class="font-medium">Especie:</span> {{ $mascota->especie->nom_esp ?? 'No especificada' }}</p>
                    <p><span class="font-medium">Sexo:</span> {{ $mascota->sex_mas == 'macho' ? '🐕 Macho' : ($mascota->sex_mas == 'hembra' ? '🐩 Hembra' : 'No especificado') }}</p>
                    @if($mascota->des_mas)
                        <p><span class="font-medium">Descripción:</span> {{ Str::limit($mascota->des_mas, 50) }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Acciones -->
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex space-x-2">
                <button onclick="viewPet('{{ $mascota->id }}')" 
                        class="flex-1 px-3 py-1.5 text-sm text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    👁️ Ver
                </button>
                <button onclick="editPet('{{ $mascota->id }}')" 
                        class="flex-1 px-3 py-1.5 text-sm text-yellow-600 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                    ✏️ Editar
                </button>
                <button onclick="deletePet('{{ $mascota->id }}')" 
                        class="flex-1 px-3 py-1.5 text-sm text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition">
                    🗑️ Eliminar
                </button>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-xl shadow-sm p-12 text-center text-gray-500">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p>No hay mascotas registradas</p>
        </div>
        @endforelse
    </div>

    @if(isset($mascotas) && method_exists($mascotas, 'links'))
        <div class="mt-6">
            {{ $mascotas->links() }}
        </div>
    @endif
</div>

<!-- Modal Ver Mascota -->
<div id="viewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Detalles de la Mascota</h3>
                <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            <div id="viewModalBody"></div>
        </div>
    </div>
</div>

<!-- Modal Editar Mascota -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Editar Mascota</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            </div>
            <form id="editPetForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="editPetId">
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
                    <input type="text" id="editNombre" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Especie</label>
                    <select id="editEspecieId" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                        @foreach($especies ?? [] as $especie)
                            <option value="{{ $especie->id }}">{{ $especie->nom_esp }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sexo</label>
                    <select id="editSexo" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                        <option value="">Seleccionar sexo</option>
                        <option value="macho">🐕 Macho</option>
                        <option value="hembra">🐩 Hembra</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                    <textarea id="editDescripcion" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none"></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Cancelar
                    </button>
                    <button type="button" onclick="savePet()" 
                            class="px-4 py-2 text-white bg-orange-600 rounded-lg hover:bg-orange-700 transition">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const csrfToken = '{{ csrf_token() }}';

    function filterPets() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const typeFilter = document.getElementById('typeFilter').value.toLowerCase();
        const ownerFilter = document.getElementById('ownerFilter').value;
        const cards = document.querySelectorAll('#petsGrid .pet-card');
        
        cards.forEach(card => {
            const nombre = card.getAttribute('data-nombre') || '';
            const especie = card.getAttribute('data-especie')?.toLowerCase() || '';
            const owner = card.getAttribute('data-owner');
            
            let show = true;
            if(searchTerm && !nombre.includes(searchTerm)) show = false;
            if(typeFilter && especie !== typeFilter && typeFilter !== '') show = false;
            if(ownerFilter && owner !== ownerFilter) show = false;
            
            card.style.display = show ? 'block' : 'none';
        });
    }

    document.getElementById('searchInput').addEventListener('keyup', filterPets);
    document.getElementById('typeFilter').addEventListener('change', filterPets);
    document.getElementById('ownerFilter').addEventListener('change', filterPets);

    function viewPet(id) {
        fetch(`/admin/mascotas/${id}`)
            .then(response => response.json())
            .then(data => {
                const modalBody = document.getElementById('viewModalBody');
                modalBody.innerHTML = `
                    <div class="space-y-4">
                        ${data.foto ? `
                            <div class="flex justify-center">
                                <img src="${data.foto}" alt="${data.nombre}" class="rounded-lg max-h-64 object-cover">
                            </div>
                        ` : `
                            <div class="bg-gray-100 rounded-lg p-8 text-center">
                                <svg class="w-20 h-20 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-500 mt-2">Sin foto disponible</p>
                            </div>
                        `}
                        <div class="border-t pt-4">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="col-span-2">
                                    <p class="text-sm text-gray-500">Nombre</p>
                                    <p class="font-medium text-gray-900">${data.nombre}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Especie</p>
                                    <p class="font-medium text-gray-900">${data.especie}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Sexo</p>
                                    <p class="font-medium text-gray-900 capitalize">${data.sexo || 'No especificado'}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-sm text-gray-500">Descripción</p>
                                    <p class="text-gray-700">${data.descripcion || 'Sin descripción'}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-sm text-gray-500">Dueño</p>
                                    <p class="font-medium text-gray-900">${data.usuario?.nom_us || 'No especificado'} ${data.usuario?.app_us || ''}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-sm text-gray-500">Email Dueño</p>
                                    <p class="font-medium text-gray-900">${data.usuario?.email || 'No especificado'}</p>
                                </div>
                                <div class="col-span-2">
                                    <p class="text-sm text-gray-500">Registrado</p>
                                    <p class="text-gray-700">${new Date(data.created_at).toLocaleDateString()}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.getElementById('viewModal').classList.remove('hidden');
                document.getElementById('viewModal').classList.add('flex');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar los detalles de la mascota');
            });
    }

    function closeViewModal() {
        document.getElementById('viewModal').classList.add('hidden');
        document.getElementById('viewModal').classList.remove('flex');
    }

    function editPet(id) {
        fetch(`/admin/mascotas/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editPetId').value = data.id;
                document.getElementById('editNombre').value = data.nombre || '';
                document.getElementById('editEspecieId').value = data.especie_id || '';
                document.getElementById('editSexo').value = data.sexo || '';
                document.getElementById('editDescripcion').value = data.descripcion || '';
                document.getElementById('editModal').classList.remove('hidden');
                document.getElementById('editModal').classList.add('flex');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar los datos de la mascota');
            });
    }

    function savePet() {
        const id = document.getElementById('editPetId').value;
        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('_method', 'PUT');
        formData.append('nom_mas', document.getElementById('editNombre').value);
        formData.append('especie_id', document.getElementById('editEspecieId').value);
        formData.append('sex_mas', document.getElementById('editSexo').value);
        formData.append('des_mas', document.getElementById('editDescripcion').value);

        fetch(`/admin/mascotas/${id}`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error al guardar los cambios');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al guardar los cambios');
        });
    }

    function deletePet(id) {
        if(confirm('¿Estás seguro de eliminar esta mascota? Esta acción no se puede deshacer.')) {
            fetch(`/admin/mascotas/${id}`, {
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
                    alert(data.message || 'Error al eliminar la mascota');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar la mascota');
            });
        }
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }

    window.onclick = function(event) {
        const viewModal = document.getElementById('viewModal');
        const editModal = document.getElementById('editModal');
        
        if (event.target === viewModal) {
            closeViewModal();
        }
        if (event.target === editModal) {
            closeEditModal();
        }
    }
</script>
@endsection











