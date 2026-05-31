@php

$tips = [

    [
        'emoji' => '🐶',
        'titulo' => 'Consejo del Día',
        'texto' => 'Los perros necesitan al menos 30 minutos de actividad física diaria.'
    ],

    [
        'emoji' => '🐱',
        'titulo' => 'Consejo del Día',
        'texto' => 'Los gatos deben tener siempre agua fresca disponible.'
    ],

    [
        'emoji' => '🦴',
        'titulo' => 'Consejo del Día',
        'texto' => 'Evita dar huesos cocidos a los perros porque pueden astillarse.'
    ],

    [
        'emoji' => '💉',
        'titulo' => 'Consejo del Día',
        'texto' => 'Mantén al día las vacunas y controles veterinarios.'
    ],

    [
        'emoji' => '🐾',
        'titulo' => 'Consejo del Día',
        'texto' => 'Dedica tiempo diario al juego para fortalecer el vínculo con tu mascota.'
    ],

];

$tip = $tips[array_rand($tips)];

@endphp

<div class="bg-white rounded-2xl shadow-sm p-5">

    <div class="flex items-center gap-3 mb-3">

        <div class="text-3xl">
            {{ $tip['emoji'] }}
        </div>

        <h3 class="font-bold text-gray-900">
            {{ $tip['titulo'] }}
        </h3>

    </div>

    <p class="text-sm text-gray-600 leading-relaxed">
        {{ $tip['texto'] }}
    </p>

</div>