<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['name', 'avatar', 'hasStory' => true, 'isAdd' => false]));

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

foreach (array_filter((['name', 'avatar', 'hasStory' => true, 'isAdd' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="flex flex-col items-center space-y-1 flex-shrink-0">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isAdd): ?>
        <div class="relative">
            <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-gray-300 to-gray-400 flex items-center justify-center cursor-pointer hover:scale-105 transition">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <span class="absolute -bottom-1 -right-1 bg-social-teal text-white text-xs rounded-full px-1.5 py-0.5">+</span>
        </div>
        <span class="text-xs font-medium text-gray-600">Add Story</span>
    <?php else: ?>
        <div class="relative">
            <div class="p-[2px] rounded-full <?php echo e($hasStory ? 'bg-gradient-to-tr from-yellow-400 to-red-500' : 'bg-gray-300'); ?>">
                <img src="<?php echo e($avatar); ?>" 
                     alt="<?php echo e($name); ?>" 
                     class="w-16 h-16 rounded-full object-cover border-2 border-white cursor-pointer hover:scale-105 transition">
            </div>
        </div>
        <span class="text-xs font-medium text-gray-700"><?php echo e($name); ?></span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/social_pet/resources/views/components/posts/story-circle.blade.php ENDPATH**/ ?>