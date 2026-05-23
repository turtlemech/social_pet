@extends('layouts.app')

@section('content')

@if(request()->creado)

<script>

setTimeout(() => {

    Swal.fire({

        icon: 'success',

        title: '🎉 Evento creado',

        text: 'Tu evento fue publicado correctamente.',

        confirmButtonColor: '#14b8a6',

        confirmButtonText: 'Continuar'

    }).then(() => {

        window.history.replaceState({}, document.title, "/eventos");

    });

}, 300);

</script>

@endif

@if(request()->eliminado)

<script>

setTimeout(() => {

    Swal.fire({

        icon: 'success',

        title: '🗑️ Evento eliminado',

        text: 'El evento fue eliminado correctamente.',

        confirmButtonColor: '#ef4444',

        confirmButtonText: 'Continuar'

    }).then(() => {

        window.history.replaceState({}, document.title, "/eventos");

    });

}, 300);

</script>

@endif

<div class="min-h-screen bg-[#f4f7fb]">

    <!-- HERO -->
    <section class="relative overflow-hidden">

        <!-- BG -->
        <div class="absolute inset-0 bg-gradient-to-r from-teal-600 via-emerald-500 to-cyan-500"></div>

        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-300 rounded-full blur-3xl"></div>
        </div>

        <!-- CONTENT -->
        <div class="relative max-w-7xl mx-auto px-6 py-24 text-white">

            <div class="max-w-3xl">

                <p class="uppercase tracking-[0.35em] text-sm font-bold opacity-80 mb-5">
                    SOCIALPET EVENTS
                </p>

                <h1 class="text-6xl md:text-7xl font-black leading-tight">

                    Vive experiencias únicas con tu mascota 🐾

                </h1>

                <p class="mt-7 text-xl text-white/80 leading-9">

                    Descubre ferias, caminatas, eventos pet-friendly, adopciones y actividades increíbles cerca de ti.

                </p>

                <!-- ACTIONS -->
                <div class="flex flex-wrap gap-4 mt-10">

                    <button
    onclick="abrirModalEvento()"
    class="bg-white text-teal-600 px-8 py-4 rounded-2xl font-bold shadow-2xl hover:scale-105 transition"
>
    Crear Evento
</button>

                    <a
                        href="#eventos"
                        class="bg-white/10 backdrop-blur-xl border border-white/20 text-white px-8 py-4 rounded-2xl font-semibold hover:bg-white/20 transition"
                    >
                        Explorar Eventos
                    </a>

                </div>

            </div>

        </div>

    </section>

    <!-- STATS -->
    <section class="max-w-7xl mx-auto px-6 -mt-10 relative z-20">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100">

                <p class="text-gray-500 text-sm">
                    Eventos disponibles
                </p>

                <h2 class="text-4xl font-black text-gray-900 mt-2">
                    {{ $eventos->count() }}
                </h2>

            </div>


            <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100">

                <p class="text-gray-500 text-sm">
                    Eventos destacados
                </p>

                <h2 class="text-4xl font-black text-gray-900 mt-2">

                    {{ $eventos->where('destacado', true)->count() }}

                </h2>

            </div>

        </div>

    </section>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-6 py-16">

<!-- MODAL CREAR EVENTO -->

<div
    id="crearEventoModal"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center p-6"
>

    <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-3xl p-8 relative overflow-y-auto max-h-[95vh]">

        <!-- CERRAR -->
        <button
            onclick="cerrarModalEvento()"
            class="absolute top-5 right-5 w-10 h-10 rounded-full bg-gray-100 hover:bg-red-500 hover:text-white transition"
        >
            ✕
        </button>

        <div class="mb-10">

            <p class="text-teal-500 font-bold uppercase tracking-widest text-sm mb-2">
                Crear experiencia
            </p>

            <h2 class="text-4xl font-black text-gray-900">
                Organiza un nuevo evento
            </h2>

            <p class="text-gray-500 mt-2">
                Comparte actividades increíbles con la comunidad pet lover.
            </p>

        </div>

        <form
            action="{{ route('eventos.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols-2 gap-5"
        >

            @csrf

            <!-- NOMBRE -->
            <input
    type="text"
    name="nom_eve"
    maxlength="30"
    placeholder="Nombre del evento"
    class="bg-gray-100 border-0 rounded-2xl p-4"
    required
>

<!-- FECHA -->

<input

    type="datetime-local"

    name="fch_eve"

    min="{{ now()->format('Y-m-d\TH:i') }}"

    class="bg-gray-100 border-0 rounded-2xl p-4"

    required

/>
            <!-- DESCRIPCION -->
            <textarea
                name="des_eve"
                placeholder="Describe el evento..."
                class="md:col-span-2 bg-gray-100 border-0 rounded-2xl p-4 h-32"
            ></textarea>
            <!-- LUGAR -->
<input
    type="text"
    name="nom_ubi"
    placeholder="Nombre del lugar o referencia"
    class="md:col-span-2 bg-gray-100 border-0 rounded-2xl p-4"
    required
>

<!-- MAPA -->
<div class="md:col-span-2">

    <label class="block text-sm font-bold text-gray-700 mb-2">
        Selecciona ubicación en el mapa
    </label>

    <div
        id="map"
        class="w-full h-80 rounded-2xl overflow-hidden"
    ></div>

</div>
            
           <!-- COORDENADAS OCULTAS -->
<input type="hidden" name="latitud" id="latitud">
<input type="hidden" name="longitud" id="longitud">


            <!-- CATEGORIA -->
            <select
                name="cat_eve"
                class="bg-gray-100 border-0 rounded-2xl p-4"
            >
                <option value="General">General</option>
                <option value="Adopción">Adopción</option>
                <option value="Caminata">Caminata</option>
                <option value="Competencia">Competencia</option>
                <option value="Veterinaria">Veterinaria</option>
                <option value="Feria">Feria</option>
            </select>

            <!-- CAPACIDAD -->
            <input
                type="number"
                name="capacidad_eve"
                placeholder="Capacidad máxima"
                class="bg-gray-100 border-0 rounded-2xl p-4"
            >

            <!-- IMAGEN -->
            <div class="md:col-span-2">

                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Imagen del evento
                </label>

                <input
                    type="file"
                    name="img_eve"
                    accept="image/*"
                    class="w-full bg-gray-100 border-0 rounded-2xl p-4"
                >

            </div>

            <!-- BTN -->
            <button
                class="md:col-span-2 bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500 text-white py-4 rounded-2xl font-bold text-lg shadow-2xl"
            >
                Crear Evento
            </button>

        </form>

    </div>

</div>

        <!-- EVENTS -->
        <section id="eventos">

            <div class="flex items-center justify-between mb-10 flex-wrap gap-4">

                <div>

                    <p class="text-teal-500 uppercase font-bold tracking-widest text-sm mb-2">
                        Eventos disponibles
                    </p>

                    <h2 class="text-4xl font-black text-gray-900">
                        Explora eventos 🐾
                    </h2>
                    <div class="flex flex-wrap gap-4 mt-6">

    <a

        href="{{ route('eventos.mis-eventos') }}"

        class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-2xl font-bold transition"

    >

        Mis Eventos

    </a>

    <a

        href="{{ route('eventos.participando') }}"

        class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-3 rounded-2xl font-bold transition"

    >

        Eventos Participando

    </a>

</div>

                </div>

            </div>
            <form method="GET" class="flex flex-wrap gap-4 mb-10">

   <input

    type="text"

    name="buscar"

    value="{{ request('buscar') }}"

    placeholder="Buscar eventos..."

    class="bg-white rounded-2xl px-5 py-3 shadow"

/>

    <select
    name="categoria"
    class="bg-white rounded-2xl px-5 py-3 shadow"
>

    <option value="">Todas las categorías</option>

    <option value="General"
        {{ request('categoria') == 'General' ? 'selected' : '' }}>
        General
    </option>

    <option value="Adopción"
        {{ request('categoria') == 'Adopción' ? 'selected' : '' }}>
        Adopción
    </option>

    <option value="Caminata"
        {{ request('categoria') == 'Caminata' ? 'selected' : '' }}>
        Caminata
    </option>

    <option value="Competencia"
        {{ request('categoria') == 'Competencia' ? 'selected' : '' }}>
        Competencia
    </option>

    <option value="Veterinaria"
        {{ request('categoria') == 'Veterinaria' ? 'selected' : '' }}>
        Veterinaria
    </option>

    <option value="Feria"
        {{ request('categoria') == 'Feria' ? 'selected' : '' }}>
        Feria
    </option>

</select>
<select

    name="estado"

    class="bg-white rounded-2xl px-5 py-3 shadow"

>

    <option value="">Todos los estados</option>

    <option value="activo"

        {{ request('estado') == 'activo' ? 'selected' : '' }}>

        Próximos

    </option>

    <option value="en_curso"

        {{ request('estado') == 'en_curso' ? 'selected' : '' }}>

        En curso

    </option>

    <option value="finalizado"

        {{ request('estado') == 'finalizado' ? 'selected' : '' }}>

        Finalizados

    </option>

    <option value="cancelado"

        {{ request('estado') == 'cancelado' ? 'selected' : '' }}>

        Cancelados

    </option>

</select>

<input
    type="date"
    name="fecha"
    value="{{ request('fecha') }}"
    min="{{ now()->format('Y-m-d') }}"
    class="bg-white rounded-2xl px-5 py-3 shadow"
/>

    <button
       class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-2xl font-bold transition"
    >
        Filtrar
    </button>

</form>

            <!-- GRID -->
            @if($eventos->count() > 0)

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

                    @foreach($eventos as $evento)

                        <x-eventos.event-card :evento="$evento" />

                    @endforeach

                </div>

            @else

                <!-- EMPTY -->
                <div class="bg-white rounded-[32px] shadow-xl p-16 text-center">

                    <div class="text-7xl mb-6">
                        🎟️
                    </div>

                    <h3 class="text-3xl font-black text-gray-900 mb-4">
                        Aún no hay eventos
                    </h3>

                    <p class="text-gray-500 max-w-xl mx-auto leading-8">

                        Sé el primero en crear un evento para la comunidad y comienza a conectar personas y mascotas.

                    </p>

                   <button

    onclick="abrirModalEvento()"

    class="inline-flex mt-8 bg-gradient-to-r from-teal-500 to-emerald-500 text-white px-8 py-4 rounded-2xl font-bold shadow-xl hover:scale-105 transition"

>

    Crear primer evento

</button>

                </div>

            @endif

        </section>

    </div>

</div>
<script>

let map;
let marker;
let mapInitialized = false;

function abrirModalEvento() {

    const modal = document.getElementById('crearEventoModal');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.body.style.overflow = 'hidden';

    if (!mapInitialized) {

        setTimeout(() => {

            map = L.map('map').setView([-16.5, -68.15], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            map.on('click', function(e) {

                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                document.getElementById('latitud').value = lat;
                document.getElementById('longitud').value = lng;

                if (marker) {
                    map.removeLayer(marker);
                }

                marker = L.marker([lat, lng]).addTo(map);
            });

            mapInitialized = true;

        }, 200);
    }
}

function cerrarModalEvento() {

    const modal = document.getElementById('crearEventoModal');

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    document.body.style.overflow = 'auto';
}

function cerrarEventoCreadoModal() {

    const modal = document.getElementById('eventoCreadoModal');

    if (modal) {

        modal.remove();

    }
}

</script>
<script>

function cerrarToastEvento() {

    const toast = document.getElementById('toastEvento');

    if (toast) {

        toast.remove();

    }
}

</script>
@endsection