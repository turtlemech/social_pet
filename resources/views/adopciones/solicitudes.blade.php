@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto py-8 px-4">

    <h1 class="text-3xl font-bold mb-6">
        📨 Solicitudes recibidas
    </h1>

    @forelse($solicitudes as $solicitud)

        <div class="bg-white rounded-xl shadow p-5 mb-4">

            <div class="flex items-center gap-4 mb-4">

                <img
                    src="{{ asset('storage/'.$solicitud->fot_mas) }}"
                    class="w-16 h-16 rounded-full object-cover">

                <div>
    <h2 class="font-bold text-lg">
        {{ $solicitud->nom_mas }}
    </h2>

    <p>
        {{ $solicitud->nom_us }}
        {{ $solicitud->app_us }}
    </p>

    <div class="mt-2">

        @if($solicitud->estado == 'pendiente')
            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                ⏳ Pendiente
            </span>

        @elseif($solicitud->estado == 'aprobada')
            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                ✅ Aprobada
            </span>

        @else
            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                ❌ Rechazada
            </span>

        @endif

    </div>
</div>

            </div>

            <div class="grid md:grid-cols-2 gap-3">

                <p><strong>📞 Teléfono:</strong> {{ $solicitud->telefono }}</p>

                <p><strong>🏙 Ciudad:</strong> {{ $solicitud->ciudad }}</p>

                <p><strong>🏠 Dirección:</strong> {{ $solicitud->direccion }}</p>

                <p><strong>🏡 Vivienda:</strong> {{ $solicitud->tipo_vivienda }}</p>

                <p><strong>📄 Tenencia:</strong> {{ $solicitud->tenencia_vivienda }}</p>

                <p><strong>👨‍👩‍👧 Personas:</strong> {{ $solicitud->personas_hogar }}</p>

            </div>

            <div class="mt-4">
                <strong>💚 Motivo:</strong>

                <p class="text-gray-700 mt-2">
                    {{ $solicitud->motivo_adopcion }}
                </p>
            </div>

            
           @if($solicitud->estado == 'pendiente')
           

<div class="flex gap-2 mt-5">

    <form
    action="{{ route('messages.startAdopcion', [

    'userId' => $solicitud->usuario_id,
    'adopcionId' => $solicitud->adopcion_id

]) }}"
    method="POST"
>

    @csrf

    <button
        type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold"
    >

        💬 Mensaje

    </button>

</form>

    <form action="{{ route('adopciones.aprobarSolicitud', $solicitud->id) }}"
          method="POST">

        @csrf
        @method('PATCH')

        <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold">

            ✅ Aprobar

        </button>

    </form>

    <form action="{{ route('adopciones.rechazarSolicitud', $solicitud->id) }}"
          method="POST">

        @csrf
        @method('PATCH')

        <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold">

            ❌ Rechazar

        </button>

    </form>

</div>

@endif
</div>
    @empty

        <div class="bg-white rounded-xl p-8 text-center">

            No tienes solicitudes todavía.

        </div>

    @endforelse

</div>

@endsection