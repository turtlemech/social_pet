<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => 'Feria de Mascotas 2026', 'date' => 'Este sábado', 'location' => 'Parque Central', 'image' => '🎪']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['title' => 'Feria de Mascotas 2026', 'date' => 'Este sábado', 'location' => 'Parque Central', 'image' => '🎪']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="bg-gradient-to-br from-orange-50 to-pink-50 rounded-xl shadow-sm p-4 border border-orange-100 hover:shadow-md transition">
    <div class="flex items-center space-x-2 mb-3">
        <span class="text-2xl"><?php echo e($image); ?></span>
        <h3 class="font-semibold text-gray-900">Próximo Evento</h3>
    </div>
    
    <p class="text-sm font-medium text-gray-900"><?php echo e($title); ?></p>
    
    <div class="flex items-center space-x-2 mt-2">
        <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-xs text-gray-600"><?php echo e($date); ?></p>
    </div>
    
    <div class="flex items-center space-x-2 mt-1">
        <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <p class="text-xs text-gray-600"><?php echo e($location); ?></p>
    </div>
    
    <button class="mt-3 w-full bg-orange-500 text-white px-3 py-1.5 rounded-lg text-sm hover:bg-orange-600 transition">
        Me interesa
    </button>
</div><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/social_pet/resources/views/components/dashboard/event-card.blade.php ENDPATH**/ ?>